<?php

include 'functions.php';

switch(@$_GET['p']){
    case "pfilter":
    	pfilter();
    	break;
    case "logout":
        unset($_SESSION['user']);
        header('Location: '. base_url());
        break;
    case "login":
    	login();
    	break;
    case "order":
    	order();
    	break;
    case "delcart":
    	delcart();
    	break;
    case "cart":
    	cart();
    	break;
    case "contact":
    	contact();
    	break;
    case "subscribe":
    	subscribe();
    	break;
    case "tai-khoan":
        include 'module/profile.php';
    	break;
    case "quen-mat-khau":
        include 'module/forget.php';
    	break;
    case "dang-ky":
        include 'module/register.php';
    	break;
    case "gallery":
        include 'module/gallery.php';
    	break;
    case "tim-kiem":
        include 'module/search.php';
    	break;
    case "lien-he":
        include 'module/contact.php';
    	break;
    case "thuong-hieu":
        include 'module/brand.php';
    	break;
    case "san-pham-moi":
    case "san-pham-sale":
    case "san-pham":
        include 'module/product.php';
    	break;
    case "product-more":
        include 'module/product_more.php';
    	break;
    case "product-ajax":
        include 'module/product_ajax.php';
    	break;
    case "tin-tuc":
        include 'module/news.php';
    	break;
    case "gioi-thieu":
        include 'module/article.php';
    	break;
    case "gio-hang":
        include 'module/cart.php';
    	break;
    default:
		if(@$_GET['a']){
        	include 'module/product_detail.php';
		}
		else{
        	include 'module/home.php';
		}
        break;
}



