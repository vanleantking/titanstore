<?php
$adminlogged = getUser();

?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Admin CMS - <?=$config['title']?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="<?=base_url()?>assets/images/favicon.png">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:400,700">
<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/summernote.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/magnific-popup.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/style.css">
<script>var base_url = '<?=base_url()?>';</script>
<script src="<?=base_url()?>assets/js/jquery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/js/summernote.js"></script>
<script src="<?=base_url()?>assets/js/summernote-vi-VN.js"></script>
<script src="<?=base_url()?>assets/js/summernote-ext-video.js"></script>
<script src="<?=base_url()?>assets/js/jquery.magnific-popup.js"></script>
<script src="<?=base_url()?>assets/ckeditor/ckeditor.js"></script>
<script src="<?=base_url()?>assets/js/jscolor.min.js"></script>
<script src="<?=base_url()?>assets/js/script.js"></script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body>
<div class="header navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar">
                <span class="sr-only">Trình đơn</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=base_url()?>">ADMINISTRATOR</a>
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="<?=base_url('../')?>" target="_blank"><i class="fa fa-external-link"></i> <?=$config['title']?></a></li>
                <li><a href="<?=base_url('logout')?>"><i class="fa fa-sign-out"></i> Thoát</a></li>
            </ul>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                <li<?=@$_GET['p']==''?' class="active"':''?>><a href="<?=base_url()?>"><i class="fa fa-home"></i> Dashboard</a></li>
                
                <li<?=@$_GET['p']=='setting'?' class="active"':''?>><a href="<?=base_url('setting')?>"><i class="fa fa-cogs"></i> Cài đặt</a></li>
                
                <li<?=@$_GET['p']=='orders'?' class="active"':''?>><a href="<?=base_url('orders')?>"><i class="fa fa-registered"></i> Đơn hàng</a></li>
                
                <li<?=@$_GET['p']=='post' && in_array(@$_GET['e'], array('banner', 'ad')) ? ' class="active"' : ''?>>
                	<a href="#" class="toggle"><i class="fa fa-angle-down"></i> Banner</a>
                	<ul>
						<li<?=@$_GET['p']=='post' && @$_GET['e']=='banner'?' class="active"':''?>><a href="<?=base_url('post/e/banner')?>"><i class="fa fa-buysellads"></i> Herro Banner</a> </li>
						<li<?=@$_GET['p']=='post' && @$_GET['e']=='ad'?' class="active"':''?>><a href="<?=base_url('post/e/ad')?>"><i class="fa fa-buysellads"></i> Quảng cáo</a> </li>
                	</ul>
                </li>
                
                <li<?=@$_GET['p']=='post' && @$_GET['e']=='gallery'?' class="active"':''?>><a href="<?=base_url('post/e/gallery')?>"><i class="fa fa-image"></i> Gallery</a> </li>
                
                <li<?=@$_GET['p']=='post' && @$_GET['e']=='testimonial'?' class="active"':''?>><a href="<?=base_url('post/e/testimonial')?>"><i class="fa fa-comments"></i> Khách hàng đánh giá</a> </li>
                
                <li<?=@$_GET['p']=='post' && in_array(@$_GET['e'], array('article', 'news', 'promotion')) ? ' class="active"' : ''?>>
                	<a href="#" class="toggle"><i class="fa fa-angle-down"></i> Bài viết</a>
                	<ul>
						<li<?=@$_GET['p']=='post' && @$_GET['e']=='article'?' class="active"':''?>><a href="<?=base_url('post/e/article')?>"><i class="fa fa-edit"></i> Giới thiệu</a> </li>
		                <li<?=@$_GET['p']=='post' && @$_GET['e']=='news'?' class="active"':''?>><a href="<?=base_url('post/e/news')?>"><i class="fa fa-newspaper-o"></i> Tin tức</a> </li>
		                <li<?=@$_GET['p']=='post' && @$_GET['e']=='promotion'?' class="active"':''?>><a href="<?=base_url('post/e/promotion')?>"><i class="fa fa-edit"></i> Khuyến mãi</a> </li>
                	</ul>
                </li>
                
                <li<?=@$_GET['p']=='post' && in_array(@$_GET['e'], array('category-product', 'product', 'brand', 'size', 'color')) ? ' class="active"' : ''?>>
                	<a href="#" class="toggle"><i class="fa fa-angle-down"></i> Sản phẩm</a>
                	<ul>
		                <li<?=@$_GET['p']=='post' && @$_GET['e']=='category-product'?' class="active"':''?>><a href="<?=base_url('post/e/category-product')?>"><i class="fa fa-list-alt"></i> Phân loại</a> </li>
		                <li<?=@$_GET['p']=='post' && @$_GET['e']=='product'?' class="active"':''?>><a href="<?=base_url('post/e/product')?>"><i class="fa fa-paste"></i> Sản phẩm</a> </li>
						<li<?=@$_GET['p']=='post' && @$_GET['e']=='brand'?' class="active"':''?>><a href="<?=base_url('post/e/brand')?>"><i class="fa fa-edit"></i> Thương hiệu</a> </li>
						<li<?=@$_GET['p']=='post' && @$_GET['e']=='size'?' class="active"':''?>><a href="<?=base_url('post/e/size')?>"><i class="fa fa-edit"></i> Kích thướt</a> </li>
						<li<?=@$_GET['p']=='post' && @$_GET['e']=='color'?' class="active"':''?>><a href="<?=base_url('post/e/color')?>"><i class="fa fa-edit"></i> Màu sắc</a> </li>
                	</ul>
                </li>
                
                <li<?=@$_GET['p']=='users' && in_array(@$_GET['e'], array('1', '0')) ? ' class="active"' : ''?>>
                	<a href="#" class="toggle"><i class="fa fa-angle-down"></i> Thành viên</a>
                	<ul>
		                <?php if($adminlogged->gid == 1){ ?>
		                <li<?=@$_GET['p']=='users' && @$_GET['e']=='1'?' class="active"':''?>> <a href="<?=base_url('users/e/1')?>"> <i class="fa fa-user"></i> Quản trị viên</a></li>
		                <?php } ?>
		                <li<?=@$_GET['p']=='users' && @$_GET['e']=='0'?' class="active"':''?>> <a href="<?=base_url('users/e/0')?>"> <i class="fa fa-user"></i> Khách hàng</a></li>
                	</ul>
                </li>
                
            </ul>
        </div>
        <div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main">