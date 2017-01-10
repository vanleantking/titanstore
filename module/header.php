<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
	<title><?=isset($metatitle) ? $metatitle : $config['title']?></title>
	
	<meta name="description" content="<?=isset($metadescription) ? $metadescription : $config['description']?>">
	<meta name="keywords" content="<?=isset($metakeywords) ? $metakeywords : $config['keywords']?>">
	<meta property="og:title" content="<?=isset($metatitle) ? $metatitle : $config['title']?>" />
	<meta property="og:description" content="<?=isset($metadescription) ? $metadescription : $config['description']?>" />
	<meta property="og:image" content="<?=isset($metaimage) ? $metaimage : base_url('assets/images/logo.png')?>" />
	<meta property="og:type" content="website" />
	<meta property="og:site_name" content="<?=$config['name']?>" />
	<meta property="og:url" content="<?=isset($metaurl) ? $metaurl : base_url()?>" />
	
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	<link rel="icon" type="image/png" href="<?=base_url()?>favicon.png">

    <!-- Titan style -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/titan-style.css">
    <script src="<?=base_url()?>assets/js/titan-responsive.js"></script>
    
    <!-- Google font link -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/latofonts.css">

    <!-- Boostrap link -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-theme.min.css">
    <script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
	<script src="<?=base_url()?>assets/js/bootstrap-collapse.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap-transition.js"></script>
    <script src="<?=base_url()?>assets/js/bootstrap-tab.js"></script>

    <!-- Font awsome link -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/font-awesome.css">

    <!-- Menu link -->
	<link rel="stylesheet" href="<?=base_url()?>assets/css/menu-style.css"> <!-- Resource style -->
    <script src="<?=base_url()?>assets/js/modernizr.js"></script>

	<!-- Owl Carousel link -->
	<link href="<?=base_url()?>assets/css/owl.carousel.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/css/owl.theme.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/css/custom.css" rel="stylesheet">
	<link href="<?=base_url()?>assets/css/prettify.css" rel="stylesheet">
	<!-- <script src="assets/js/main.js"></script> -->
    <script src="<?=base_url()?>assets/js/application.js"></script>
    <script src="<?=base_url()?>assets/js/owl.carousel.min.js"></script>

    <!-- Flex Slider -->
    <link rel="stylesheet" href="<?=base_url()?>assets/css/flexslider.css" type="text/css">
    <script src="<?=base_url()?>assets/js/jquery.flexslider.js"></script>

    <!-- review img upload --
    <link href="<?=base_url()?>assets/css/fileinput.css" media="all" rel="stylesheet" type="text/css" />
    <script src="<?=base_url()?>assets/js/fileinput.js" type="text/javascript"></script-->
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-89389545-1', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
    <section id="menu-01" style="position: fixed;">
		<nav class="navbar navbar-default <?=$_GET['p']?'navscroll':''?>">
		  <div class="container-fluid menu-01">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		        <span class="sr-only">Toggle navigation</span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		      </button>
		      <a class="navbar-brand" href="<?=base_url()?>">
			    <?php if($_GET['p']){ ?>
		      	<img id="logo-black" src="<?=base_url()?>assets/image/logo/titan-logo.png" alt="<?=$config['name']?>">
			    <?php } else { ?>
		      	<img id="logo-white" src="<?=base_url()?>assets/image/logo/titan-logo-fff.png" alt="<?=$config['name']?>">
		      	<img id="logo-black" style="display: none;" src="<?=base_url()?>assets/image/logo/titan-logo.png" alt="<?=$config['name']?>">
		      	<?php } ?>
		      	<div class="titan-brand-name"><b>TITAN</b> STORE</div>
		      </a>
		    </div>

		    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		      <ul class="nav navbar-nav">
		        <li<?=$_GET['p']==''?' class="active"':''?>><a href="<?=base_url()?>"><i class="fa fa-home menu-icon"></i><span>TRANG CHỦ</span></a></li>
		        <li<?=$_GET['p']=='san-pham'?' class="active"':''?>><a href="<?=site_url('san-pham')?>"><i class="fa fa-th-large menu-icon"></i><span>TẤT CẢ SẢM PHẨM</span></a></li>
		        <li><a href="#" data-toggle="modal" data-target="#fillter-modal"><i class="fa fa-th-list menu-icon"></i><span>LỌC SẢN PHẨM</span></a></li>
		        <li<?=$_GET['p']=='tin-tuc'?' class="active"':''?>><a href="<?=site_url('tin-tuc')?>"><i class="fa fa-newspaper-o menu-icon"></i><span>TIN TỨC</span></a></li>
		        <li<?=$_GET['p']=='gallery'?' class="active"':''?>><a href="<?=site_url('gallery')?>"><i class="fa fa-picture-o menu-icon"></i><span>GALLERY</span></a></li>
		        <li<?=$_GET['p']=='gioi-thieu'?' class="active"':''?>><a href="<?=site_url('gioi-thieu')?>"><i class="fa fa-file-text-o menu-icon"></i><span>GIỚI THIỆU</span></a></li>
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
				<?php if(@$_SESSION['user']){ $user_login = getUser($_SESSION['user']); ?>
		        <li<?=$_GET['p']=='tai-khoan'?' class="active"':''?>><a href="<?=site_url('tai-khoan')?>"><i class="fa fa-sign-in titan-login-icon"></i><span><?=$user_login->name?></span></a></li>
		        <li><a href="<?=site_url('logout')?>"><i class="fa fa-logout"></i><span>Thoát</span></a></li>
				<?php } else { ?>
		        <li><a href="#" data-toggle="modal" data-target="#login-modal"><i class="fa fa-sign-in titan-login-icon"></i><span class="titan-login-icon-title">ĐĂNG NHẬP</span></a></li>
				<?php } ?>
		        <li<?=$_GET['p']=='tim-kiem'?' class="active"':''?>><a href="#" data-toggle="modal" data-target="#search-modal"><i class="fa fa-search titan-search-icon"></i><span class="titan-search-icon-title">TÌM KIẾM</span></a></li>
		      </ul>
		    </div>
		  </div>
		</nav>
	</section>
	
	<div class="modal fade" id="search-modal" tabindex="-1" role="dialog">
	  	<div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
				<form action="<?=site_url('tim-kiem')?>">
		      		<div class="modal-body container-fluid">
			      		<input type="search" name="s" placeholder="Bạn đang cần tìm gì?" value="<?=@$_GET['s']?>">
  						<button type="submit"><i class="fa fa-search ttr-search-button"></i></button>
  					</div>
				</form>
		    </div>
	  	</div>
	</div>
	
	<div class="modal fade" id="fillter-modal" tabindex="-1" role="dialog">
	  	<div class="modal-dialog modal-lg" role="document">
		    <div class="modal-content">
		      	<div class="modal-header">
		      		<div class="fillter-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
		        	<h4 class="modal-title">LỌC SẢN PHẨM</h4>
		      	</div>
		      	<div class="modal-body container-fluid all-product-fillter">
			      	
			  		<input type="hidden" id="filtercategory" value="<?=@$_GET['category']?>">
		      		<div class="fillter-box">
			      		<div class="btn-group">
						  	<button type="button" class="btn btn-light fillter-data-button filtercategoryname" data-toggle="dropdown">
				        	<?php
					        	if(isset($_GET['category'])){
									$row = get_post('category-product', array(
										'status' => 1,
										'id' => $_GET['category'],
									));
									echo @$row->title;
					        	}
					        	else{
						        	echo 'Mặt hàng';
					        	}
				        	?>
						  	</button>
						  	<button type="button" class="btn btn-light dropdown-toggle fillter-data-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    	<span class="caret"></span>
						    	<span class="sr-only">Toggle Dropdown</span>
						  	</button>
						  	<ul class="dropdown-menu">
						  		<div class="fillter-category resultCategory">
								<?php
									$rows = get_posts('category-product', array(
										'status' => 1,
										'order_by' => 'ordering ASC',
									));
									if($rows){ foreach($rows as $row){ ?>
									<li><a href="#" id="<?=$row->id?>" class="filtercategory"><?=$row->title?></a></li>
								<?php }} ?>
							    </div>
						  	</ul>
						</div>
					</div>

			  		<input type="hidden" id="filterbrand" value="<?=@$_GET['brand']?>">
			      	<div class="fillter-box">
			      		<div class="btn-group">
						  	<button type="button" class="btn btn-light fillter-data-button filterbrandname" data-toggle="dropdown">
				        	<?php
					        	if(isset($_GET['brand'])){
									$row = get_post('brand', array(
										'status' => 1,
										'id' => $_GET['brand'],
									));
									echo @$row->title;
					        	}
					        	else{
						        	echo 'Thương hiệu';
					        	}
				        	?>
						  	</button>
						  	<button type="button" class="btn btn-light dropdown-toggle fillter-data-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    	<span class="caret"></span>
						    	<span class="sr-only">Toggle Dropdown</span>
						  	</button>
						  	<ul class="dropdown-menu">
							    <div class="fillter-category resultBrand">
								<?php
									$rows = get_posts('brand', array(
										'status' => 1,
										'order_by' => 'ordering ASC',
									));
									if($rows){ foreach($rows as $row){ ?>
									<li><a href="#" id="<?=$row->id?>" class="filterbrand"><?=$row->title?></a></li>
								<?php }} ?>
							    </div>
						  	</ul>
						</div>
					</div>

			  		<input type="hidden" id="filtersize" value="<?=@$_GET['size']?>">
					<div class="fillter-box">
			      		<div class="btn-group">
						  	<button type="button" class="btn btn-light fillter-data-button filtersizename" data-toggle="dropdown">
				        	<?php
					        	if(isset($_GET['size'])){
									$row = get_post('size', array(
										'status' => 1,
										'id' => $_GET['size'],
									));
									echo @$row->title;
					        	}
					        	else{
						        	echo 'Size';
					        	}
				        	?></button>
						  	<button type="button" class="btn btn-light dropdown-toggle fillter-data-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    	<span class="caret"></span>
						    	<span class="sr-only">Toggle Dropdown</span>
						  	</button>
						  	<ul class="dropdown-menu">
						  		<div class="fillter-category resultSize">
								<?php
									$rows = get_posts('size', array(
										'status' => 1,
										'parent' => 0,
										'order_by' => 'ordering ASC',
									));
									if($rows){ foreach($rows as $row){ ?>
								    <div class="fillter-category">
								  		<li class="fillter-category-title"><?=$row->title?></li>
										<?php
											$rows2 = get_posts('size', array(
												'status' => 1,
												'parent' => $row->id,
												'order_by' => 'ordering ASC',
											));
											if($rows2){ foreach($rows2 as $row2){ ?>
											<li><a href="#" id="<?=$row2->id?>" class="filtersize"><?=$row2->title?></a></li>
										<?php }} ?>
								    </div>
								<?php }} ?>
							    </div>
						  	</ul>
						</div>
					</div>

			  		<input type="hidden" id="filterprice" value="<?=@$_GET['price']?>">
					<div class="fillter-box">
			      		<div class="btn-group">
						  	<button type="button" class="btn btn-light fillter-data-button filterpricename" data-toggle="dropdown">
				        	<?php
					        	if(isset($_GET['price'])){
									echo $_GET['price'] ? 'Từ cao đến thấp' : 'Từ thấp đến cao';
					        	}
					        	else{
						        	echo 'Giá';
					        	}
				        	?></button>
						  	<button type="button" class="btn btn-light dropdown-toggle fillter-data-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
						    	<span class="caret"></span>
						    	<span class="sr-only">Toggle Dropdown</span>
						  	</button>
						  	<ul class="dropdown-menu">
						  		<div class="fillter-category">
								    <li><a href="#" id="0" class="filterprice">Từ thấp đến cao</a></li>
								    <li><a href="#" id="1" class="filterprice">Từ cao đến thấp</a></li>
						    	</div>
						  	</ul>
						</div>
					</div>
					<div style="text-align: center;">
			      		<button class="fillter-button btfilter">LỌC</button>
		      		</div>
		      	</div>
		    </div>
	  	</div>
	</div>

	<div class="modal fade" id="login-modal" tabindex="-1" role="dialog">
	  	<div class="modal-dialog" role="document">
		    <div class="modal-content">
			<form method="post" id="form-login">
		      	<div class="modal-header">
		      		<div class="login-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
		        	<h4 class="modal-title">ĐĂNG NHẬP</h4>
		      	</div>
		      	<div class="modal-body">
		      		<div class="login-call-to-action"><i class="fa fa-gift" style="font-size: 26px;"></i><br>Đăng nhập để nhận nhiều ưu đãi từ TiTan Shop</div>
		        	<input type="text" name="username" placeholder="Tên đăng nhập (số điện thoại)">
		        	<input type="password" name="password" placeholder="Mật khẩu">
		        	<a href="<?=site_url('quen-mat-khau')?>">Quên mật khẩu?</a>
		        	<button type="submit" class="login-modal-button">ĐĂNG NHẬP</button>
		        	<div class="clearfix"></div>
		        	<a href="<?=site_url('dang-ky')?>"><div class="login-modal-button">ĐĂNG KÝ</div></a>
		      	</div>
			</form>
		    </div>
	  	</div>
	</div>

	<section class="shopping">
		<a href="<?=site_url('gio-hang')?>">
			<div>
				<i class="fa fa-shopping-cart"></i>
				<span class="number-shopping"><?=empty($_SESSION['carts']['quantity']) ? 0 : $_SESSION['carts']['quantity']?></span>
			</div>
		</a>
	</section>
	
	<section class="social-tab">
		<a href="<?=$config['facebook']?>" target="_blank">
			<i class="fa fa-facebook-official"></i>
		</a>
		<div class="clearfix"></div>
		<a href="<?=$config['google']?>" target="_blank">
			<i class="fa fa-google-plus-square"></i>
		</a>
		<div class="clearfix"></div>
		<a href="<?=$config['instagram']?>" target="_blank">
			<i class="fa fa fa-instagram"></i>
		</a>
	</section>

	<a href="#0" class="cd-top">Top</a>