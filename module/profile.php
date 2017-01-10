<?php
	
	if(!isset($_SESSION['user'])){
		header('Location: '. base_url());
	}
	
	$db->query("SELECT * FROM users WHERE id = '". $_SESSION['user'] ."'");
	$users = $db->result();
	$user = $users[0];
	$metatitle = $user->name;
	
	
	if($_SERVER['REQUEST_METHOD']=='POST')
	{
		if($_POST['task']=='profile')
		{
			if(!$_POST['name'] || !$_POST['address'] || !$_POST['phone']){
				$msg = 'Yêu cầu nhập thông tin vào dấu *';
			}
			else{
				
				// photo
				$photo = '';
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
				        $photo = $fileimg["name"];
				        if (file_exists("upload/" . $photo)) {
				      		$photo = str_replace('.'. $extension, '_'. rand(0, 99) .'.'. $extension, $photo);
				        }
				        
			            move_uploaded_file($fileimg["tmp_name"], "upload/" . $photo);
				    }
				}
				//-----
				
				$db->update('users', array(
			        'name' 		=> $_POST['name'],
			        'phone' 	=> $_POST['phone'],
			        'address' 	=> $_POST['address'],
			        'photo' 	=> $photo ? $photo : $user->photo,
			    ), array(
				    'id' => $_SESSION['user']
			    ));
				header('Location: '. base_url('tai-khoan'));
			}
		}
		else if($_POST['task']=='password')
		{
			if(!$_POST['password'] || !$_POST['password2'] || !$_POST['password3']){
				$msg = 'Yêu cầu nhập thông tin vào dấu *';
			}
			else if(md5($_POST['password']) != $user->password){
				$msg = 'Mật khẩu cũ không đúng';
			}
			else if($_POST['password2'] != $_POST['password3']){
				$msg = 'Mật khẩu xác nhận không đúng';
			}
			else{
				$db->update('users', array(
			        'password' => md5($_POST['password2']),
			    ), array(
				    'id' => $_SESSION['user']
			    ));
				header('Location: '. base_url('tai-khoan'));
			}
		}
		else if($_POST['task']=='custom')
		{
			$db->query("SELECT * FROM users WHERE email = '". $_POST['email'] ."' AND id != '". $_SESSION['user'] ."'");
			$check = $db->result();
			
			if(!$_POST['email']){
				$msg = 'Yêu cầu nhập thông tin vào dấu *';
			}
			else if($check){
				$msg = 'Email đã có tồn tại.';
			}
			else{
				$db->update('users', array(
			        'email' 	=> $_POST['email'],
			        'gender' 	=> $_POST['sex'],
			        'birthday' 	=> implode('/', array($_POST['dob-day'], $_POST['dob-month'], $_POST['dob-year'])),
			        'giay' 		=> $_POST['giay'],
			        'ao' 		=> $_POST['ao'],
			        'quan' 		=> $_POST['quan'],
			    ), array(
				    'id' => $_SESSION['user']
			    ));
				header('Location: '. base_url('tai-khoan'));
			}
		}
	}
	
	
	include dirname(__FILE__) .'/header.php';
?>
	<element class="titan-user">
    	<div class="container titan-user-box">
    		<div class="col-lg-12 titan-user-proper">
	    		<div class="titan-user-avata-box">
	    			<img src="upload/<?=$user->photo?$user->photo:'avatar.png'?>" style="width: 97%; height: 97%; position: absolute;">
	    		</div>
	    		<div class="titan-user-big-infor">
	    			<div class="titan-user-name"><?=$user->name?></div>
	    			<div class="titan-user-address"><i class="fa fa-map-marker"></i> <?=$user->address?></div>
	    			<div class="titan-user-phone"><i class="fa fa-phone"></i> <?=$user->phone?></div>
	    			<div class="titan-header-button-box">
	    				<button class="titan-header-button" data-toggle="modal" data-target="#user-change-pass" title="Quản lý tài khoản"><i class="fa fa-cog"></i></button>
	    				<button class="titan-header-button" data-toggle="modal" data-target="#user-big-infor" title="Chỉnh sửa thông tin cơ bản"><i class="fa fa-pencil-square-o"></i></button>
	    			</div>
	    			
	    		</div>
    		</div>

    		<div class="col-sm-3 titan-user-promotion-box">
    			
    		</div>

    		<div class="col-sm-9 titan-user-subsidiary">
    			<div class="user-edit">
    				<button  data-toggle="modal" data-target="#user-subsidiary-edit"><i class="fa fa-pencil-square-o"></i>Sửa thông tin</button>
    			</div>
    			<div class="titan-user-subsidiary-detail-box">
    				<div class="titan-user-subsidiary-detail-title">
    					Email
    				</div>
    				<div class="titan-user-subsidiary-detail-info">
    					<?=$user->email?>
    				</div>
				</div>
				<div class="titan-user-subsidiary-detail-box">
    				<div class="titan-user-subsidiary-detail-title">
    					Giới tính
    				</div>
    				<div class="titan-user-subsidiary-detail-info">
    					<?=$user->gender?>
    				</div>
				</div>
				<div class="titan-user-subsidiary-detail-box">
    				<div class="titan-user-subsidiary-detail-title">
    					Ngày sinh
    				</div>
    				<div class="titan-user-subsidiary-detail-info">
    					<?=$user->birthday?>
    				</div>
				</div>
				<div class="titan-user-subsidiary-detail-box">
    				<div class="titan-user-subsidiary-detail-title">
    					Size giầy
    				</div>
    				<div class="titan-user-subsidiary-detail-info">
    					<?=$user->giay?> &nbsp;
    				</div>
				</div>
				<div class="titan-user-subsidiary-detail-box">
    				<div class="titan-user-subsidiary-detail-title">
    					Size áo 
    				</div>
    				<div class="titan-user-subsidiary-detail-info">
    					<?=$user->ao?> &nbsp;
    				</div>
				</div>
				<div class="titan-user-subsidiary-detail-box">
    				<div class="titan-user-subsidiary-detail-title">
    					Size quần 
    				</div>
    				<div class="titan-user-subsidiary-detail-info">
    					<?=$user->quan?> &nbsp;
    				</div>
				</div>
    		</div>

    	</div>
    	
		<div class="modal fade" id="user-big-infor" tabindex="-1" role="dialog">
		  	<div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<div class="fillter-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
			        	<h4 class="modal-title">CHỈNH SỬA THÔNG TIN</h4>
			      	</div>
					<form method="post" enctype="multipart/form-data">
				    <input type="hidden" name="task" value="profile">
			      	<div class="modal-body container-fluid" style="text-align: center;">
			      		<div class="rigister-box">
			      			<div class="register-form">
				    			<i class="fa fa-id-badge"></i>
				    			<input type="text" name="name" value="<?=$user->name?>" required placeholder="Họ tên*">
				    		</div>
				      		<div class="register-form">
				    			<i class="fa fa-phone"  aria-hidden="true"></i>
				    			<input type="text" name="phone" value="<?=$user->phone?>" required placeholder="Số điện thoại*">
				    		</div>
				    		<div class="register-form">
				    			<i class="fa fa-map-marker"  aria-hidden="true" style="height: 54px;display: flex;justify-content: center;align-items: center;"></i>
				    			<textarea type="text" name="address" class="form-control" rows="2" placeholder="Địa chỉ"><?=$user->address?></textarea>
				    		</div>  
				      		<div class="register-form">
				    			<i class="fa fa-photo"  aria-hidden="true"></i>
								<input name="fileimg" type="file" class="file">
				    		</div>
			    		</div> 	
			    		<div class="container-fluid" style="text-align: center;">
				      		<button type="submit" class="button-done">Chỉnh sửa</button>
			      		</div>
			      	</div>
				    </form>
			    </div>
		  	</div>
		</div>

		<div class="modal fade" id="user-change-pass" tabindex="-1" role="dialog">
		  	<div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<div class="fillter-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
			        	<h4 class="modal-title">THAY ĐỔI MẬT KHẨU</h4>
			      	</div>
					<form method="post">
				    <input type="hidden" name="task" value="password">
			      	<div class="modal-body container-fluid" style="text-align: center;">
				    	<div class="rigister-box">
			    			<div class="user-id-name">Tài khoản: <b><?=$user->username?></b></div>
				    		<div class="register-form">
				    			<i class="fa fa-asterisk"  aria-hidden="true"></i>
				    			<input type="password" name="password" required placeholder="Mật khẩu*">
				    		</div>
				    		<div class="register-form">
				    			<i class="fa fa-asterisk"  aria-hidden="true"></i>
				    			<input type="password" name="password2" required placeholder="Mật khẩu mới*">
				    		</div>
				    		<div class="register-form">
				    			<input type="password" name="password3" required placeholder="Nhập lại mật khẩu mới*" style="margin-left: 46px;">
				    		</div>
				    	</div>
				    	<div class="clearfix"></div>	      	
  					</div>
			      	<div class="container-fluid" style="text-align: center;">
				      	<button type="submit" class="button-done">Đổi mật khẩu</button>
		      		</div>
				    </form>
			    </div>
		  	</div>
		</div>

		<div class="modal fade" id="user-subsidiary-edit" tabindex="-1" role="dialog">
		  	<div class="modal-dialog modal-lg" role="document">
			    <div class="modal-content">
			      	<div class="modal-header">
			      		<div class="fillter-close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
			        	<h4 class="modal-title">CHỈNH SỬA THÔNG TIN</h4>
			      	</div>
			      	<div class="modal-body container-fluid" style="text-align: center;">
					<form method="post">
				    	<input type="hidden" name="task" value="custom">
				    	<div class="rigister-box">
			    			<div class="register-form">
				    			<i class="fa fa-envelope"  aria-hidden="true"></i>
				    			<input type="email" name="email" value="<?=$user->email?>" required placeholder="Địa chỉ email*">
				    		</div>
				    		<div class="control-group register-form">
				    			<i class="fa fa-transgender"  aria-hidden="true"></i>
							  	<div class="controls">
								    <select name="sex" id="sex">
								      <option value="">Giới tính</option>
								      <option value="">---</option>
								      <option value="Nam" <?=$user->gender=='Nam'?'selected':''?>>Nam</option>
								      <option value="Nữ" <?=$user->gender=='Nữ'?'selected':''?>>Nữ</option>
								    </select>
							  	</div>
							</div>

							<div class="control-group register-form">
				    			<i class="fa fa-birthday-cake"  aria-hidden="true"></i>
							  	<div class="controls">
								  	<?php
									  	$birthday = explode('/', $user->birthday);
								  	?>
								    <select name="dob-day" id="dob-day">
								      <option value="">Ngày</option>
								      <option value="">---</option>
								      <?php for($i = 1; $i <= 31; $i++){ ?>
								      <option value="<?=strlen($i)==1?'0'.$i:$i?>" <?=@$birthday[0]==$i?'selected':''?>><?=strlen($i)==1?'0'.$i:$i?></option>
								      <?php } ?>
								    </select>
								    <select name="dob-month" id="dob-month">
								      <option value="">Tháng</option>
								      <option value="">-----</option>
								      <?php for($i = 1; $i <= 12; $i++){ ?>
								      <option value="<?=strlen($i)==1?'0'.$i:$i?>" <?=@$birthday[1]==$i?'selected':''?>><?=strlen($i)==1?'0'.$i:$i?></option>
								      <?php } ?>
								    </select>
								    <select name="dob-year" id="dob-year">
								      <option value="" style="">Năm</option>
								      <option value="">----</option>
								      <?php for($i = date('Y')-10; $i >= date('Y')-80; $i--){ ?>
								      <option value="<?=strlen($i)==1?'0'.$i:$i?>" <?=@$birthday[2]==$i?'selected':''?>><?=strlen($i)==1?'0'.$i:$i?></option>
								      <?php } ?>
								    </select>
							  	</div>
							</div>

							<div class="register-form">
				    			<i class="fa fa-arrows-alt"  aria-hidden="true"></i>
				    			<input type="text" name="giay" value="<?=$user->giay?>" placeholder="Size giầy">
				    		</div>

				    		<div class="register-form">
				    			<i class="fa fa-arrows-alt"  aria-hidden="true"></i>
				    			<input type="text" name="ao" value="<?=$user->ao?>" placeholder="Size áo">
				    		</div>

				    		<div class="register-form">
				    			<i class="fa fa-arrows-alt"  aria-hidden="true"></i>
				    			<input type="text" name="quan" value="<?=$user->quan?>" placeholder="Size quần">
				    		</div>
				    	</div>
				    	<div class="clearfix"></div>	      	
  					</div>
			      	<div class="container-fluid" style="text-align: center;">
				      	<button type="submit" class="button-done">Chỉnh sửa</button>
		      		</div>
				    </form>
			    </div>
		  	</div>
		</div>

    </element>
<?php include dirname(__FILE__) .'/footer.php'; ?>