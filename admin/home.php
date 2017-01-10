<?php
	
if(empty($_SESSION['adminID']))
{
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
	    $db->select(array(
	        'tbl_name' => 'users',
	        'field' => array('*'),
	        'method' => PDO::FETCH_OBJ,
		    'condition' => ' WHERE username = "'. $_POST['username'] .'" AND password = "'. md5($_POST['password']) .'" AND status = "1"'
	    ));
	    $login = $db->result();
	    if($login){
	       $_SESSION['adminID'] = $login[0]->id;
		   header('Location: '. base_url());exit;
	    }
	}
	
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Admin CMS - <?=$config['title']?></title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Roboto:400,700">
<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/bootstrap-theme.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/font-awesome.min.css">
<link rel="stylesheet" href="<?=base_url()?>assets/css/style.css">
<script src="<?=base_url()?>assets/js/jquery-2.1.4.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/js/script.js"></script>
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="login">
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-4 col-sm-offset-4">
	        <div class="main">
	            <form name="adminForm" method="post" class="form-signin" role="form">
	                <h2 class="form-signin-heading">Đăng nhập hệ thống</h2>
	                <p><input type="text" class="form-control" name="username" placeholder="Tài khoản" value="" required autofocus></p>
	                <input type="password" class="form-control" name="password" placeholder="Mật khẩu" value="" required>
	                <button class="btn btn-lg btn-primary btn-block" type="submit">Đăng nhập</button>
	            </form>
	        </div>
	        <p class="back"><i class="fa fa-reply"></i> <a href="<?=base_url('../')?>">Trở về trang chủ</a></p>
        </div>
    </div>
</div>
</body>
</html>
<?php
}
else {
	$db->select(array(
	    'tbl_name' => 'post',
	    'field' => array('COUNT(id) as total'),
	    'method' => PDO::FETCH_OBJ,
	    'condition' => 'WHERE extension = "article"'
	));
	$article = $db->result();
	
	$db->select(array(
	    'tbl_name' => 'post',
	    'field' => array('COUNT(id) as total'),
	    'method' => PDO::FETCH_OBJ,
	    'condition' => 'WHERE extension = "product"'
	));
	$product = $db->result();
	
	$db->select(array(
	    'tbl_name' => 'post',
	    'field' => array('COUNT(id) as total'),
	    'method' => PDO::FETCH_OBJ,
	    'condition' => 'WHERE extension = "condition"'
	));
	$condition = $db->result();
	
	$db->select(array(
	    'tbl_name' => 'post',
	    'field' => array('COUNT(id) as total'),
	    'method' => PDO::FETCH_OBJ,
	    'condition' => 'WHERE extension = "news"'
	));
	$news = $db->result();
	
	$db->select(array(
	    'tbl_name' => 'post',
	    'field' => array('COUNT(id) as total'),
	    'method' => PDO::FETCH_OBJ,
	    'condition' => 'WHERE extension = "promotion"'
	));
	$promotion = $db->result();
	
	$db->select(array(
	    'tbl_name' => 'users',
	    'field' => array('COUNT(id) as total'),
	    'method' => PDO::FETCH_OBJ,
	));
	$users = $db->result();
?>
<?php include 'header.php'; ?>
            <h1 class="page-header">Dashboard</h1>
            <div class="row placeholders">
                <div class="col-sm-3">
                    <div class="placeholder color-1">
                        <div class="num"><?=$users[0]->total?></div>
                        <div class="name"><i class="fa fa-user"></i> Thành viên</div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="placeholder color-2">
                        <div class="num"><?=$article[0]->total?></div>
                        <div class="name"><i class="fa fa-edit"></i> Bài viết</div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="placeholder color-3">
                        <div class="num"><?=$news[0]->total?></div>
                        <div class="name"><i class="fa fa-newspaper-o"></i> Tin tức</div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="placeholder color-4">
                        <div class="num"><?=$product[0]->total?></div>
                        <div class="name"><i class="fa fa-paste"></i> Sản phẩm</div>
                    </div>
                </div>
            </div>
            <div class="row placeholders">
                <div class="col-sm-3">
                    <div class="placeholder color-5">
                        <div class="num"><?=$promotion[0]->total?></div>
                        <div class="name"><i class="fa fa-opencart"></i> Khuyến mãi</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
<?php } ?>