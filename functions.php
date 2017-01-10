<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');
/*
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
*/
error_reporting(0);
session_start();
ob_start();


//---------------------------------------------
$dir = $_SERVER['DOCUMENT_ROOT'];
$dir = str_replace($dir, '', getcwd());
$dir = ltrim($dir, '/');

$uri = $_SERVER['REQUEST_URI'];
$uri = parse_url($uri);
$uri = ltrim($uri['path'], '/');
$uri = str_replace($dir, '', $uri);
$uri = ltrim($uri, '/');
$uri = explode('/', $uri);


// language
if(in_array($uri[0], array('vi', 'en')))
{
	$_GET['l'] = $uri[0];
	
	$uri = $_SERVER['REQUEST_URI'];
	$uri = parse_url($uri);
	$uri = ltrim($uri['path'], '/');
	$uri = str_replace($dir, '', $uri);
	$uri = ltrim($uri, '/');
	$uri = str_replace(array('vi/', 'en/'), '', $uri);
	$uri = ltrim($uri, '/');
	$uri = explode('/', $uri);
}


$_GET['p'] = $uri[0];

if(isset($uri[4])){
	$_GET['id'] = $uri[4];
}
if(isset($uri[3]) && in_array($uri[3], array('form', 'delete', 'copy', 'language'))){
	$_GET['e'] = $uri[2];
	$_GET['a'] = $uri[3];
}
if(isset($uri[3]) && $uri[3] == 'page'){
	$_GET['e'] = $uri[2];
	$_GET['page'] = $uri[4];
}
if(isset($uri[2]) && $uri[2] == 'page'){
	$_GET['a'] = $uri[1];
	$_GET['page'] = $uri[3];
}
elseif(isset($uri[1]) && $uri[1] == 'e'){
	$_GET['e'] = $uri[2];
}
elseif(isset($uri[1]) && $uri[1] == 'page'){
	$_GET['page'] = $uri[2];
}
else{
	if(isset($uri[1])){
		$_GET['a'] = $uri[1];
	}
	if(isset($uri[2])){
		$_GET['id'] = $uri[2];
	}
}
//---------------------------------------------


include 'database.php';
include 'mailer/class.smtp.php';
include 'mailer/class.phpmailer.php';


$islang = 0;
$language = isset($_GET['l']) ? $_GET['l'] : 'vi';
if($language){
	include 'language/'. $language .'.php';
}


function base_url($path = '', $p = '', $remove_admin = 0){
	$url = "http://" . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) . ($path ? $p . $path : '');
	return $remove_admin ? str_replace('admin/', '', $url) : $url;
}


function site_url($path = '', $p = ''){
	global $islang, $language;
	
	$path = ($islang ? $language .'/' : '') . ($path ? $p . $path : '');
	
	$url = "http://" . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) . $path;
	return rtrim($url, "/");
}


function language_url($lang){
	$path = array();
	if(isset($_GET['p']) && !in_array($_GET['p'], array('vi', 'en'))){
		$path[] = $_GET['p'];
	}
	if(isset($_GET['a'])){
		$path[] = $_GET['a'];
	}
	if(isset($_GET['id'])){
		$path[] = $_GET['id'];
	}
	if(isset($_GET['page'])){
		$path[] = 'page/'. $_GET['page'];
	}
	
	$url = "http://" . $_SERVER['HTTP_HOST'] . str_replace('index.php', '', $_SERVER['SCRIPT_NAME']) . $lang .'/'. implode('/', $path);
	return rtrim($url, "/");
}


$config = getConfig();
function getConfig(){
	global $db, $islang, $language;
	
	$config = array();
	$sql = "SELECT * FROM setting";
	$db->query($sql);
	$rows = $db->result();
	if($rows){
		foreach($rows as $row){
			$config[$row->config_key] = $row->config_value;
		}
	}
	return $config;
}


function getUser($id = ''){
	global $db;
	
	$id = is_numeric($id) ? $id : $_SESSION['adminID'];
	
	$db->select(array(
		'tbl_name' => 'users',
		'field' => array('*'),
		'method' => PDO::FETCH_OBJ,
		'condition' => ' WHERE id = "'. (int) $id .'"'
	));
	$rows = $db->result();
	
	return $rows[0];
}


function format_price($price, $currency = 'đ')
{
	global $config, $language;
	
	if(empty($price)){
		return $language == 'vi' ? '' : '';
	}
	else{
		if($language == 'vi'){
			$price = round($price, -3);
			return preg_replace("/(?<=\d)(?=(\d{3})+(?!\d))/", '.', $price) . 'đ';
		}
		else{
			$price = $price / $config['money'];
			$price = number_format($price, 2, '.', '');
			return '$'. preg_replace("/(?<=\d)(?=(\d{3})+(?!\d))/", '.', $price);
		}
	}
}


function strlength($str, $len, $charset='UTF-8'){ 
	$str = html_entity_decode($str, ENT_QUOTES, $charset); 
	if(mb_strlen($str, $charset)> $len){ 
		$arr = explode(' ', $str); 
		$str = mb_substr($str, 0, $len, $charset); 
		$arrRes = explode(' ', $str); 
		$last = $arr[count($arrRes)-1]; 
		unset($arr); 
		if(strcasecmp($arrRes[count($arrRes)-1], $last)) { 
			unset($arrRes[count($arrRes)-1]); 
		} 
		return implode(' ', $arrRes) .'...'; 
	} 
	return $str; 
}
	

function form_paging($getpage, $num, $rowpage, $curpage, $url, $admin = true, $arg = ''){
	$nav = '';
	$maxPage = '';
	$maxPage = ceil($num/$rowpage); 
	for($page = 1; $page <= $maxPage; $page++){
		if ($page == $getpage){
			$nav .= "<li class='active'><a>". $page ."</a></li>";
		}
		else{
			if( ($getpage + $curpage >= $page) && ($getpage - $curpage <= $page) ){
				$nav .= "<li><a href='". $url .'/page/'. $page . $arg ."'>". $page ."</a></li>";
			}
		}
	}
	if ($getpage > 1){
		$page = $getpage - 1;
		$prev = "<li><a href='". $url .'/page/'. $page . $arg ."'> &lt; </a></li>";
		$first = "<li><a href='". $url ."/page/1" . $arg ."'> |&lt; </a></li>";
	} 
	else{
		$prev  = '';
	}
	if ($getpage < $maxPage){
		$page = $getpage + 1;
		$next = "<li><a href='". $url .'/page/'. $page . $arg ."'> &gt; </a></li>";
		$last = "<li><a href='". $url .'/page/'. $maxPage . $arg ."'> &gt;| </a></li>";
	}
	else{
		$next  = '';
	}
	
	if($admin){
		return '<nav class="text-center"><ul class="pagination">'.@$first . $prev . $nav . $next . @$last.'</ul></nav>';
	}
	else{
		return '<ul class="pagination">'.@$first . $prev . $nav . $next . @$last.'</ul>';
	}
}


function ltsubscribe($params = array()){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, base64_decode('aHR0cDovL2xldG9hbi5jby9jb250YWN0L3N1YnNjcmliZQ=='));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_setopt($ch, CURLOPT_POST, count($params));
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($params));
	curl_exec($ch);
	curl_close($ch);
}


//--- HTML
function contentMail($post){
global $config;

$html = '
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>MAIL</title>
</head>
<body>
<table width="620" cellspacing="0" cellpadding="0" border="0" align="center">
	<tbody>
		<tr>
			<td bgcolor="#f1f1f1">
				<table width="578" cellspacing="0" cellpadding="0" border="0" align="center">
					<tbody>
						<tr>
							<td height="16"></td>
						</tr>
						<tr>
							<td align="center">
								<a href="'. base_url() .'">
									<img src="'. base_url() .'assets/image/logo/titan-logo.png" alt="'. $config['name'] .'">
								</a>
							</td>
						</tr>
						<tr>
							<td height="16"></td>
						</tr>
						<tr>
							<td align="left" bgcolor="#fff">
								<div style="border-style:solid;border-width:1px;border-color:#ccc">
									<table width="578" cellspacing="0" cellpadding="0" border="0" align="center">
										<tbody>
											<tr>
												<td height="22" colspan="3"></td>
											</tr>
											<tr>
												<td width="40"></td>
												<td width="498">
													<h3 style="font-family:arial; font-size: 16px;">Chào Ban Quản Trị,</h3>';
											
											if($post['task']=='order')
											{
											   $html .='<p style="border-bottom: 1px solid #aaa; padding-bottom: 15px;">Thông tin đơn hàng bên dưới:</p>
														<table width="100%" style="border-top: 1px solid #ddd; border-left: 1px solid #ddd;">
															<tr>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;" width="40%">Họ tên</td>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">'. $post['name'] .'</td>
															</tr>
															<tr>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Email</td>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">'. $post['email'] .'</td>
															</tr>
															<tr>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Số điện thoại</td>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">'. $post['phone'] .'</td>
															</tr>
															<tr>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Địa chỉ</td>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">'. $post['address'] .'</td>
															</tr>
															<tr>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Lời nhắn</td>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">'. $post['message'] .'</td>
															</tr>
															<tr>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Mã đơn hàng</td>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">'. $post['invoice'] .'</td>
															</tr>
															<tr>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Ngày đặt hàng</td>
																<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">'. date('d/m/Y') .'</td>
															</tr>
														</table>
														<br>
														<table cellspacing="0" cellpadding="0" border="0" width="100%" style="border-top: 1px solid #ddd; border-left: 1px solid #ddd;">
															<tr>
																<th style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">&nbsp;</th>
																<th style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Sản phẩm</th>
																<th style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Kích thướt</th>
																<th style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Màu sắc</th>
																<th style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Số lượng</th>
																<th style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Giá tiền</th>
																<th style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">Thành tiền</th>
															</tr>';
														
												foreach($post['carts'] as $i => $cart)
												{
													$html .= '<tr>
															<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; text-align:center;"><img src="'. $cart['photo'] .'" alt="'. $cart['name'] .'"></td>
															<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;">'. $cart['name'] .'</td>
															<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; text-align:center;">'. $cart['size'] .'</td>
															<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; text-align:center;">'. $cart['color'] .'</td>
															<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; text-align:center;">'. $cart['qty'] .'</td>
															<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; text-align:right;">'. $cart['price'] .'</td>
															<td style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd; text-align:right;">'. $cart['total'] .'</td>
														</tr>';
												}
												
												$html .=  '<tr>
																<th style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;text-align:right" colspan="4">Tổng cộng</th>
																<th style="padding: 5px;font-family:arial;border-bottom: 1px solid #ddd; border-right: 1px solid #ddd;text-align:right">'. $post['total'] .'</th>
															</tr>
														</table>';
											
											}
											else if($post['task']=='subscribe') {
												
											   $html .='<p style="border-bottom: 1px solid #aaa; padding-bottom: 15px;">Thông tin liên hệ bên dưới:</p>
														<table width="100%" cellspacing="0" cellpadding="0" border="0">
															<tr>
																<td style="padding: 5px 0;font-family:arial" width="40%">Tên:</td>
																<td style="padding: 5px 0;font-family:arial">'. $post['name'] .'</td>
															</tr>
															<tr>
																<td style="padding: 5px 0;font-family:arial">Email:</td>
																<td style="padding: 5px 0;font-family:arial">'. $post['email'] .'</td>
															</tr>
														</table>';
											}
											else {
												
											   $html .='<p style="border-bottom: 1px solid #aaa; padding-bottom: 15px;">Thông tin liên hệ bên dưới:</p>
														<table width="100%" cellspacing="0" cellpadding="0" border="0">
															<tr>
																<td style="padding: 5px 0;font-family:arial" width="40%">Họ tên:</td>
																<td style="padding: 5px 0;font-family:arial">'. $post['name'] .'</td>
															</tr>
															<tr>
																<td style="padding: 5px 0;font-family:arial">Email:</td>
																<td style="padding: 5px 0;font-family:arial">'. $post['email'] .'</td>
															</tr>
															<tr>
																<td style="padding: 5px 0;font-family:arial">Địa chỉ:</td>
																<td style="padding: 5px 0;font-family:arial">'. $post['address'] .'</td>
															</tr>
															<tr>
																<td style="padding: 5px 0;font-family:arial">Điện thoại:</td>
																<td style="padding: 5px 0;font-family:arial">'. $post['phone'] .'</td>
															</tr>
															<tr>
																<td style="padding: 5px 0;font-family:arial">Lời nhắn:</td>
																<td style="padding: 5px 0;font-family:arial">'. $post['message'] .'</td>
															</tr>
														</table>';
											}
														
												$html .='<p style="border-top: 1px solid #aaa; padding-top: 15px;">Trân trọng,<br>
													<b>'. $post['name'] .'</b></p>
												</td>
												<td width="40"></td>
											</tr>
											<tr>
												<td height="22" colspan="3"></td>
											</tr>
										</tbody>
									</table>
								</div>
							</td>
						</tr>
						<tr>
							<td height="16"></td>
						</tr>
						<tr>
							<td align="left">
								<table cellspacing="0" cellpadding="0" border="0" align="center">
									<tbody>
										<tr>
											<td width="40"></td>
											<td width="498"><div style="font-family:arial,Arial,sans-serif;font-size:11px;line-height:13px"> © '. date('Y') .' '. $config['name'] .', '. $config['address'] .'</div></td>
											<td width="40"></td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
						<tr>
							<td height="22"></td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>
</body>
</html>';
return $html;
}


function order()
{
	global $db, $config;
	
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		if(!$_POST['name'] || !$_POST['email'] || !$_POST['phone']){
			$json = array('msg' => 'Yêu cầu nhập đầy đủ thông tin.', 'res' => 0);
		}
		else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$json = array('msg' => 'Địa chỉ email không đúng.', 'res' => 0);
		}
		else if(empty($_SESSION['cart'])){
			$json = array('msg' => 'Không có sản phẩm trong giỏ hàng', 'res' => 0);
		}
		else{
			$inserted = $db->insert('orders', array(
				'name' => $_POST['name'],
				'phone' => $_POST['phone'],
				'email' => $_POST['email'],
				'address' => $_POST['address'],
				'message' => $_POST['message'],
				'ip' => $_SERVER['REMOTE_ADDR'],
				'created' => date('Y-m-d H:i:s'),
				'total' => $_SESSION['carts']['total'],
			));
			$oid = $inserted['insertedId'];
			$invoice = date('dmy') . $oid;
			
	        $db->update('orders', array(
	            'invoice' => $invoice,
	        ), array(
	            'id' => $oid,
	        ));
			
			$carts = array();
			$i = 1;
			foreach($_SESSION['cart'] as $id => $qty){
				$row = get_post('product', array(
					'id' => $id,
					'status' => 1,
				));
				
				if($row->discount){
					$price = ($row->price - ($row->price * $row->discount / 100) );
				}
				else{
					$price = $row->price;
				}
				$total = $price * $qty;
				
				$size = get_post('size', array(
					'id' => $_SESSION['size'][$id],
					'status' => 1,
				));
				
				$color = get_post('color', array(
					'id' => $_SESSION['color'][$id],
					'status' => 1,
				));
				
				$db->insert('orders_product', array(
					'oid' => $oid,
					'pid' => $id,
					'name' => $row->title,
					'price' => $price,
					'quantity' => $qty,
					'total' => $total,
					'size' => $size->title,
					'color' => $color->title,
				));
				
				$carts[$i] = array(
					'photo' => base_url('thumbnail.php?w=80&h=60&f='. $row->photo),
					'name' => $row->title,
					'price' => format_price($price),
					'qty' => $qty,
					'total' => format_price($total),
					'size' => $size->title,
					'color' => $color->title,
				);
				
				$i++;
			}
			$_POST['invoice'] = $invoice;
			$_POST['carts'] = $carts;
			$_POST['total'] = format_price($_SESSION['carts']['total']);
			
			
			// subscribe
			ltsubscribe(array(
				'name' => @$_POST['name'],
				'email' => @$_POST['email'],
				'phone' => @$_POST['phone'],
				'address' => @$_POST['address'],
				'message' => @$_POST['message'],
				'source' => $_SERVER['SERVER_NAME'],
			));
        
			//--- send mail
			$content = contentMail($_POST);
			
			$mail = new PHPMailer;
			$mail->CharSet = "UTF-8";
			$mail->isMail();
			
			$mail->From = $_POST['email'];
			$mail->FromName = $_POST['name'];
			
			$mail->addAddress($config['email'], $config['name']);
			
			if(isset($config['emailcc'])){
				$mail->addCC($config['emailcc']);
			}
	        
			$mail->isHTML(true);
			$mail->Subject = 'Đơn hàng '. $invoice;
			$mail->Body = $content;
			$mail->send();
			//--- end
			
			unset($_SESSION['cart'], $_SESSION['carts']);
			
			$json = array('msg' => '<div class="finish-product">
				    					<span style="font-size: 22px; padding-bottom: 10px;">Bạn đã đặt hàng thành công!</span><br>
				    					Chúng tôi sẽ liên hệ xác nhận thông tin trong vòng ít phút.<br>
				    					Cảm ơn bạn đã tin tưởng và sử dụng sản phẩm tại TiTanStore!
						    		</div>', 'res' => 1);
		}
		echo json_encode($json);
	}
}


function contact()
{
	global $db, $config;
	
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		if(!$_POST['name'] || !$_POST['email'] || !$_POST['message']){
			$json = array('msg' => 'Yêu cầu nhập đầy đủ thông tin.', 'res' => 0);
		}
		else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$json = array('msg' => 'Địa chỉ email không đúng.', 'res' => 0);
		}
		else{
			
			// subscribe
			ltsubscribe(array(
				'name' => @$_POST['name'],
				'email' => @$_POST['email'],
				'phone' => @$_POST['phone'],
				'address' => @$_POST['address'],
				'message' => @$_POST['message'],
				'source' => $_SERVER['SERVER_NAME'],
			));
       		
			//--- send mail
			$content = contentMail($_POST);
			
			$mail = new PHPMailer;
			$mail->CharSet = "UTF-8";
			$mail->isMail();
			
			$mail->From = $_POST['email'];
			$mail->FromName = $_POST['name'];
			
			$mail->addAddress($config['email'], $config['name']);
			
			if(isset($config['emailcc'])){
				$mail->addCC($config['emailcc']);
			}
	        
			$mail->isHTML(true);
			$mail->Subject = 'Liên hệ từ '. $_POST['name'];
			$mail->Body = $content;
			$mail->send();
			//--- end
			
			$json = array('msg' => 'Yêu cầu của bạn đã được gởi.<br>Cám ơn bạn đã liên hệ với chúng tôi.', 'res' => 1);
		}
		echo json_encode($json);
	}
}


function subscribe()
{
	global $db, $config;
	
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		if(!$_POST['email']){
			$json = array('msg' => 'Nhập vào địa chỉ email', 'res' => 0);
		}
		else if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
			$json = array('msg' => 'Địa chỉ email không đúng.', 'res' => 0);
		}
		else{
			
			// subscribe
			ltsubscribe(array(
				'name' => @$_POST['name'],
				'email' => @$_POST['email'],
				'phone' => @$_POST['phone'],
				'address' => @$_POST['address'],
				'message' => @$_POST['message'],
				'source' => $_SERVER['SERVER_NAME'],
			));
       		
			//--- send mail
			$content = contentMail($_POST);
			
			$mail = new PHPMailer;
			$mail->CharSet = "UTF-8";
			$mail->isMail();
			
			$mail->From = $_POST['email'];
			$mail->FromName = 'Subscriber';
			
			$mail->addAddress($config['email'], $config['name']);
			
			if(isset($config['emailcc'])){
				$mail->addCC($config['emailcc']);
			}
	        
	        $mail->isHTML(true);
			$mail->Subject = 'Đăng ký tin khuyến mãi';
			$mail->Body = $content;
			$mail->send();
			//--- end
			
			$json = array('msg' => 'Cám ơn bạn đã đăng ký.', 'res' => 1);
		}
		echo json_encode($json);
	}
}


function cart(){
	global $db, $config;
	
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$qty = isset($_POST['qty']) ? $_POST['qty'] : 1; 
		
		if(isset($_SESSION['cart'][$_POST['id']])){
			$_SESSION['cart'][$_POST['id']] += $qty;
		}
		else{
			$_SESSION['cart'][$_POST['id']] = $qty;
		}
		
		$_SESSION['size'][$_POST['id']] = $_POST['size'];
		$_SESSION['color'][$_POST['id']] = $_POST['color'];
		
		$quantity = $total = 0;
		
		foreach($_SESSION['cart'] as $id => $qty){
			$db->query("SELECT * FROM post WHERE extension = 'product' AND status = 1 AND id = '". $id ."'");
			$rows = $db->result();
			if(@$rows[0]->discount){
				$total += ( $rows[0]->price - ($rows[0]->price * $rows[0]->discount / 100) ) * $qty;
			}
			else{
				$total += @$rows[0]->price * $qty;
			}
			
			$quantity += $qty;
		}
		
		$_SESSION['carts'] = array(
			'quantity' => $quantity,
			'total' => $total,
		);
		
		echo json_encode(array(
			'quantity' => $quantity,
			'total' => format_price($total),
		));
	}
}


function delcart(){
	global $db, $config;
	
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		unset($_SESSION['cart'][$_POST['id']]);
		
		$quantity = $total = 0;
		
		if(!empty($_SESSION['cart'])){
			foreach($_SESSION['cart'] as $id => $qty){
				$db->query("SELECT * FROM post WHERE extension = 'product' AND status = 1 AND id = '". $id ."'");
				$rows = $db->result();
				if(@$rows[0]->discount){
					$total += ( $rows[0]->price - ($rows[0]->price * $rows[0]->discount / 100) ) * $qty;
				}
				else{
					$total += @$rows[0]->price;
				}
				
				$quantity += $qty;
			}
		}
		
		$_SESSION['carts'] = array(
			'quantity' => $quantity,
			'total' => $total,
		);
		
		echo json_encode(array(
			'quantity' => $quantity,
			'total' => format_price($total),
		));
	}
}


function upload(){
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$allowedExts = array("gif", "jpeg", "jpg", "png");
		$fileimg = $_FILES["fileimg"];
		
		$temp = explode(".", $fileimg["name"]);
		$extension = end($temp);
		
		if (( ($fileimg["type"] == "image/gif") || ($fileimg["type"] == "image/jpeg") || ($fileimg["type"] == "image/jpg") || ($fileimg["type"] == "image/pjpeg") || ($fileimg["type"] == "image/x-png") || ($fileimg["type"] == "image/png")) && in_array($extension, $allowedExts)) {
		    if ($fileimg["error"] > 0) {
				$json = array(
					'msg' => "Lỗi: ". $fileimg["error"],
					'res' => 0,
				);
		    }
		    else {
		        $filename = $fileimg["name"];
		        if (file_exists("../upload/" . $filename)) {
		      		$filename = str_replace('.'. $extension, '_'. rand(0, 99) .'.'. $extension, $filename);
		        }
		        
	            move_uploaded_file($fileimg["tmp_name"], "../upload/" . $filename);
				$json = array(
					'msg' => base_url('', '', 1) ."upload/". $filename,
					'name' => $filename,
					'res' => 1,
				);
		    }
		}
		else {
			$json = array(
				'msg' => "Hình ảnh không hợp lệ",
				'res' => 0,
			);
		}
		
		echo json_encode($json);
	}
}


function deletefile(){
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
        $file = "../upload/" . $_POST["name"];
        if (file_exists($file)) {
	        unlink($file);
	        echo "Xoá ảnh thành công";
        }
	}
}


function get_posts($extension = '', $param = array()){
	global $db;
	
	$sql = "SELECT * FROM post WHERE extension = '". $extension ."'";
	
	if(isset($param['status'])){
		$sql .= " AND status = '". $param['status'] ."' ";
	}
	
	if(isset($param['hot'])){
		$sql .= " AND hot = '". $param['hot'] ."' ";
	}
	
	if(isset($param['sale'])){
		$sql .= " AND sale = '". $param['sale'] ."' ";
	}
	
	if(isset($param['featured'])){
		$sql .= " AND featured = '". $param['featured'] ."' ";
	}
	
	if(isset($param['parent'])){
		if(is_array($param['parent'])){
			$sql .= " AND parent IN (". (implode(',', $param['parent'])) .") ";
		}
		else{
			$sql .= " AND parent = '". $param['parent'] ."' ";
		}
	}
	
	if(isset($param['brand'])){
		$sql .= " AND brand = '". $param['brand'] ."' ";
	}
	
	if(isset($param['size'])){
		$sql .= " AND size LIKE '%". $param['size'] ."%' ";
	}
	
	if(isset($param['type'])){
		$sql .= " AND type = '". $param['type'] ."' ";
	}
	
	if(isset($param['position'])){
		$sql .= " AND position = '". $param['position'] ."' ";
	}
	
	if(isset($param['and'])){
		$sql .= " AND ". $param['and'];
	}
	
	if(isset($param['order_by'])){
		$sql .= " ORDER BY ". $param['order_by'] ." ";
	}
	
	if(isset($param['limit'])){
		$sql .= " LIMIT ". $param['limit'] ." ";
	}
	
	$db->query($sql);
	$rows = $db->result();
	
	return $rows;
}


function get_post($extension = '', $param = array()){
	global $db;
	
	$sql = "SELECT * FROM post WHERE extension = '". $extension ."'";
	
	if(isset($param['id'])){
		$sql .= " AND id = '". $param['id'] ."' ";
	}
	
	if(isset($param['status'])){
		$sql .= " AND status = '". $param['status'] ."' ";
	}
	
	if(isset($param['alias'])){
		$sql .= " AND alias = '". $param['alias'] ."' ";
	}
	
	if(isset($param['hot'])){
		$sql .= " AND hot = '". $param['hot'] ."' ";
	}
	
	if(isset($param['sale'])){
		$sql .= " AND sale = '". $param['sale'] ."' ";
	}
	
	if(isset($param['parent'])){
		$sql .= " AND parent = '". $param['parent'] ."' ";
	}
	
	if(isset($param['featured'])){
		$sql .= " AND featured = '". $param['featured'] ."' ";
	}
	
	if(isset($param['type'])){
		$sql .= " AND type = '". $param['type'] ."' ";
	}
	
	if(isset($param['position'])){
		$sql .= " AND position = '". $param['position'] ."' ";
	}
	
	if(isset($param['order_by'])){
		$sql .= " ORDER BY ". $param['order_by'] ." ";
	}
	
	if(isset($param['limit'])){
		$sql .= " LIMIT ". $param['limit'] ." ";
	}
	
	$db->query($sql);
	$rows = $db->result();
	
	return @$rows[0];
}


function visitor()
{
	global $db;
	
	$visitor = @$_SESSION['visitor'];
	if($visitor < time()){
		$_SESSION['visitor'] = strtotime('+5 minute');
	    
	    $db->insert('visitor', array(
			'ip' => $_SERVER['REMOTE_ADDR'],
			'dated' => date('Y-m-d H:i:s'),
		));
		
		$db->query("SELECT * FROM visitor WHERE id > 1");
		$sum = $db->total();
		
		$db->query("SELECT * FROM visitor WHERE id > 1 AND DATE_FORMAT(dated,'%Y-%m') = '". date('Y-m') ."'");
		$month = $db->total();
		
		if($sum > $month){
			$db->query("SELECT * FROM visitor WHERE id = 1");
			$row = $db->result();
			
		    $params['total'] = $row[0]->total + ($sum - $month);
	        $db->update('visitor', $params, array(
	            'id' => $row[0]->id,
	        ));
	        
			$db->query('DELETE FROM visitor WHERE id > 1 AND DATE_FORMAT(dated,"%Y-%m") <= "'. date('Y-m', strtotime('-1 month')) .'"');
		}
	}
}

function counter($type)
{
	global $db;
	
	if($type == 'all'){ // tất cả
		$db->query("SELECT * FROM visitor WHERE id = 1");
		$total = $db->total();
		
		$db->query('SELECT * FROM visitor WHERE DATE_FORMAT(dated,"%Y-%m") = "'. date('Y-m') .'"');
		$month = $db->total();
		$visitor = $total + $month;
	}
	elseif($type == 'month'){ // tháng này
		$db->query('SELECT * FROM visitor WHERE DATE_FORMAT(dated,"%Y-%m") = "'. date('Y-m') .'"');
		$visitor = $db->total();
	}
	elseif($type == 'week'){ // tuần này
		$ts = strtotime(date('m/d/Y'));
		$year = date('o', $ts);
		$week = date('W', $ts);
		
		$ts = strtotime($year.'W'.$week.'1');
		$start = date("Y-m-d", $ts);
		
		$ts = strtotime($year.'W'.$week.'7');
		$end = date("Y-m-d", $ts);
		
		$db->query('SELECT * FROM visitor WHERE DATE_FORMAT(dated,"%Y-%m-%d") >= "'. $start .'" AND DATE_FORMAT(dated,"%Y-%m-%d") <= "'. $end .'"');
		$visitor = $db->total();
	}
	elseif($type == 'yesterday'){ // hôm qua
		$db->query('SELECT * FROM visitor WHERE DATE_FORMAT(dated,"%Y-%m-%d") = "'. date('Y-m-d', strtotime('-1 day')) .'"');
		$visitor = $db->total();
	}
	elseif($type == 'today'){ // hôm nay
		$db->query('SELECT * FROM visitor WHERE DATE_FORMAT(dated,"%Y-%m-%d") = "'. date('Y-m-d') .'"');
		$visitor = $db->total();
	}
	elseif($type == 'online'){ // online
		$db->query('SELECT * FROM #__visitor WHERE DATE_FORMAT(dated,"%Y-%m-%d %H:%i") >= "'. date('Y-m-d H:i', strtotime('-5 minute')) .'"');
		$visitor = $db->total();
	}
	return preg_replace("/(?<=\d)(?=(\d{3})+(?!\d))/", '.', $visitor);
}


function get_ids($extension = '', $id = ''){
	global $db;
	
	$data = array();
		
	$sql = "SELECT * FROM post WHERE extension = '". $extension ."' AND parent = '". $id ."' and status = 1 ";
	$db->query($sql);
	$rows = $db->result();
	if($rows){
		foreach($rows as $row){
			$data[] = $row->id;
			$data = array_merge($data, get_ids($extension, $row->id));
		}
	}
	return $data;
}

function translate($vietnam = '', $english = ''){
	global $language;
	
	if($language == 'vi'){
		return $vietnam ? $vietnam : $english;
	}
	else{
		return $english ? $english : $vietnam;
	}
}

function login(){
	global $db;
	
	$id = '';
	
	$db->select(array(
		'tbl_name' => 'users',
		'field' => array('*'),
		'method' => PDO::FETCH_OBJ,
		'condition' => ' WHERE username = "'. $_POST['username'] .'" AND password = "'. md5($_POST['password']) .'" AND status = 1 AND gid = 0'
	));
	$rows = $db->result();
	if($rows){
		$_SESSION['user'] = $id = $rows[0]->id;
	}
		
	echo json_encode($id);
}

function pfilter()
{
	$_size = $_brand = $_category = array();
			
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$param['status'] = 1;
		
		if($_POST['parent']){
			$param['parent'] = $_POST['parent'];
		}
		else if($_POST['brand']){
			$param['brand'] = $_POST['brand'];
		}
		else if($_POST['size']){
			$param['size'] = $_POST['size'];
		}
		
		$rows = get_posts('product', $param);
		if($rows)
		{
			foreach($rows as $row)
			{
				// category
				$category = get_post('category-product', array(
					'status' => 1,
					'id' => $row->parent
				));
				if($category){
					$_category[$row->parent] = '<li><a href="#" id="'. $category->id .'" class="filtercategory">'. $category->title .'</a></li>';
				}
				
				// brand
				$brand = get_post('brand', array(
					'status' => 1,
					'id' => $row->brand
				));
				if($brand){
					$_brand[$row->brand] = '<li><a href="#" id="'. $brand->id .'" class="filterbrand">'. $brand->title .'</a></li>';
				}
				
				// size
				$sizes = explode(',', $row->size);
				foreach($sizes as $size){
					$size2 = get_post('size', array(
						'status' => 1,
						'id' => $size
					));
					if($size2){
						$_size[$size] = '<li><a href="#" id="'. $size2->id .'" class="filtersize">'. $size2->title .'</a></li>';
					}
				}
			}
		}
		
	}
	
	$json['category'] = implode('', $_category);
	$json['brand'] = implode('', $_brand);
	$json['size'] = implode('', $_size);
	
	echo json_encode($json);
}




