<?php

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    foreach($_POST['setting'] as $key => $val)
    {
	    $db->delete('setting', array(
	        'config_key' => $key,
	    ));
	    $db->insert('setting', array(
	        'config_key' => $key,
	        'config_value' => $val,
	    ));
	}
	header('Location: '. base_url('setting'));exit;
}


include 'header.php';
?>
            <h1 class="page-header">Cài đặt</h1>
                        
			<form method="post" class="form-horizontal" role="form">
				<div class="form-group">
					<label class="col-sm-3 control-label"><b class="text-danger">*</b> Name</label>
					<div class="col-sm-8">
						<input type="text" name="setting[name]" required class="form-control" value="<?=@$config['name']; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><b class="text-danger">*</b> Email</label>
					<div class="col-sm-8">
						<input type="email" name="setting[email]" required class="form-control" value="<?=@$config['email']; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Email CC</label>
					<div class="col-sm-8">
						<input type="email" name="setting[emailcc]" class="form-control" value="<?=@$config['emailcc']; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Địa chỉ</label>
					<div class="col-sm-8">
						<input type="text" name="setting[address]" class="form-control" value="<?=@$config['address']; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Điện thoại</label>
					<div class="col-sm-8">
						<input type="text" name="setting[phone]" class="form-control" value="<?=@$config['phone']; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Di động</label>
					<div class="col-sm-8">
						<input type="text" name="setting[tel]" class="form-control" value="<?=@$config['tel']; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"><b class="text-danger">*</b> SEO tiêu đề</label>
					<div class="col-sm-8">
						<input type="text" name="setting[title]" required class="form-control" value="<?=@$config['title']; ?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">SEO từ khoá</label>
					<div class="col-sm-8">
						<textarea name="setting[keywords]" class="form-control"><?=@$config['keywords']; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">SEO giới thiệu</label>
					<div class="col-sm-8">
						<textarea name="setting[description]" class="form-control"><?=@$config['description']; ?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Facebook Chat ID</label>
					<div class="col-sm-8">
						<input type="text" name="setting[fbid]" class="form-control" value="<?=@$config['fbid']; ?>" placeholder="" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Facebook</label>
					<div class="col-sm-8">
						<input type="text" name="setting[facebook]" class="form-control" value="<?=@$config['facebook']; ?>" placeholder="http://" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Google+</label>
					<div class="col-sm-8">
						<input type="text" name="setting[google]" class="form-control" value="<?=@$config['google']; ?>" placeholder="http://" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label">Instagram</label>
					<div class="col-sm-8">
						<input type="text" name="setting[instagram]" class="form-control" value="<?=@$config['instagram']; ?>" placeholder="http://" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-3 control-label"></label>
					<div class="col-sm-8">
						<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
					</div>
				</div>
			</form>

        </div>
    </div>
</div>
</body>
</html>