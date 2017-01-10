<?php
$exclude = '';
$metatitle = 'Thương hiệu';
$and = @$_GET['a'] ? ' AND alias = "'. $_GET['a'] .'"' : '';
$breadcrum = '<li>Thương hiệu</li>';


if(@$_GET['a']){
	$db->query("SELECT * FROM post WHERE extension IN ('brand') AND status = 1 ". $and);
	$items = $db->result();
	$item = @$items[0];
	
	$breadcrum = '<li class="active">'. translate(@$item->title, @$item->title_en) .'</li>';
	$metatitle = translate(@$item->title, @$item->title_en);
	$metadescription = @$item->intro;
	$metakeywords = translate(@$item->title, @$item->title_en);
}


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
				
				$sql = "SELECT * FROM post WHERE extension = 'product' AND status = 1 AND brand = '". $item->id ."' ORDER BY created DESC ";
				$db->query($sql);
				$num = $db->total();
				
				$sql = $num > 0 ? $sql ." Limit $offset, $rowpage" : $sql;
				$db->query($sql);
				$rows = $db->result();
				
				$paging = form_paging($getpage, $num, $rowpage, $curpage, site_url('thuong-hieu/'. $item->alias), 1);
				
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