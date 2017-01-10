<?php
$item = get_post('product', array(
	'id' => $_POST['id'],
	'status' => 1,
));
	
$brand = get_post('brand', array(
	'status' => 1,
	'id' => $item->brand,
));
	
$csize = get_post('size', array(
	'status' => 1,
	'id' => $_SESSION['size'][$item->id],
));


$price_new = $item->price - ($item->price * $item->discount / 100);
$price_new = $price_new > 0 ? $price_new : 0;

?>

<div class="edit-modal-img col-md-6" style="background-image: url(<?=base_url('upload/'. $item->photo)?>);"></div>
<div class="product-show col-md-6">
	<div class="product-infor">
	<p class="product-brand"><?=$brand->title?></p>
	<p class="product-id"><?=$item->title?></p>
	<?php if($item->discount){ ?>
		<p class="product-price"><strike><?=format_price($item->price)?></strike></p>
		<p class="product-price"><?=format_price($price_new)?></p>
	<?php } else { ?>
		<p class="product-price"><?=format_price($item->price)?></p>
	<?php } ?>
</div>

<div class="clearfix"></div>
<div class="product-show-title">CHỌN SIZE</div>
<div class="product-size-box">
	<div class="product-size">
		<div class="btn-group" role="group">
		    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		      	<span class="size"><?=$csize->title?></span>
		      	<span class="caret"></span>
		    </button>
		    <div class="clearfix"></div>
		    <div class="dropdown-spacing"></div>
		    <ul class="dropdown-menu">
			<?php
				$sizes = explode(',', $item->size);
				foreach($sizes as $size){
					$_size = get_post('size', array(
						'status' => 1,
						'id' => $size,
					));
					if($_size->parent){
			?>
		      	<li class="selsize" id="<?=$_size->id?>"><?=$_size->title?></li>
			<?php }} ?>
		    </ul>
		  </div>
	</div>

	<div class="product-size number">
		<div class="btn-group" role="group">
		    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
		      Số lượng (<span class="qty"><?=$_SESSION['cart'][$item->id]?></span>)
		      <span class="caret"></span>
		    </button>
		    <div class="clearfix"></div>
		    <div class="dropdown-spacing"></div>
		    <ul class="dropdown-menu">
		      	<li class="active selqty" id="1">01</li>
		      	<li class="selqty" id="2">02</li>
		      	<li class="selqty" id="3">03</li>
		      	<li class="selqty" id="4">04</li>
		      	<li class="selqty" id="5">05</li>
		      	<li class="selqty" id="6">06</li>
		      	<li class="selqty" id="7">07</li>
		      	<li class="selqty" id="8">08</li>
		      	<li class="selqty" id="9">09</li>
		      	<li class="selqty" id="10">10</li>
		    </ul>
		  </div>
	</div>
</div>

<div class="clearfix"></div>
<div class="call-to-action addcart" quantity="1" size="<?=$_SESSION['size'][$item->id]?>" color="<?=$_SESSION['color'][$item->id]?>" id="<?=$item->id?>" data-dismiss="modal" aria-label="Close">Hoàn thành</div>
</div>