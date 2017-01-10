<?php
	
include 'image_moo.php';


$file = 'upload/'. $_GET['f'];
$w = empty($_GET['w']) ? $_GET['h'] : $_GET['w'];
$h = empty($_GET['h']) ? $_GET['w'] : $_GET['h'];

$image_moo = new Image_moo();
$image_moo->load($file);
$image_moo->set_jpeg_quality(100);

if(empty($_GET['c'])){
	$image_moo->resize($w, $h);
}
else{
	$image_moo->resize_crop($w, $h);
}

$image_moo->save_dynamic();