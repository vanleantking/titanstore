<?php
	$metatitle  = 'Tìm kiếm';
	
	include dirname(__FILE__) .'/header.php';
		
	$layout = 'sub-banner'; include dirname(__FILE__) .'/loop.php';
	$layout = 'brand'; include dirname(__FILE__) .'/loop.php';
	$layout = 'filter'; include dirname(__FILE__) .'/loop.php';
?>
	<element id="all-product" class="product-element">
		<div class="container">
            <?php
				$rowpage = 30;
				$curpage = 2;
				$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
				$offset = ($getpage - 1) * $rowpage;
				
				$arg = array();
				$and = "";
				
				if(isset($_GET['s']) && $_GET['s']){
					$and .= "AND title LIKE '%". $_GET['s'] ."%' ";
					$arg[] = "s=". $_GET['s'];
				}
				
				if(isset($_GET['brand']) && $_GET['brand']){
					$and .= "AND brand = '". $_GET['brand'] ."' ";
					$arg[] = "brand=". $_GET['brand'];
				}
				
				if(isset($_GET['size']) && $_GET['size']){
					$and .= "AND size LIKE '%". $_GET['size'] ."%' ";
					$arg[] = "size=". $_GET['size'];
				}
				
				if(isset($_GET['category']) && $_GET['category']){
					$and .= "AND parent = '". $_GET['category'] ."' ";
					$arg[] = "category=". $_GET['category'];
				}
				
				if(isset($item)){
					$cids = get_ids('category-product', @$item->id);
					$cids = array_merge(array(@$item->id), $cids);
					$and .= "AND parent IN (". implode(',', $cids) .") ";
				}
				
				$order_by = "ORDER BY created DESC ";
				
				if(isset($_GET['price'])){
					$order_by = $_GET['price'] == 1 ? "ORDER BY price DESC " : "ORDER BY price ASC ";
					$arg[] = "price=". $_GET['price'];
				}
				
				$arg = $arg ? '?'. implode('&', $arg) : '';
				
				$sql = "SELECT * FROM post WHERE extension = 'product' AND status = 1 ". @$and ." ". $order_by;
				$db->query($sql);
				$num = $db->total();
				
				$sql = $num > 0 ? $sql ." Limit $offset, $rowpage" : $sql;
				$db->query($sql);
				$rows = $db->result();
				
				$paging = form_paging($getpage, $num, $rowpage, $curpage, site_url('tim-kiem/'. @$item->alias), 1, $arg);
				
				if($rows)
				{
					$layout = 'product';
					$i = 1;
					foreach($rows as $row)
					{
						$brand = get_post('brand', array(
							'status' => 1,
							'id' => $row->brand,
						));
					
						$category = get_post('category-product', array(
							'status' => 1,
							'id' => $row->parent,
						));
						
						$price_new = $row->price - ($row->price * $row->discount / 100);
						$price_new = $price_new > 0 ? $price_new : 0;
						include dirname(__FILE__) .'/loop.php';
						$i++;
					}
				}
			?>
			<div class="clearfix"></div>
			<section><?=$paging?></section>
		</div>
	</element>
<?php include dirname(__FILE__) .'/footer.php'; ?>