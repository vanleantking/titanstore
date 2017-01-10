
<?php
$rows = get_posts('news', array(
	'status' => 1,
	'featured' => 1,
	'order_by' => 'created DESC',
	'limit' => 3
));
if($rows){ ?>
<div class="right-column">
	<div class="right-column-title">Bài viết nỗi bật</div>

	<?php foreach($rows as $row){ ?>
	<div class="right-column-news">
		<div id="news-img-id-02" class="rightcl-news-img" style="background-image: url(<?=base_url('upload/'. $row->photo)?>);"></div>
		<a href="<?=site_url('tin-tuc/'. $row->alias)?>">
		<div class="rightcl-news-titel">
			<?=$row->title?>
		</div>
		</a>
		<div class="rightcl-news-brief"><?=nl2br($row->intro)?></div>
	</div>
	<div class="clearfix"></div>
	<?php } ?>
</div>
<?php } ?>


<?php
$rows = get_posts('promotion', array(
	'status' => 1,
	'order_by' => 'created DESC',
	'limit' => 3
));
if($rows){ ?>
<div class="clearfix"></div>
<div class="right-column">
	<div class="right-column-title">Thông tin khuyến mãi</div>
	<?php foreach($rows as $row){ ?>
	<div class="right-column-news">
		<div id="news-img-id-02" class="rightcl-news-img" style="background-image: url(<?=base_url('upload/'. $row->photo)?>);"></div>
		<a href="<?=site_url('khuyen-mai/'. $row->alias)?>">
		<div class="rightcl-news-titel">
			<?=$row->title?>
		</div>
		</a>
		<div class="rightcl-news-brief"><?=nl2br($row->intro)?></div>
	</div>
	<div class="clearfix"></div>
	<?php } ?>
</div>
<?php } ?>