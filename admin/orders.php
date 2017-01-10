<?php
$status = array(
	0 => 'Mới',
	1 => 'Hoàn thành',
	2 => 'Huỷ',
	3 => 'Đang giao',
);

$statusBG = array(
	0 => 'btn-success',
	1 => 'btn-info',
	2 => 'btn-danger',
	3 => 'btn-warning',
);
	
function getList(){
	global $db, $config, $status, $statusBG;
	
	$rowpage = 50;
	$curpage = 2;
	$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
	$offset = ($getpage - 1) * $rowpage;
	
	$sql = "SELECT * FROM orders ORDER BY created DESC";
	$db->query($sql);
	$num = $db->total();
	
	$sql = $num > 0 ? $sql ." Limit $offset, $rowpage" : $sql;
	$db->query($sql);
	$rows = $db->result();
	
	$paging = form_paging($getpage, $num, $rowpage, $curpage, base_url('orders'));
	
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		foreach($_POST['id'] as $id){
	        $db->delete('orders', array(
		        'id' => $id
	        ));
		}
	    header('Location: '. base_url('orders'. ($getpage > 1 ? '/page/'.$getpage : '')));
	}
?>
<?php include 'header.php'; ?>
            <h1 class="page-header">Đơn hàng</h1>

            <!-- Add form -->
            <p class="text-right">
	            <button class="btn btn-danger" id="btDelete"><i class="fa fa-trash-o"></i> Xoá</button>
            </p>
			<form method="post" name="adminForm">
				<div class="table-responsive">
		            <table class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th width="3%"><input type="checkbox" id="chkAll"></th>
		                        <th width="3%">#</th>
		                        <th class="text-center">Trạng thái</th>
		                        <th>Họ tên</th>
		                        <th>Email</th>
		                        <th class="text-center">Điện thoại</th>
		                        <th>Địa chỉ</th>
		                        <th class="text-right">Thành tiền</th>
		                        <th width="12%" class="text-center">Ngày đặt hàng</th>
		                        <th></th>
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
		                        <td class="text-center"><span style="padding: 4px 8px; font-size: 11px;" class="<?=$statusBG [ $row->status ]?>"><?=$status [ $row->status ]?></span></td>
		                        <td>
			                        <?=$row->name?><br>
		                        	<span class="text-muted">IP: <?=$row->ip?></span>
		                        </td>
		                        <td><?=$row->email?></td>
		                        <td class="text-center"><?=$row->phone?></td>
		                        <td><?=$row->address?></td>
		                        <td class="text-right"><?=format_price($row->total)?></td>
		                        <td class="text-center"><?=date('d/m/Y', strtotime($row->created))?></td>
		                        <td class="text-center"><a href="<?=base_url('orders/form/'. $row->id)?>" data-toggle="tooltip" data-placement="top"  title="Xem chi tiết"><i class="fa fa-eye"></i></a></td>
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
	global $db, $config, $status;
	
	$db->query("SELECT * FROM orders WHERE id = '". @$_GET['id'] ."'");
	$rows = $db->result();
	$row = @$rows[0];
	
	$db->query("SELECT * FROM orders_product WHERE oid = '". @$_GET['id'] ."'");
	$products = $db->result();
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
	    $params = array(
	        'status' => $_POST['status'],
	    );
	    
        $db->update('orders', $params, array(
            'id' => $_GET['id'],
        ));
	    header('Location: '. base_url('orders'));
	}
?>
<?php include 'header.php'; ?>
		<form method="post" name="adminForm" class="form-horizontal">
            <h1 class="page-header">Trạng thái</h1>
			<div class="form-group">
				<div class="col-sm-12">
					<label class="text-default"><input type="radio" name="status" value="0" <?=@$row->status==0?'checked':''?>> &nbsp; Mới</label>
					&nbsp; &nbsp;
					<label class="text-default"><input type="radio" name="status" value="1" <?=@$row->status==1?'checked':''?>> &nbsp; Hoàn thành</label>
					&nbsp; &nbsp;
					<label class="text-default"><input type="radio" name="status" value="2" <?=@$row->status==2?'checked':''?>> &nbsp; Huỷ</label>
					&nbsp; &nbsp;
					<label class="text-default"><input type="radio" name="status" value="3" <?=@$row->status==3?'checked':''?>> &nbsp; Đang giao</label>
				</div>
			</div>

            <h1 class="page-header">Thông tin đơn hàng</h1>
            <div class="table-responsive">
	            <table class="table table-bordered">
	                <thead>
	                    <tr>
	                        <th class="text-center" width="20%">Trạng thái</th>
	                        <th class="text-center" width="20%">Mã đơn hàng</th>
	                        <th class="text-center" width="20%">Ngày đặt hàng</th>
	                        <th class="text-center" width="20%">IP</th>
	                        <th class="text-center" width="20%">Tổng cộng</th>
	                    </tr>
	                </thead>
	                <tbody>
	                    <tr>
	                        <td class="text-center"><?=$status[ $row->status ]?></td>
	                        <td class="text-center"><?=$row->invoice?></td>
	                        <td class="text-center"><?=date('d/m/Y', strtotime($row->created))?></td>
	                        <td class="text-center"><?=$row->ip?></td>
	                        <td class="text-center"><?=format_price($row->total)?></td>
	                    </tr>
	                </tbody>
	            </table>
            </div>
            
            <h1 class="page-header">Thông tin đặt hàng</h1>
            <div class="table-responsive">
	            <table class="table table-bordered">
	                <tr>
	                    <th width="25%">Họ tên</th>
	                    <td><?=$row->name?></td>
	                </tr>
	                <tr>
	                    <th>Email</th>
	                    <td><?=$row->email?></td>
	                </tr>
	                <tr>
	                    <th>Số điện thoại</th>
	                    <td><?=$row->phone?></td>
	                </tr>
	                <tr>
	                    <th>Địa chỉ</th>
	                    <td><?=$row->address?></td>
	                </tr>
	                <tr>
	                    <th>Lời nhắn</th>
	                    <td><?=$row->message?></td>
	                </tr>
	            </table>
            </div>

            <h1 class="page-header">Thông tin sản phẩm</h1>
            <div class="table-responsive">
	            <table class="table table-bordered">
	                <thead>
	                    <tr>
	                        <th width="3%" class="text-center">#</th>
	                        <th>Sản phẩm</th>
	                        <th width="15%" class="text-center">Kích thướt</th>
	                        <th width="15%" class="text-center">Màu sắc</th>
	                        <th width="15%" class="text-right">Giá tiền</th>
	                        <th width="15%" class="text-center">Số lượng</th>
	                        <th width="15%" class="text-right">Thành tiền</th>
	                    </tr>
	                </thead>
	                <tbody>
		            <?php foreach($products as $i => $pd){ ?>
	                    <tr>
	                        <td class="text-center"><?=$i+1?></td>
	                        <td><?=$pd->name?></td>
	                        <td class="text-center"><?=$pd->size?></td>
	                        <td class="text-center"><?=$pd->color?></td>
	                        <td class="text-right"><?=format_price($pd->price)?></td>
	                        <td class="text-center"><?=$pd->quantity?></td>
	                        <td class="text-right"><?=format_price($pd->total)?></td>
	                    </tr>
	                <?php } ?>
	                </tbody>
	            </table>
            </div>
            
			<div class="form-group">
				<div class="col-sm-12">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
					<a href="<?=base_url('orders')?>" class="btn btn-default"><i class="fa fa-arrow-circle-o-left"></i> Quay lại</a>
					<a href="<?=base_url('orders/detail/'.$_GET['id'])?>" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> In hoá đơn</a>
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

	
function detail(){
	global $db, $config, $status;
	
	$db->query("SELECT * FROM orders WHERE id = '". @$_GET['id'] ."'");
	$rows = $db->result();
	$row = @$rows[0];
	
	$db->query("SELECT * FROM orders_product WHERE oid = '". @$_GET['id'] ."'");
	$products = $db->result();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>Titan Store</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css">
<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
</head>
<body>
<section>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
	            <h1 class="page-header">Thông tin đơn hàng</h1>
	            <div class="table-responsive">
		            <table class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th class="text-center" width="25%">Mã đơn hàng</th>
		                        <th class="text-center" width="25%">Ngày đặt hàng</th>
		                        <th class="text-center" width="25%">IP</th>
		                        <th class="text-center" width="25%">Tổng cộng</th>
		                    </tr>
		                </thead>
		                <tbody>
		                    <tr>
		                        <td class="text-center"><?=$row->invoice?></td>
		                        <td class="text-center"><?=date('d/m/Y', strtotime($row->created))?></td>
		                        <td class="text-center"><?=$row->ip?></td>
		                        <td class="text-center"><?=format_price($row->total)?></td>
		                    </tr>
		                </tbody>
		            </table>
	            </div>
	            
	            <h1 class="page-header">Thông tin đặt hàng</h1>
	            <div class="table-responsive">
		            <table class="table table-bordered">
		                <tr>
		                    <th width="25%">Họ tên</th>
		                    <td><?=$row->name?></td>
		                </tr>
		                <tr>
		                    <th>Email</th>
		                    <td><?=$row->email?></td>
		                </tr>
		                <tr>
		                    <th>Số điện thoại</th>
		                    <td><?=$row->phone?></td>
		                </tr>
		                <tr>
		                    <th>Địa chỉ</th>
		                    <td><?=$row->address?></td>
		                </tr>
		                <tr>
		                    <th>Lời nhắn</th>
		                    <td><?=$row->message?></td>
		                </tr>
		            </table>
	            </div>
	
	            <h1 class="page-header">Thông tin sản phẩm</h1>
	            <div class="table-responsive">
		            <table class="table table-bordered">
		                <thead>
		                    <tr>
		                        <th width="3%" class="text-center">#</th>
		                        <th>Sản phẩm</th>
		                        <th width="15%" class="text-center">Kích thướt</th>
		                        <th width="15%" class="text-center">Màu sắc</th>
		                        <th width="15%" class="text-right">Giá tiền</th>
		                        <th width="15%" class="text-center">Số lượng</th>
		                        <th width="15%" class="text-right">Thành tiền</th>
		                    </tr>
		                </thead>
		                <tbody>
			            <?php foreach($products as $i => $pd){ ?>
		                    <tr>
		                        <td class="text-center"><?=$i+1?></td>
		                        <td><?=$pd->name?></td>
		                        <td class="text-center"><?=$pd->size?></td>
		                        <td class="text-center"><?=$pd->color?></td>
		                        <td class="text-right"><?=format_price($pd->price)?></td>
		                        <td class="text-center"><?=$pd->quantity?></td>
		                        <td class="text-right"><?=format_price($pd->total)?></td>
		                    </tr>
		                <?php } ?>
		                </tbody>
		            </table>
	            </div>
			</div>
		</div>
	</div>
</section>
<script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
<?php
}


switch(@$_GET['a']){
	case "detail":
		detail();
		break;
	case "form":
		getForm();
		break;
	default:
		getList();
		break;
}