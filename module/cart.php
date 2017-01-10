<?php
$metatitle = 'Giỏ hàng';

if($_SERVER['REQUEST_METHOD']=='POST')
{
	if($_POST['update_cart_action'] == 'update') {
		$quantity = $total = 0;
		
		foreach($_POST['qty'] as $id => $qty)
		{
			$_SESSION['cart'][$id] = $qty;
		
			$row = get_post('product', array(
				'id' => $id,
				'status' => 1,
			));
			
			if($row->discount){
				$total += ($row->price - ($row->price * $row->discount / 100) ) * $qty;
			}
			else{
				$total += $row->price * $qty;
			}
			
			$quantity += $qty;
		}
		
		$_SESSION['carts'] = array(
			'quantity' => $quantity,
			'total' => $total,
		);
	}
	else {
		unset($_SESSION['cart'], $_SESSION['carts']);
	}
	
	header('Location: '. base_url('gio-hang'));
}

include dirname(__FILE__) .'/header.php'; ?>
    <section class="product-shopping">
    	<div class="container" id="form-order">
    		<div class="col-md-8 col-xs-12 shopping-col">
    			<div class="shopping-title">
					<span><i class="fa fa-shopping-cart"></i></span>Giỏ hàng
				</div>
				<div class="list-product">
				<?php if(!empty($_SESSION['cart'])){
					$i = 1;
					foreach($_SESSION['cart'] as $id => $qty){
						$row = get_post('product', array(
							'id' => $id,
							'status' => 1,
						));
					
						if($row->discount){
							$price = ( $row->price - ($row->price * $row->discount / 100) );
						}
						else{
							$price = $row->price;
						}
						
						$size = get_post('size', array(
							'id' => $_SESSION['size'][$id],
							'status' => 1,
						));
						
						$color = get_post('color', array(
							'status' => 1,
							'id' => $_SESSION['color'][$id],
						));
				?>
	    			<div class="single-product tr">
	    				<div class="col-md-4">
	    					<div id="shopping-product-01" class="shopping-product-img" style="background-image: url(<?=base_url('upload/'. $row->photo)?>);"></div>
	    				</div>
	    				<div class="col-md-8">
	    					<div class="full-row">
		    					<div class="pull-left product-detail product-name"><?=$row->title?></div>
		    					<div class="pull-right product-detail product-price"><?=format_price($price)?></div>
		    					<div class="clearfix"></div>
	    					</div>		    					
	    					<div class="product-detail">Size: <span class="detail"><?=@$size->title?></span></div>
	    					<div class="product-detail">Màu sắc: <span class="detail"><?=@$color->title?></span></div>
	    					<div class="product-detail">Số lượng: <span class="detail"><?=$qty?></span></div>
	    					<div class="btn-control">
		    					<button type="button" class="btn-default btn-cart-control delcart" id="<?=$id?>">XÓA</button>
		    					<button type="button" class="btn-default btn-cart-control editcart" data-toggle="modal" data-target="#edit-product" id="<?=$id?>">Chỉnh sửa</button>
	    					</div>
			    		</div>
		    		</div>
	            <?php $i++; }} ?>
		    	</div>
		    	<div class="msg"></div>
    		</div>
    		<div class="col-md-4 col-xs-12 shopping-col">
    			<aside>
	    			<div class="shopping-title">
	    				<span><i class="fa fa-pencil-square-o"></i></span>THÔNG TIN GIAO NHẬN
	    			</div>
    				<div class="shopping-user-infor">
    					<div class="shopping-user-infor-box">
							<i class="fa fa-user"></i>
							<input type="text" class="form-control" name="name" id="name" placeholder="Họ và tên*">
						</div>
						<div class="clearfix"></div>
						<div class="shopping-user-infor-box">
							<i class="fa fa-phone"></i>
							<input type="email" class="form-control" name="email" id="email" placeholder="Email*">
						</div>
						<div class="clearfix"></div>
						<div class="shopping-user-infor-box">
							<i class="fa fa-phone"></i>
							<input type="text" class="form-control" name="phone" id="phone" placeholder="Số điện thoại*">
						</div>
						<div class="clearfix"></div>
						<div class="shopping-user-infor-box">
							<i class="fa fa-map-marker"></i>
							<textarea type="text" class="form-control" name="address" id="address" rows="3" placeholder="Địa chỉ nhận hàng*"></textarea>
						</div>
						<div class="clearfix"></div>
						<div class="shopping-user-infor-box">
							<i class="fa fa-sticky-note-o"></i>
							<textarea type="text" class="form-control" name="message" id="message" rows="2" placeholder="Ghi chú"></textarea>
						</div>
    				</div>
    				<div class="shopping-warning-note hidden">
						<div class="warning-note">Vui lòng điền đầy đủ thông tin <br> trước khi đặt hàng</div>
						<div class="warning-note-bottom"></div>
					</div>
    			</aside>
    			<aside>
	    			<div class="shopping-title">
	    				<span><i class="fa fa-pencil-square-o"></i></span>Giá
	    			</div>
	    			<div class="total-box">
	    				<div class="totals pull-left">Tổng cộng:</div>
	    				<div class="total-summary pull-right"><?=isset($_SESSION['carts']) ? format_price($_SESSION['carts']['total']) : 0 .' đ'?></div>
	    				<div class="clearfix"></div>
	    			</div>
	    		</aside>
	    		<div class="checkout">
					<button class="btn btn-default btn-checkout lock ordercart">ĐẶT HÀNG</button>
				</div>
	    		
    		</div>
    	</div>

    </section>

    <!-- **************************************************** -->
    				<!-- SHOPPING EDIT POPUP -->
    <!-- **************************************************** -->

    <div class="modal fade" id="edit-product" tabindex="-1" role="dialog">
	  	<div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		    	<div class="fillter-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
		      	<div class="modal-body container-fluid raw" id="editcartresult">
		      	</div>
		    </div>
	  	</div>
	</div>
<?php include dirname(__FILE__) .'/footer.php'; ?>