<?php
	
$headname = array(
	'article' 			=> 'Giới thiệu',
	'news' 				=> 'Tin tức',
	'testimonial' 		=> 'Khách hàng đánh giá',
	'banner' 			=> 'Herro Banner',
	'brand' 			=> 'Thương hiệu',
	'ad' 				=> 'Quảng cáo',
	'category-product' 	=> 'Phân loại sản phẩm',
	'product' 			=> 'Sản phẩm',
	'promotion' 		=> 'Khuyến mãi',
	'gallery' 			=> 'Gallery',
	'size' 				=> 'Kích thướt',
	'color' 			=> 'Màu sắc',
);

	
function getList(){
	global $db, $config, $headname, $islang;
	
	$rowpage = 50;
	$curpage = 2;
	$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
	$offset = ($getpage - 1) * $rowpage;
	
	$and = '';
	
	if(@$_GET['cid']){
		$and .= "AND parent = '". $_GET['cid'] ."'";
	}
	
	if(@$_GET['s']){
		$and .= "AND title LIKE '%". $_GET['s'] ."%'";
	}
	
	if(in_array($_GET['e'], array('category-news', 'category-product', 'size'))){
		$and .= "ORDER BY parent ASC";
	}
	else{
		$and .= "ORDER BY created DESC";
	}
	
	$sql = "SELECT * FROM post WHERE extension = '". $_GET['e'] ."' ". $and;
	$db->query($sql);
	$num = $db->total();
	
	$sql = $num > 0 ? $sql ." Limit $offset, $rowpage" : $sql;
	$db->query($sql);
	$rows = $db->result();
	
	$paging = form_paging($getpage, $num, $rowpage, $curpage, base_url('post/e/'. $_GET['e']));
	
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		foreach($_POST['id'] as $id)
		{
			$row = get_post($_GET['e'], array(
		        'id' => $id
	        ));
	        @unlink('../upload/'. $row->photo);
	        
	        $gallery = unserialize($row->gallery);
	        if($gallery){
		        foreach($gallery as $g)
		        	@unlink('../upload/'. $g);
	        }
	        
	        $db->delete('post', array(
		        'id' => $id
	        ));
		}
	    header('Location: '. base_url('post/e/'. $_GET['e']. ($getpage > 1 ? '/page/'.$getpage : '')));
	}

include 'header.php';
?>
            <h1 class="page-header"><?=$headname[$_GET['e']]?></h1>

            <!-- Add form -->
			<div class="row">
				<div class="col-md-8">
					<form class="form-inline" method="get">
						<div class="input-group">
							<?php $category = get_posts('category-'. $_GET['e']); if($category){ ?>
							<div class="input-group-btn">
								<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><span class="filter-category-name">Danh mục</span> <span class="caret"></span></button>
								<ul class="dropdown-menu">
			                        <?php foreach($category as $cat){ ?>
			                        <li><a href="#" id="<?=$cat->id?>" class="filter-category"><?=$cat->title?></a></li>
			                        <?php } ?>
									<li role="separator" class="divider"></li>
									<li><a href="#" id="" class="filter-category">Tất cả</a></li>
								</ul>
							</div>
							<input type="hidden" name="cid" class="filter-category-result" value="">
							<?php } ?>
							
							<div class="input-group-btn">
								<input type="text" class="form-control textbox" name="s" value="<?=$s?>" placeholder="Từ khoá" style="height: 32px;">					
							</div>
							
							<div class="input-group-btn">								
								<span class="input-group-btn">
									<button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
								</span>
							</div>
						</div>
						
					</form>
				</div>
				<div class="col-md-4 text-right">
		            <a href="<?=base_url('post/e/'. $_GET['e'] .'/form')?>" class="btn btn-success"><i class="fa fa-plus"></i> Thêm</a>
		            <button class="btn btn-danger" id="btDelete"><i class="fa fa-trash-o"></i> Xoá</button>
				</div>
			</div><br>
			
            <form method="post" name="adminForm">
		        <div class="table-responsive">
		            <table class="table table-bordered">
		                <thead>
		                    <tr>
			                    <th width="3%" class="text-center"><input type="checkbox" id="chkAll"></th>
		                        <th width="3%" class="text-center">#</th>
		                        <th>Tiêu đề</th>
								<?php if($islang && in_array($_GET['e'], array('article', 'category-news', 'news', 'promotion', 'category-product', 'product'))){ ?>
		                        <th width="3%">&nbsp;</th>
								<?php } ?>
		                        <th width="8%" class="text-center">Hình ảnh</th>
		                        <th width="10%" class="text-center">Ngày đăng</th>
		                        <th width="3%"></th>
		                        <th width="8%"></th>
		                    </tr>
		                </thead>
		                <tbody>
		                <?php
		                    if($rows){
		                        $i = ($rowpage * ($getpage-1)) + 1;
		                        foreach($rows as $row){
			                        
			                        $parent = '';
			                        if($row->parent && in_array($_GET['e'], array('category-product', 'size')))
			                        {
										$db->query("SELECT * FROM post WHERE extension IN ('category-product', 'size') AND id = '". $row->parent ."' ");
										$_parent = $db->result();
										$parent = $_parent[0]->title . ' &nbsp; <i class="fa fa-long-arrow-right text-danger"></i> &nbsp; ';
			                        }
		                ?>
		                    <tr>
			                    <td class="text-center"><input type="checkbox" name="id[]" value="<?=$row->id?>"></td>
		                        <td class="text-center"><?=$i?></td>
		                        <td><?=$parent . $row->title?></td>
								<?php if($islang && in_array($_GET['e'], array('article', 'category-news', 'news', 'promotion', 'category-product', 'product'))){ ?>
		                        <th class="text-center"><a href="<?=base_url('post/e/'. $_GET['e'] .'/language/'. $row->id)?>" data-toggle="tooltip" data-placement="top" title="Làm một bản dịch sang ngôn ngữ tiếng Anh"><img src="<?=base_url('assets/images/en.png')?>"></a></th>
								<?php } ?>
		                        <td class="text-center"><?php echo @$row->photo ? '<a href="'. base_url('../upload/'. $row->photo) .'" class="manific-image"><img src="'. base_url('../upload/'. $row->photo) .'" width="50" height="50"></a>' : ''; ?></td>
		                        <td class="text-center"><?=(int) $row->created ? date('d/m/Y\<\b\r\>H:i', strtotime($row->created)) : ''?></td>
		                        <td class="text-center"><?=$row->status?'<i class="fa fa-check" data-toggle="tooltip" data-placement="top" title="Kích hoạt"></i>':''?></td>
		                        <td class="text-center">
			                        <a href="<?=base_url('post/e/'. $_GET['e'] .'/form/'. $row->id)?>" data-toggle="tooltip" data-placement="top" title="Sửa"><i class="fa fa-pencil"></i></a> &nbsp; 
			                        <a href="<?=base_url('post/e/'. $_GET['e'] .'/delete/'. $row->id)?>" data-toggle="tooltip" data-placement="top" title="Xoá"><i class="fa fa-trash-o"></i></a> &nbsp; 
			                        <a href="<?=base_url('post/e/'. $_GET['e'] .'/copy/'. $row->id)?>" data-toggle="tooltip" data-placement="top" title="Copy"><i class="fa fa-copy"></i></a>
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
	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$db->query("SELECT * FROM post WHERE id = '". $id ."'");
	$rows = $db->result();
	$row = @$rows[0];
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$row = (object) $_POST;
		
		if(empty($_POST['title'])){
			$msg = 'Nhập vào tiêu đề.';
		}
		else{
		    $params = array(
		        'title' => isset($_POST['title']) ? $_POST['title'] : '',
		        'alias' => isset($_POST['alias']) ? $_POST['alias'] : '',
		        'intro' => isset($_POST['intro']) ? $_POST['intro'] : '',
		        'content' => isset($_POST['content']) ? $_POST['content'] : '',
		        'photo' => isset($_POST['photo']) ? $_POST['photo'] : '',
		        'status' => isset($_POST['status']) ? $_POST['status'] : 0,
		        'extension' => $_GET['e'],
		        'link' => isset($_POST['link']) ? $_POST['link'] : '',
		        'position' => isset($_POST['position']) ? $_POST['position'] : '',
		        'type' => isset($_POST['type']) ? $_POST['type'] : '',
		        'parent' => isset($_POST['parent']) ? $_POST['parent'] : '',
		        'price' => isset($_POST['price']) ? $_POST['price'] : '',
		        'discount' => isset($_POST['discount']) ? $_POST['discount'] : '',
		        'gallery' => isset($_POST['gallery']) ? serialize($_POST['gallery']) : '',
		        'fields' => isset($_POST['fields']) ? serialize($_POST['fields']) : '',
		        'brand' => isset($_POST['brand']) ? $_POST['brand'] : '',
		        'featured' => isset($_POST['featured']) ? $_POST['featured'] : '',
		        'model' => isset($_POST['model']) ? $_POST['model'] : '',
		        'quantity' => isset($_POST['quantity']) ? $_POST['quantity'] : '',
		        'tag' => isset($_POST['tag']) ? $_POST['tag'] : '',
		        'keywords' => isset($_POST['keywords']) ? $_POST['keywords'] : '',
		        'description' => isset($_POST['description']) ? $_POST['description'] : '',
		        'ordering' => isset($_POST['ordering']) ? $_POST['ordering'] : '',
		        'hot' => isset($_POST['hot']) ? $_POST['hot'] : 0,
		        'sale' => isset($_POST['sale']) ? $_POST['sale'] : 0,
		        'new' => isset($_POST['new']) ? $_POST['new'] : 0,
		        'size' => isset($_POST['size']) ? implode(',', $_POST['size']) : '',
		        'color' => isset($_POST['color']) ? (is_array($_POST['color']) ? implode(',', $_POST['color']) : $_POST['color']) : '',
		        'uid' => $_SESSION['adminID'],
		    );
		    
		    if($id){
			    $params['modified'] = date('Y-m-d H:i:s');
		        $db->update('post', $params, array(
		            'id' => $_GET['id'],
		        ));
		    }
		    else{
			    $params['created'] = date('Y-m-d H:i:s');
		        $db->insert('post', $params);
		    }
		    
			if(!empty($_POST['alias'])){
				$db->query("SELECT * FROM post WHERE id NOT IN (". $id .") AND alias = '". $_POST['alias'] ."'");
				$alias = $db->result();
			    
		        $db->update('post', array(
			        'alias' => $alias ? $_POST['alias'] . '-' . $id : $_POST['alias']
		        ), array(
		            'id' => $id,
		        ));
			}
		    header('Location: '. base_url('post/e/'. $_GET['e']));
	    }
	}
		
include 'header.php';
?>
            <?=isset($msg)?'<div class="alert alert-danger" role="alert">'. $msg .'</div>':''?>
            <h1 class="page-header"><?=$headname[$_GET['e']]?></h1>
			<form method="post" name="adminForm" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label">Tiêu đề</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="title" id="txtTitle" value="<?=@$row->title?>" required>
					</div>
				</div>
				
				<?php if(!in_array($_GET['e'], array('banner', 'ad', 'size'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">SEO URL</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="alias" id="txtSlug" value="<?=@$row->alias?>">
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('product'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Phân loại</label>
					<div class="col-sm-6">
	                    <select name="parent" class="form-control">
	                        <option value=""></option>
	                        <?php
								$categories = get_posts('category-'. $_GET['e'], array('parent' => 0));
		                        if($categories){ foreach($categories as $cat){ ?>
								<option value="<?=$cat->id?>" <?=$cat->id==@$row->parent?'selected':''?>><?=$cat->title?></option>
	                        	<?php
		                        	$subs = get_posts('category-'. $_GET['e'], array('parent' => $cat->id));
		                        	if($subs){ foreach($subs as $sub){ ?>
			                        	<option value="<?=$sub->id?>" <?=$sub->id==@$row->parent?'selected':''?>>-- <?=$sub->title?></option>
		                        <?php }} ?>
	                        <?php }} ?>
	                    </select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Thương hiệu</label>
					<div class="col-sm-6">
	                    <select name="brand" class="form-control">
	                        <option value=""></option>
	                        <?php $brands = get_posts('brand'); if($brands){ foreach($brands as $brand){ ?>
	                        <option value="<?=$brand->id?>" <?=$brand->id==@$row->brand?'selected':''?>><?=$brand->title?></option>
	                        <?php }} ?>
	                    </select>
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('banner', 'ad', 'gallery'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?=$_GET['e']=='gallery' ? 'Youtube' : 'Liên kết'?></label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="link" value="<?=@$row->link?>">
					</div>
				</div>
				<?php } ?>
				
				<?php if(!in_array($_GET['e'], array('product'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Giới thiệu</label>
					<div class="col-sm-6">
                   		<textarea class="form-control" name="intro"><?=@$row->intro?></textarea>
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('article', 'news', 'promotion', 'gallery'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Nội dung</label>
					<div class="col-sm-10">
                   		<textarea class="form-control" id="ckeditor" name="content"><?=@$row->content?></textarea>
				   		<script>CKEDITOR.replace('ckeditor');</script>
					</div>
				</div>
                <?php } ?>
                
				<div class="form-group">
					<label class="col-sm-2 control-label">Ảnh đại diện</label>
					<div class="col-sm-4">
						<button type="button" class="btn btn-default uploadFile" preview="picture"><i class="fa fa-cloud-upload"></i> Upload</button>
						<div id="picture" class="groupImg"><?php echo @$row->photo ? '<span><i class="fa fa-close deleteImg"></i><img src="'. base_url('../upload/'. $row->photo) .'" width="50" height="50"><input type="hidden" name="photo" value="'. $row->photo .'"></span>' : ''; ?></div>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">&nbsp;</label>
					<div class="col-sm-10">
						<label class="text-default"><input type="checkbox" name="status" value="1" <?=@$row->status || !isset($row->status)?'checked':''?>> Kích hoạt</label>
				
						<?php if(in_array($_GET['e'], array('news'))){ ?>
							&nbsp; &nbsp;
							<label class="text-default"><input type="checkbox" name="featured" value="1" <?=@$row->featured?'checked':''?>> Nổi bật</label>
						<?php } ?>
				
						<?php if(in_array($_GET['e'], array('product'))){ ?>
							&nbsp; &nbsp;
							<label class="text-default"><input type="checkbox" name="featured" value="1" <?=@$row->featured?'checked':''?>> Hoted</label>
							&nbsp; &nbsp;
							<label class="text-default"><input type="checkbox" name="sale" value="1" <?=@$row->sale?'checked':''?>> Best sale</label>
							&nbsp; &nbsp;
							<label class="text-default"><input type="checkbox" name="hot" value="1" <?=@$row->hot?'checked':''?>> Hot</label>
							&nbsp; &nbsp;
							<label class="text-default"><input type="checkbox" name="new" value="1" <?=@$row->new?'checked':''?>> New</label>
						<?php } ?>
					</div>
				</div>
				
				<?php if(in_array($_GET['e'], array('ad'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Vị trí</label>
					<div class="col-sm-3">
	                    <select name="position" class="form-control">
	                        <option value="top" <?=@$row->position=='top'?'selected':''?>>Trên</option>
	                        <option value="right" <?=@$row->position=='right'?'selected':''?>>Phải</option>
	                        <option value="left" <?=@$row->position=='left'?'selected':''?>>Trái</option>
	                        <option value="footer" <?=@$row->position=='footer'?'selected':''?>>Dưới</option>
	                    </select>
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('banner'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Loại</label>
					<div class="col-sm-3">
	                    <select name="type" class="form-control">
	                        <option value="home" <?=@$row->type=='home'?'selected':''?>>Trang chủ</option>
	                        <option value="sub" <?=@$row->type=='sub'?'selected':''?>>Trang con</option>
	                        <option value="video" <?=@$row->type=='video'?'selected':''?>>Video</option>
	                    </select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Vị trí</label>
					<div class="col-sm-3">
	                    <select name="position" class="form-control">
	                        <option value="1" <?=@$row->position==1?'selected':''?>>Trái</option>
	                        <option value="2" <?=@$row->position==2?'selected':''?>>Phải</option>
	                        <option value="3" <?=@$row->position==3?'selected':''?>>Giữa</option>
	                    </select>
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('category-product', 'size'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label"><?=$_GET['e']=='size' ? 'Size chính' : 'Danh mục chính'?></label>
					<div class="col-sm-3">
	                    <select name="parent" class="form-control">
	                        <option value=""></option>
	                        <?php
								$categories = get_posts($_GET['e'], array('parent' => 0));
		                        if($categories){
			                        foreach($categories as $cat){
				                        if(@$row->id != $cat->id){
	                        ?>
	                        <option value="<?=$cat->id?>" <?=$cat->id==@$row->parent?'selected':''?>><?=$cat->title?></option>
	                        	<?php
		                        	$subs = get_posts($_GET['e'], array('parent' => $cat->id));
		                        	if($subs){ foreach($subs as $sub){ if(@$row->id != $sub->id){ ?>
			                        	<option value="<?=$sub->id?>" <?=$sub->id==@$row->parent?'selected':''?>>-- <?=$sub->title?></option>
		                        <?php }}} ?>
	                        <?php }}} ?>
	                    </select>
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('product'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Số lượng</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="quantity" value="<?=@$row->quantity?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Giá tiền</label>
					<div class="col-sm-6">
						<input type="text" class="form-control price" name="price" value="<?=@$row->price?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Giảm giá (%)</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="discount" value="<?=@$row->discount?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Kích thướt</label>
					<div class="col-sm-6">
	                    <select name="size[]" class="form-control" multiple="" id="fisize">
	                        <option value="">--- Chọn ---</option>
	                        <?php
		                        $sizes = get_posts('size', array('parent' => 0));
		                        if($sizes){ foreach($sizes as $size){ $_size = @explode(',', $row->size); ?>
	                        <option value="<?=$size->id?>" <?=@in_array($size->id, $_size)?'selected':''?>><?=$size->title?></option>
		                    <?php }} ?>
	                    </select>
					</div>
				</div>
				<div id="result-size">
				<?php
				if(!empty($_size[0]))
				{
					$fields = @is_array($row->fields) ? $row->fields : @unserialize($row->fields);
					
					foreach($_size as $_sizeID)
					{
				        $_size_rows = get_posts('size', array('parent' => $_sizeID));
				        if($_size_rows){ $i = 1; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">&nbsp;</label>
								<div class="col-sm-6">
									<table class="table table-hover table-striped" style="margin-bottom: 0;">
										<tbody>
										<?php foreach($_size_rows as $_size_row){ ?>
											<tr>
												<td width="10%"><input type="checkbox" name="size[]" value="<?=$_size_row->id?>" <?=@in_array($_size_row->id, $_size)?'checked':''?>></td>
												<td width="45%"><?=@$_size_row->title?></td>
												<td width="45%"><input type="text" class="form-control" name="fields[<?=$_size_row->id?>][size]" value="<?=$fields [ $_size_row->id ] ['size']?>"></td>
											</tr>
										<?php $i++; } ?>
										</tbody>
									</table>
								</div>
							</div>
				<?php
						}
					}
				}					
				?>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Màu sắc</label>
					<div class="col-sm-6">
						<table class="table table-hover table-striped" style="margin-bottom: 0;">
							<tbody>
	                        <?php
		                        $colors = get_posts('color');
		                        if($colors){ foreach($colors as $color){ $_color = @explode(',', $row->color); ?>
								<tr>
									<td width="10%"><input type="checkbox" name="color[]" value="<?=$color->id?>" <?=@in_array($color->id, $_color)?'checked':''?>></td>
									<td><?=@$color->title?></td>
								</tr>
		                    <?php }} ?>
							</tbody>
						</table>
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('product', 'color'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Album ảnh</label>
					<div class="col-sm-4">
						<button type="button" class="btn btn-default uploadFile" preview="gallery"><i class="fa fa-cloud-upload"></i> Upload</button>
						<div id="gallery" class="groupImg">
						<?php if(@$row->gallery){
								$gallery = is_array($row->gallery) ? $row->gallery : unserialize(@$row->gallery);
								foreach($gallery as $g){ echo '<span><i class="fa fa-close deleteImg"></i><img src="'. base_url('upload/'. $g, '', 1) .'" width="50" height="50"><input type="hidden" name="gallery[]" value="'. $g .'"></span>'; }} ?>
						</div>
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('color', 'banner'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Chọn màu</label>
					<div class="col-sm-3">
						<input type="text" class="form-control jscolor" name="color" value="<?=@$row->color?>">
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('product'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Nội dung</label>
					<div class="col-sm-10">
                   		<textarea class="form-control" id="ckeditor" name="content"><?=@$row->content?></textarea>
				   		<script>CKEDITOR.replace('ckeditor');</script>
					</div>
				</div>
                <?php } ?>
				
				<?php if(in_array($_GET['e'], array('article', 'news', 'promotion', 'product'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Tag</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="tag" value="<?=@$row->tag?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">SEO từ khoá</label>
					<div class="col-sm-6">
                   		<textarea class="form-control" name="keywords"><?=@$row->keywords?></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">SEO giới thiệu</label>
					<div class="col-sm-6">
                   		<textarea class="form-control" name="description"><?=@$row->description?></textarea>
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('testimonial'))){ $fields = @is_array($row->fields) ? $row->fields : @unserialize($row->fields); ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Thang điểm</label>
					<div class="col-sm-3">
	                    <select name="fields[rate]" class="form-control">
	                        <?php for($i=1; $i <= 5; $i++){ ?>
	                        <option value="<?=$i?>" <?=@$fields['rate'] == $i ? 'selected' : '' ?>><?=$i?></option>
	                        <?php } ?>
	                    </select>
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('banner'))){ $fields = @is_array($row->fields) ? $row->fields : @unserialize($row->fields); ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Label button</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="fields[button]" value="<?=@$fields['button']?>">
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Youtube</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="fields[video]" value="<?=@$fields['video']?>">
					</div>
				</div>
				<?php } ?>
				
				<?php if(in_array($_GET['e'], array('banner', 'brand', 'testimonial', 'category-product', 'size'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Thứ tự sắp xếp</label>
					<div class="col-sm-3">
						<input type="text" class="form-control" name="ordering" value="<?=@$row->ordering?>">
					</div>
				</div>
				<?php } ?>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">&nbsp;</label>
					<div class="col-sm-4">
	                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
						<a href="<?=base_url('post/e/'. $_GET['e'])?>" class="btn btn-default"><i class="fa fa-eraser"></i> Huỷ</a>
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

	
function formLanguage(){
	global $db, $config, $headname;
	
	$id = isset($_GET['id']) ? $_GET['id'] : 0;
	$db->query("SELECT * FROM post WHERE id = '". $id ."'");
	$rows = $db->result();
	$row = @$rows[0];
	
	if($_SERVER['REQUEST_METHOD'] == 'POST')
	{
		$row = (object) $_POST;
	
	    $params = array(
	        'title_en' => $_POST['title_en'],
	        'intro_en' => $_POST['intro_en'],
	        'content_en' => isset($_POST['content_en']) ? $_POST['content_en'] : '',
	        'modified' => date('Y-m-d H:i:s'),
	    );
	    
        $db->update('post', $params, array(
            'id' => $_GET['id'],
        ));
	    header('Location: '. base_url('post/e/'. $_GET['e']));
	}
		
include 'header.php';
?>
            <?=isset($msg)?'<div class="alert alert-danger" role="alert">'. $msg .'</div>':''?>
            <h1 class="page-header"><?=$headname[$_GET['e']]?>: Tiếng Anh</h1>
			<form method="post" name="adminForm" class="form-horizontal">
				<div class="form-group">
					<label class="col-sm-2 control-label">Bản gốc</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" value="<?=@$row->title?>" readonly>
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Tiêu đề</label>
					<div class="col-sm-6">
						<input type="text" class="form-control" name="title_en" value="<?=@$row->title_en?>" required>
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">Giới thiệu</label>
					<div class="col-sm-6">
                   		<textarea class="form-control" name="intro_en"><?=@$row->intro_en?></textarea>
					</div>
				</div>
				
				<?php if(in_array($_GET['e'], array('article', 'news', 'promotion', 'condition', 'product'))){ ?>
				<div class="form-group">
					<label class="col-sm-2 control-label">Nội dung</label>
					<div class="col-sm-10">
                   		<textarea class="form-control summernote" name="content_en"><?=@$row->content_en?></textarea>
					</div>
				</div>
                <?php } ?>
				
				<div class="form-group">
					<label class="col-sm-2 control-label">&nbsp;</label>
					<div class="col-sm-4">
	                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Lưu</button>
						<a href="<?=base_url('post/e/'. $_GET['e'])?>" class="btn btn-default"><i class="fa fa-eraser"></i> Huỷ</a>
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
	
	$row = get_post($_GET['e'], array(
        'id' => $_GET['id']
    ));
    @unlink('../upload/'. $row->photo);
    
    $gallery = unserialize($row->gallery);
    if($gallery){
        foreach($gallery as $g)
        	@unlink('../upload/'. $g);
    }
    
    $db->delete('post', array(
        'id' => $_GET['id']
    ));
    
    header('Location: '. base_url('post/e/'. $_GET['e']));
}


function _copy(){
	global $db, $config, $headname;
	
	$id = $_GET['id'];
	
	$db->query("SELECT * FROM post ORDER BY id DESC");
	$rows = $db->result();
	$autoid = $rows[0]->id + 1;
	
	$db->query("CREATE TEMPORARY TABLE tmp SELECT * FROM post WHERE id = ". $id .";
				UPDATE tmp SET id = ". $autoid ." WHERE id = ". $id .";
				INSERT INTO post SELECT * FROM tmp WHERE id = ". $autoid);
				
	
	$db->query("SELECT * FROM post WHERE id = '". $autoid ."'");
	$rows = $db->result();
	
    $params['alias'] = $rows[0]->alias .'-'. $autoid;
    $db->update('post', $params, array(
        'id' => $autoid,
    ));
    
    header('Location: '. base_url('post/e/'. $_GET['e']));
}


switch(@$_GET['a']){
	case "language":
		formLanguage();
		break;
	case "copy":
		_copy();
		break;
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