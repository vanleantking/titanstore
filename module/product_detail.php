<?php

$item = get_post('product', array(
	'status' => 1,
	'alias' => $_GET['a'],
));

$category = get_post('category-product', array(
	'status' => 1,
	'id' => $item->parent,
));

$brand = get_post('brand', array(
	'status' => 1,
	'id' => $item->brand,
));

$colorID = get_post('color', array(
	'status' => 1,
	'id' => @$_GET['color'],
));
if($colorID && @$_GET['color']){
	$gallery = unserialize($colorID->gallery);
}
else{
	$gallery = unserialize($item->gallery);
}

$fields = unserialize($item->fields);

$price_new = $item->price - ($item->price * $item->discount / 100);
$price_new = $price_new > 0 ? $price_new : 0;

$breadcrum  = '<li><a href="'. site_url('san-pham') .'">Sản phẩm</a></li>';
$breadcrum .= '<li class="active">'. translate(@$item->title, @$item->title_en) .'</li>';
$metatitle = translate(@$item->title, @$item->title_en);
$metadescription = @strlength(strip_tags($item->content), 100);
$metakeywords = translate(@$item->title, @$item->title_en);
$metaimage = base_url('upload/'. @$item->photo);
$metaurl = site_url($brand->alias .'/'. @$item->alias);

include dirname(__FILE__) .'/header.php';
	
$layout = 'sub-banner'; include dirname(__FILE__) .'/loop.php';
?>
<element class="product-link">
	<ol class="breadcrumb container">
		<li><a href="<?=base_url()?>">Trang chủ</a></li>
		<?=$breadcrum?>
	</ol>
</element>

<div class="container">
	<div class="slider col-md-8">
        <div class="flexslider">
          <ul class="slides">
			<?php foreach($gallery as $i => $g){ ?>
            <li data-thumb="<?=base_url('upload/'. $g)?>">
  	    	    <img src="<?=base_url('upload/'. $g)?>" alt="<?=$item->title?>" />
    		</li>
			<?php } ?>
          </ul>
        </div>
  	</div>

  	<div class="product-show col-md-4">
  		<div class="product-infor">
			<p class="product-brand"><?=$brand->title?></p>
			<p class="product-id"><?=$item->title?></p>
			<?php if($item->discount){ ?>
				<p class="product-price"><strike><?=format_price($item->price)?></strike></p>
				<p class="product-price"><?=format_price($price_new)?></p>
			<?php } else { ?>
				<p class="product-price"><?=format_price($item->price)?></p>
			<?php } ?>
		</div>
		
		<?php $color1 = ''; if($item->color){ $colors = explode(',', $item->color); ?>
		<div class="product-show-title">CHỌN MÀU</div>
		<div class="product-color-box">
			<a href="<?=site_url($brand->alias .'/'. $item->alias)?>" title="<?=$item->title?>">
				<div class="product-color <?=@!$_GET['color']?'active':''?>" style="background-color: #fff">
					<img src="<?=base_url('upload/'. $item->photo)?>" alt="<?=$item->title?>">
				</div>
			</a>
			<?php foreach($colors as $i => $color){ if(!$i){ $color1 = @$_GET['color'] ? $_GET['color'] : $color; }
				$_color = get_post('color', array(
					'status' => 1,
					'id' => $color,
				));
			?>
			<a href="<?=site_url($brand->alias .'/'. $item->alias)?>?color=<?=$_color->id?>" title="<?=$_color->title?>">
				<div class="product-color <?=@$_GET['color']==$_color->id?'active':''?> selcolor_" id="<?=$_color->id?>" style="background-color: #<?=$_color->color?>">
					<?php if($_color->photo){ ?>
					<img src="<?=base_url('upload/'. $_color->photo)?>" alt="<?=$_color->title?>">
					<?php } ?>
				</div>
			</a>
			<?php } ?>
		</div>
		<div class="clearfix"></div>
		<?php } ?>
		
		<?php $size1 = ''; if($item->size){ $sizes = explode(',', $item->size); ?>
		<div class="product-show-title">CHỌN SIZE</div>
		<div class="product-size-box">
			<div class="product-size">
				<div class="btn-group sizewarning" role="group">
					
					<div class="shopping-warning-note hidden sizealert">
						<div class="warning-note">Vui lòng chọn size</div>
						<div class="warning-note-bottom"></div>
					</div>
					
				    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				      	<span class="size">Size</span>
				      	<span class="caret"></span>
				    </button>
				    <div class="clearfix"></div>
				    <div class="dropdown-spacing"></div>
				    <ul class="dropdown-menu">
					<?php $i = 0; foreach($sizes as $size){
						$_size = get_post('size', array(
							'status' => 1,
							'id' => $size,
						));
						if($_size->parent){
					?>
				      	<li class="selsize" id="<?=$_size->id?>"><?=$_size->title?></li>
					<?php $i++; }} ?>
				    </ul>
				  </div>
			</div>

			<div class="product-size number">
				<div class="btn-group" role="group">
				    <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				      Số lượng (<span class="qty">1</span>)
				      <span class="caret"></span>
				    </button>
				    <div class="clearfix"></div>
				    <div class="dropdown-spacing"></div>
				    <ul class="dropdown-menu">
				      	<li class="active selqty" id="1">01</li>
				      	<li class="selqty" id="2">02</li>
				      	<li class="selqty" id="3">03</li>
				      	<li class="selqty" id="4">04</li>
				      	<li class="selqty" id="5">05</li>
				      	<li class="selqty" id="6">06</li>
				      	<li class="selqty" id="7">07</li>
				      	<li class="selqty" id="8">08</li>
				      	<li class="selqty" id="9">09</li>
				      	<li class="selqty" id="10">10</li>
				    </ul>
				  </div>
			</div>
			
		</div>
		<div class="clearfix"></div>
		<?php } ?>
		
		<div class="call-to-action addcart" quantity="1" size="<?=$size1?>" color="<?=$color1?>" id="<?=$item->id?>">THÊM VÀO GIỎ</div>
		
		<div class="social-network">
			<p>Chia sẻ nội dung với bạn bè!</p>
			<a href="javascript:;" onClick="social('https://facebook.com/sharer/sharer.php?u=<?=site_url($brand->alias .'/'. $item->alias)?>')"><i class="fa fa-facebook"></i></a>
			<a href="javascript:;" onClick="social('https://plus.google.com/share?url=<?=site_url($brand->alias .'/'. $item->alias)?>')"><i class="fa fa-google-plus"></i></a>
			<a href="javascript:;" onClick="social('https://instagram.com/share.php?u=<?=site_url($brand->alias .'/'. $item->alias)?>')"><i class="fa fa-instagram"></i></a>
		</div>
  	</div>
  	
	<?php
		$rows = get_posts('product', array(
			'and' => 'id != "'. $item->id .'"',
			'status' => 1,
			'brand' => $item->brand,
			'order_by' => 'created DESC',
			'limit' => '0, 5',
		));
		if($rows) { ?>
	    <div class="clearfix"></div>
	    <div class="product-correlate-title">CÓ THỂ BẠN QUAN TÂM</div>
		<div id="product-correlate" class="owl-carousel owl-theme">
		<?php
			$layout = 'product-related';
			$i = 1;
			foreach($rows as $row)
			{
				$brand2 = get_post('brand', array(
					'status' => 1,
					'id' => $row->brand,
				));
			
				$category = get_post('category-product', array(
					'status' => 1,
					'id' => $row->parent,
				));
				
				include dirname(__FILE__) .'/loop.php';
				$i++;
			}
		?>
		</div>
	<?php } ?>
	
  	<?php if($item->content){ ?>
  	<div class="product-intro col-md-12">
		<div class="product-infor-title">THÔNG TIN SẢN PHẨM</div>
		<?=$item->content?>
	</div>
	<?php } ?>
	
	<div class="fb-comments" data-href="<?=site_url($brand->alias .'/'. $item->alias)?>" data-width="100%" data-numposts="5"></div>
	
</div>
<?php include dirname(__FILE__) .'/footer.php'; ?>