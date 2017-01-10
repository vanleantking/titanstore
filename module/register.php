<?php
	$metatitle = 'Đăng ký';
	
	if(isset($_SESSION['user'])){
		header('Location: '. base_url('tai-khoan'));
	}
	
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$db->query("SELECT * FROM users WHERE username = '". $_POST['username'] ."' OR email = '". $_POST['email'] ."'");
		$rows = $db->result();
		
		if(!$_POST['username'] || !$_POST['password'] || !$_POST['password2'] || !$_POST['name'] || !$_POST['email'] || !$_POST['phone']){
			$msg = 'Yêu cầu nhập thông tin vào dấu *';
		}
		else if($_POST['password'] != $_POST['password2']){
			$msg = 'Mật khẩu xác nhận không đúng';
		}
		else if($rows){
			$msg = 'Tên đăng nhập hoặc Email đã tồn tại. Vui lòng thử tên khác.';
		}
		else{
	        $res = $db->insert('users', array(
		        'username' 	=> $_POST['username'],
		        'password' 	=> md5($_POST['password']),
		        'name' 		=> $_POST['name'],
		        'email' 	=> $_POST['email'],
		        'phone' 	=> $_POST['phone'],
		        'gender' 	=> $_POST['sex'],
		        'birthday' 	=> implode('/', array($_POST['dob-day'], $_POST['dob-month'], $_POST['dob-year'])),
		        'address' 	=> $_POST['address'],
		        'status' 	=> 1,
		        'gid' 		=> 0,
		    ));
		    
			$_SESSION['user'] = $res['insertedId'];
			
			header('Location: '. base_url('tai-khoan'));
		}
	}
	
	include dirname(__FILE__) .'/header.php';
?>
	<form method="post">
		<element class="titan-register container">
			<?=isset($msg) ? '<div class="msg">'. $msg .'</div>' : ''?>
	    	<div class="titan-title">ĐĂNG KÝ THÀNH VIÊN</div>
	    	<div class="rigister-box">
	    		<div class="register-form">
	    			<i class="fa fa-user"  aria-hidden="true"></i>
	    			<input type="text" name="username" value="<?=@$_POST['username']?>" required placeholder="Tên đăng nhập*">
	    		</div>
	    		<div class="register-form">
	    			<i class="fa fa-asterisk"  aria-hidden="true"></i>
	    			<input type="password" name="password" required placeholder="Mật khẩu*">
	    		</div>
	    		<div class="register-form">
	    			<input type="password" name="password2" required placeholder="Nhập lại mật khẩu*" style="margin-left: 46px;">
	    		</div>


	    		<div class="register-form">
	    			<i class="fa fa-envelope"  aria-hidden="true"></i>
	    			<input type="email" name="email" value="<?=@$_POST['email']?>" required placeholder="Địa chỉ email*">
	    		</div>

	    		<div class="register-form">
	    			<i class="fa fa-id-badge"></i>
	    			<input type="text" name="name" value="<?=@$_POST['name']?>" required placeholder="Họ tên*">
	    		</div>

	    		<div class="register-form">
	    			<i class="fa fa-phone"  aria-hidden="true"></i>
	    			<input type="text" name="phone" value="<?=@$_POST['phone']?>" required placeholder="Số điện thoại*">
	    		</div>

	    		<div class="control-group register-form">
	    			<i class="fa fa-transgender"  aria-hidden="true"></i>
				  	<div class="controls">
					    <select name="sex" id="sex">
					      <option value="">Giới tính</option>
					      <option value="">---</option>
					      <option value="Nam" <?=@$_POST['sex']=='Nam'?'selected':''?>>Nam</option>
					      <option value="Nữ" <?=@$_POST['sex']=='Nữ'?'selected':''?>>Nữ</option>
					    </select>
				  	</div>
				</div>

	    		<div class="control-group register-form">
	    			<i class="fa fa-birthday-cake"  aria-hidden="true"></i>
				  	<div class="controls">
					    <select name="dob-day" id="dob-day">
					      <option value="">Ngày</option>
					      <option value="">---</option>
					      <?php for($i = 1; $i <= 31; $i++){ ?>
					      <option value="<?=strlen($i)==1?'0'.$i:$i?>" <?=@$_POST['dob-day']==$i?'selected':''?>><?=strlen($i)==1?'0'.$i:$i?></option>
					      <?php } ?>
					    </select>
					    <select name="dob-month" id="dob-month">
					      <option value="">Tháng</option>
					      <option value="">-----</option>
					      <?php for($i = 1; $i <= 12; $i++){ ?>
					      <option value="<?=strlen($i)==1?'0'.$i:$i?>" <?=@$_POST['dob-month']==$i?'selected':''?>><?=strlen($i)==1?'0'.$i:$i?></option>
					      <?php } ?>
					    </select>
					    <select name="dob-year" id="dob-year">
					      <option value="" style="">Năm</option>
					      <option value="">----</option>
					      <?php for($i = date('Y')-10; $i >= date('Y')-80; $i--){ ?>
					      <option value="<?=strlen($i)==1?'0'.$i:$i?>" <?=@$_POST['dob-year']==$i?'selected':''?>><?=strlen($i)==1?'0'.$i:$i?></option>
					      <?php } ?>
					    </select>
				  	</div>
				</div>

	    		<div class="register-form">
	    			<i class="fa fa-map-marker"  aria-hidden="true" style="height: 54px;display: flex;justify-content: center;align-items: center;"></i>
	    			<textarea type="text" class="form-control" name="address" rows="2" placeholder="Địa chỉ"></textarea>
	    		</div>
	    		
	    	</div>
	    	<div class="clearfix"></div>
	    	<button class="see-more" type="submit">ĐĂNG KÝ</button>
	    </element>
	</form>
<?php include dirname(__FILE__) .'/footer.php'; ?>