<?php

$and = "";

if($_POST['p'] == 'san-pham-moi'){
	$and .= "AND sale = 0 ";
}

if($_POST['p'] == 'san-pham-sale'){
	$and .= "AND sale = 1 ";
}

$sql = "SELECT * FROM post WHERE extension = 'product' AND status = 1 ". @$and ." ORDER BY created DESC ";
$db->query($sql);
$num = $db->total();

$sql = $num > 0 ? $sql ." Limit ". ((int) $_POST['offset'] * 30) .", 30" : $sql;
$db->query($sql);
$rows = $db->result();

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