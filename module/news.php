<?php
$slug = $and = '';
$metatitle = $lang['news'];
$breadcrum  = '<li><a href="'. site_url('tin-tuc') .'">Tin tức</a></li>';

if(isset($_GET['a'])){
	$db->query("SELECT * FROM post WHERE extension IN ('category-news', 'news') AND status = 1 AND alias = '". $_GET['a'] ."' LIMIT 0, 1");
	$category = $db->result();
	
	$metatitle = @$category[0]->title;
	$metadescription = @$category[0]->intro;
	$metakeywords = @$category[0]->title;
	$metaimage = base_url('upload/'. @$category[0]->photo);
	$metaurl = site_url('tin-tuc/'. @$category[0]->alias);
	
	if(@$category[0]->extension == 'category-news'){
		$and = ' AND parent = "'. $category[0]->id .'" ';
		$slug = '/'. $category[0]->alias;
		$breadcrum .= '<li><strong>'. translate(@$category[0]->title, @$category[0]->title_en) .'</strong></li>';
	}
	else{
		$detail = @$category[0];
		$breadcrum .= '<li><strong>'. translate(@$detail->title, @$detail->title_en) .'</strong></li>';
	}
}


include dirname(__FILE__) .'/header.php';

$layout = 'sub-banner'; include dirname(__FILE__) .'/loop.php';
 
if(isset($detail)){ ?>
<element class="product-link">
	<ol class="breadcrumb container">
		<li><a href="<?=base_url()?>">Trang chủ</a></li>
		<?=$breadcrum?>
	</ol>
</element>

<element class="news-page">
    <div class="container">
    	<div class="col-sm-8">
	    	<div class="news">
	    		<div id="news-img-id-01" class="news-img" style="background-image: url(<?=base_url('upload/'. @$detail->photo)?>);"></div>
				<div class="news-titel">
    				<?=@$detail->title?>
				</div>
				<div class="news-brief-detail">
					<?=@$detail->intro?>
				</div>
				<div class="news-post-detail">
					<?=@$detail->content?>
				</div>
				<div class="time-post"><?=date('F d, Y', strtotime($detail->created))?> BY <?=@ getUser($detail->uid)->name ?></div>
				<div class="social-network">
					<a href="javascript:;" onClick="social('https://facebook.com/sharer/sharer.php?u=<?=site_url('tin-tuc/'. $detail->alias)?>')"><i class="fa fa-facebook"></i></a>
					<a href="javascript:;" onClick="social('https://plus.google.com/share?url=<?=site_url('tin-tuc/'. $detail->alias)?>')"><i class="fa fa-google-plus"></i></a>
					<a href="javascript:;" onClick="social('https://instagram.com/share.php?u=<?=site_url('tin-tuc/'. $detail->alias)?>')"><i class="fa fa-instagram"></i></a>
				</div>
				<br>
				<div class="fb-comments" data-href="<?=site_url('tin-tuc/'. $detail->alias)?>" data-width="100%" data-numposts="5"></div>
	    	</div>

		</div>
    	<div class="col-sm-4">
			<?php include dirname(__FILE__) .'/sidebar.php'; ?>
    	</div>
    </div>
</element>
<div class="clearfix"></div>

<?php } else { ?>

<element class="product-link">
	<ol class="breadcrumb container">
		<li><a href="<?=base_url()?>">Trang chủ</a></li>
		<?=$breadcrum?>
	</ol>
</element>

<element class="news-page">
    <div class="container">
    	<div class="col-sm-8">
			<?php
				$rowpage = 5;
				$curpage = 2;
				$getpage = empty($_GET['page']) ? 1 : $_GET['page'];
				$offset = ($getpage - 1) * $rowpage;
				
				$sql = "SELECT * FROM post WHERE extension = 'news' AND status = 1 ".$and." ORDER BY created DESC";
				$db->query($sql);
				$num = $db->total();
				
				$sql = $num > 0 ? $sql ." Limit $offset, $rowpage" : $sql;
				$db->query($sql);
				$rows = $db->result();
				
				$paging = form_paging($getpage, $num, $rowpage, $curpage, site_url('tin-tuc'. $slug), 1);
				
				if($rows){
					$layout = 'news-list';
					foreach($rows as $i => $row){
						include dirname(__FILE__) .'/loop.php';
					}
					unset($layout); unset($row);
				}
			?>
			<section><?=$paging?></section>
		</div>
    	<div class="col-sm-4">
			<?php include dirname(__FILE__) .'/sidebar.php'; ?>
    	</div>
    </div>
</element>
<div class="clearfix"></div>
<?php } ?>
<?php include dirname(__FILE__) .'/footer.php'; ?>