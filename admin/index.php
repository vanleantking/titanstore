<?php

include '../functions.php';


switch(@$_GET['p']){
    case "fisize":
        include 'fisize.php';
        break;
    case "post":
        if(@!$_SESSION['adminID']) header('Location: '. base_url());
        include 'post.php';
        break;
    case "orders":
        if(@!$_SESSION['adminID']) header('Location: '. base_url());
        include 'orders.php';
        break;
    case "users":
        if(@!$_SESSION['adminID']) header('Location: '. base_url());
        include 'users.php';
        break;
    case "logout":
        unset($_SESSION['adminID']);
        header('Location: '. base_url());
        break;
    case "deletefile":
    	deletefile();
        break;
    case "upload":
    	upload();
        break;
    case "setting":
        if(@!$_SESSION['adminID']) header('Location: '. base_url());
        include 'setting.php';
        break;
    default:
        include 'home.php';
        break;
}



