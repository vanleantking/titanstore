<?php
	
$headname = array(
	0 => 'Khách hàng',
	1 => 'Quản trị viên',
);
	
function getList(){
	global $db, $config, $headname;
	
	$rowpage = 50;
	$curpage = 2;
	$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
	$offset = ($getpage - 1) * $rowpage;
	
	$sql = "SELECT * FROM users WHERE gid = '". $_GET['e'] ."' ORDER BY id ASC";
	$db->query($sql);
	$num = $db->total();
	
	$sql = $num > 0 ? $sql ." Limit $offset, $rowpage" : $sql;
	$db->query($sql);
	$rows = $db->result();
	
	$paging = form_paging($getpage, $num, $rowpage, $curpage, base_url('users/e/'. $_GET['e']));
	
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		foreach($_POST['id'] as $id){
	        $db->delete('users', array(
		        'id' => $id
	        ));
		}
	    header('Location: '. base_url('users/e/'. $_GET['e']. ($getpage > 1 ? '/users/'.$getpage : '')));
	}
?>
<?php include 'header.php'; ?>
            <h1 class="page-header"><?=$headname[$_GET['e']]?></h1>

            <!-- Add form -->
            <p class="text-right">
	            <a href="<?=base_url('users/e/'. $_GET['e'] .'/form')?>" class="btn btn-success"><i class="fa fa-plus"></i> Thêm</a>
	            <button class="btn btn-danger" id="btDelete"><i class="fa fa-trash-o"></i> Xoá</button>
            </p>
			<form method="post" name="adminForm">
				<div class="table-responsive">
		            <table class="table table-bordered">
		                <thead>
		                    <tr>
			                    <th width="3%"><input type="checkbox" id="chkAll"></th>
		                        <th width="3%">#</th>
		                        <th>Họ tên</th>
		                        <th>Tài khoản</th>
		                        <th>Email</th>
		                        <th>Điện thoại</th>
		                        <th width="3%"></th>
		                        <th width="7%"></th>
		                    </tr>
		                </thead>
		                <tbody>
		                <?php
		                    if($rows){
		                        $i = ($rowpage * ($getpage-1)) + 1;
		                        foreach($rows as $row){
		                ?>
		                    <tr>
			                    <td><input type="checkbox" name="id[]" value="<?=$row->id?>"></td>
		                        <td><?=$i?></td>
		                        <td><?=$row->name?></td>
		                        <td><?=$row->username?></td>
		                        <td><?=$row->email?></td>
		                        <td><?=$row->phone?></td>
		                        <td class="text-center"><?=$row->status?'<i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Kích hoạt"></i>':''?></td>
		                        <td class="text-center">
			                        <a href="<?=base_url('users/e/'. $_GET['e'] .'/form/'. $row->id)?>" data-toggle="tooltip" data-placement="top" title="Sửa"><i class="fa fa-pencil"></i></a> &nbsp; 
			                        <a href="<?=base_url('users/e/'. $_GET['e'] .'/delete/'. $row->id)?>" data-toggle="tooltip" data-placement="top" title="Xoá"><i class="fa fa-trash-o"></i></a>
			                    </td>
		                    </tr>
		                <?php $i++; }} ?>
		                </tbody>
		            </table>
		            <?= $paging; ?>
				</div>
			</form>
        </div>
    </div>
</div>
</body>
</html>
<?php
}

	
function getForm(){
	global $db, $config, $headname;
	
	$db->query("SELECT * FROM users WHERE id = '". @$_GET['id'] ."'");
	$rows = $db->result();
	$row = @$rows[0];
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
	    $params = array(
	        'name' => $_POST['name'],
	        'username' => $_POST['username'],
	        'email' => $_POST['email'],
	        'status' => $_POST['status'],
	        'gid' => $_GET['e'],
	        'phone' => $_POST['phone'],
	        'gender' => $_POST['gender'],
	        'birthday' => $_POST['birthday'],
	        'address' => $_POST['address'],
	        'giay' => $_POST['giay'],
	        'ao' => $_POST['ao'],
	        'quan' => $_POST['quan'],
	        'photo' => $_POST['photo'],
	    );
	    
	    if($_GET['id']){
	        if($_POST['password'])
	            $params['password'] = md5($_POST['password']);
	        
	        $db->update('users', $params, array(
	            'id' => $_GET['id'],
	        ));
	    }
	    else{
	        $params['password'] = md5($_POST['password']);
	        $db->insert('users', $params);
	    }
	    header('Location: '. base_url('users/e/'. $_GET['e']));
	}
?>
<?php include 'header.php'; ?>
            
            <h1 class="page-header"><?=$headname[$_GET['e']]?></h1>
            
			<form method="post" name="adminForm" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label">Tên</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="name" value="<?=@$row->name?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Tài khoản</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="username" value="<?=@$row->username?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Email</label>
					<div class="col-sm-6">
						<input type="email" class="form-control" name="email" value="<?=@$row->email?>" required>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Mật khẩu</label>
					<div class="col-sm-6">
						<input type="password" class="form-control" name="password">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">&nbsp;</label>
					<div class="col-sm-2">
						<input type="checkbox" name="status" value="1" <?=@$row->status || !isset($row->status)?'checked':''?>> Kích hoạt
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Điện thoại</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="phone" value="<?=@$row->phone?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Giới tính</label>
					<div class="col-sm-6">
	                    <select name="gender" class="form-control">
	                        <option value=""></option>
							<option value="Nam" <?='Nam'==@$row->gender?'selected':''?>>Nam</option>
							<option value="Nữ" <?='Nữ'==@$row->gender?'selected':''?>>Nữ</option>
	                    </select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Ngày sinh</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="birthday" value="<?=@$row->birthday?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Địa chỉ</label>
					<div class="col-sm-6">
                   		<textarea class="form-control" name="address"><?=@$row->address?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Size giầy</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="giay" value="<?=@$row->giay?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Size áo</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="ao" value="<?=@$row->ao?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Size quần</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="quan" value="<?=@$row->quan?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Ảnh đại diện</label>
					<div class="col-sm-6">
						<button type="button" class="btn btn-default uploadFile" preview="picture"><i class="fa fa-cloud-upload"></i> Upload</button>
						<div id="picture" class="groupImg"><?php echo @$row->photo ? '<span><i class="fa fa-close deleteImg"></i><img src="'. base_url('../upload/'. $row->photo) .'" width="50" height="50"><input type="hidden" name="photo" value="'. $row->photo .'"></span>' : ''; ?></div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">&nbsp;</label>
					<div class="col-sm-6">
	                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
						<a href="<?=base_url('users/e/'. $_GET['e'])?>" class="btn btn-default"><i class="fa fa-eraser"></i> Huỷ</a>
					</div>
				</div>
            </form>
        </div>
    </div>
</div>
</body>
</html>
<?php
}


function delete(){
	global $db, $config, $headname;
	
	$db->delete('users', array(
        'id' => $_GET['id']
    ));
    
    header('Location: '. base_url('users/e/'. $_GET['e']));
}


switch(@$_GET['a']){
	case "delete":
		delete();
		break;
	case "form":
		getForm();
		break;
	default:
		getList();
		break;
}


