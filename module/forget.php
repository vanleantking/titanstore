<?php
	$metatitle = 'Quên mật khẩu';
	
	if(isset($_SESSION['user'])){
		header('Location: '. base_url('tai-khoan'));
	}
	
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$db->query("SELECT * FROM users WHERE email = '". $_POST['email'] ."'");
		$rows = $db->result();
		
		if(!$_POST['email']){
			$msg = 'Yêu cầu nhập thông tin vào dấu *';
		}
		else if(empty($rows)){
			$msg = 'Email không tồn tại';
		}
		else{
			$password = rand(10000, 999999);
			
	        $res = $db->update('users', array(
		        'password' => md5($password),
		    ), array(
			    'id' => $rows[0]->id
		    ));
		    
			//--- send mail
			$mail = new PHPMailer;
			$mail->CharSet = "UTF-8";
			$mail->isMail();
			
			$mail->From = $config['email'];
			$mail->FromName = $config['name'];
			
			$mail->addAddress($rows[0]->email, $rows[0]->name);
			$mail->isHTML(true);
			$mail->Subject = 'Yêu cầu lấy lại mật khẩu';
			$mail->Body = 'Chào '. $rows[0]->name .',<br><br>Mật khẩu của bạn là: '. $password .'<br><br>Trân trọng,<br>'. $config['name'];
			$mail->send();
			//--- end
			
			header('Location: '. site_url('quen-mat-khau/thanh-cong'));
		}
	}
	
	include dirname(__FILE__) .'/header.php';
?>
	<form method="post">
		<element class="titan-register container">
			<?=isset($msg) ? '<div class="msg">'. $msg .'</div>' : ''?>
			<?=isset($_GET['a']) && $_GET['a'] == 'thanh-cong' ? '<div class="msg">Chúng tôi có gởi mật khẩu đến email của bạn. Vui lòng kiểm tra lại email.</div>' : ''?>
	    	<div class="titan-title">QUÊN MẬT KHẨU</div>
	    	<div class="rigister-box">
	    		<div class="register-form">
	    			<i class="fa fa-envelope"  aria-hidden="true"></i>
	    			<input type="email" name="email" value="<?=@$_POST['email']?>" required placeholder="Địa chỉ email*">
	    		</div>
	    	</div>
	    	<div class="clearfix"></div>
	    	<button class="see-more" type="submit">GỬI YÊU CẦU</button>
	    </element>
	</form>
<?php include dirname(__FILE__) .'/footer.php'; ?>