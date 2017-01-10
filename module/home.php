<?php include dirname(__FILE__) .'/header.php'; ?>

<?php
	$video = get_post('banner', array(
		'status' => 1,
		'type' => 'video',
		'order_by' => 'created DESC',
	));
	if($video){
		$fields = @unserialize($video->fields);
		$youtube = explode('=', $fields['video']);
		$mp4 = explode('.', $fields['video']); ?>
    <element id="titan-video-herobanner">
    	<?php if(end($mp4) == 'mp4'){ ?>
    	<video class="video-in-banner" style="width: 100%" preload="auto" autoplay="true" loop="loop">
			<source src="<?=$fields['video']?>" type="video/mp4" media="(orientation:landscape)">
		</video>
		<?php } else { ?>
		<iframe 
    		id="video" 
    		allowfullscreen="allowfullscreen" 
    		mozallowfullscreen="mozallowfullscreen" 
    		msallowfullscreen="msallowfullscreen" 
    		oallowfullscreen="oallowfullscreen"
    		webkitallowfullscreen="webkitallowfullscreen" 
    		src="https://www.youtube.com/v/<?=end($youtube)?>?&version=3&controls=0&showinfo=0&loop=1&autoplay=1&rel=0&playlist=<?=end($youtube)?>" 
			frameborder="0">
		</iframe>
		<?php } ?>
		<div class="videopattern"></div>
		<a class="herro-banner-full-img" href="#" style="width: 100%; height:100%; position: absolute;">
			<div class="herro-banner-content">
        		<p class="herro-banner-big-title"><?=$video->title?></p>
    			<p class="herro-banner-sub-title"><?=nl2br($video->intro)?></p>
    			<?php if($video->link){ ?>
    			<a href="<?=$video->link?>"><div class="call-to-action"><?=$fields['button']?></div></a>
    			<?php } ?>
        	</div>
		</a>
    </element>
    
    <!-- upload video responsive script -->
	<script type="text/javascript">
    	$(window).ready(function() {
		   	var videobanner = $("#titan-video-herobanner").height();
		   	var videoheight = $(".video-in-banner").height();
		   	
		   	if (videobanner>videoheight) {
		   		$(".video-in-banner").css({"height": "100%", "width": "auto"});
		   	}
		   	$(".videopattern").css("height", videobanner);
		});
		$(window).resize(function() {
		   	var videobanner = $("#titan-video-herobanner").height();
		   	var videoheight = $(".video-in-banner").height();
		   	if (videobanner>videoheight) {
		   		$(".video-in-banner").css({"height": "100%", "width": "auto"});
		   	}
		   	else {
		   		$(".video-in-banner").css({"height": "auto", "width": "100%"});
		   	}
		   	$(".videopattern").css("height", videobanner);
		});
    </script>


    <!-- youtube video responsive script -->
    <script type="text/javascript">
    	$(function(){
		  $('#video').css({ width: $(window).innerWidth() + 'px', height: $(window).innerHeight() + 'px' });

		  // If you want to keep full screen on window resize
		  $(window).resize(function(){
		    $('#video').css({ width: $(window).innerWidth() + 'px', height: $(window).innerHeight() + 'px' });
		  });
		});
    </script>
    
<?php } else {
	$rows = get_posts('banner', array(
		'status' => 1,
		'type' => 'home',
		'order_by' => 'ordering ASC',
	));
	if($rows){ ?>
	<element id="titan-herro-banner" class="owl-carousel">
	<?php
		$layout = 'banner';
		foreach($rows as $row){
			$fields =@unserialize($row->fields);
			include dirname(__FILE__) .'/loop.php';
		}
	?>
	</element>
<?php }} ?>

	<?php $layout = 'brand'; include dirname(__FILE__) .'/loop.php'; ?>

	<element id="new-product" class="product-element">
		<div class="container">
			<div class="titan-title">
				SẢN PHẨM MỚI
			</div>

			<?php
				$row = get_post('product', array(
					'status' => 1,
					'featured' => 1,
					'order_by' => 'created DESC',
				));
				if($row)
				{
					$brand = get_post('brand', array(
							'status' => 1,
							'id' => $row->brand,
						));
										
					$category = get_post('category-product', array(
						'status' => 1,
						'id' => $row->parent,
					));
					
					$best = 'HOTTEST';
					$layout = 'product-hot';
					include dirname(__FILE__) .'/loop.php';
				}
			?>
			
			<?php
				$rows = get_posts('product', array(
					'status' => 1,
					'new' => 1,
					'order_by' => 'created DESC',
					'limit' => '0, 10',
				));
				if($rows)
				{
					$layout = 'product';
					$i = 1;
					foreach($rows as $row)
					{
						$brand = get_post('brand', array(
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
				}
			?>
			
			<div class="clearfix"></div>
			<div class="col-sm-12" style="text-align: center;">
				<a href="<?=site_url('san-pham-moi')?>"><div class="see-more">XEM THÊM SẢN PHẨM MỚI</div></a>
			</div>
		</div>
	</element>

	<element id="sale-product" class="product-element">
		<div class="container">
			<div class="titan-title">
				SẢN PHẨM SALE
			</div>

			<?php
				$row = get_post('product', array(
					'status' => 1,
					'sale' => 1,
					'order_by' => 'created DESC',
				));
				if($row)
				{
					$brand = get_post('brand', array(
							'status' => 1,
							'id' => $row->brand,
						));
										
					$category = get_post('category-product', array(
						'status' => 1,
						'id' => $row->parent,
					));
					
					$best = 'BEST SALE';
					$layout = 'product-hot';
					include dirname(__FILE__) .'/loop.php';
				}
			?>
			
			<?php
				$rows = get_posts('product', array(
					'status' => 1,
					'sale' => 1,
					'order_by' => 'created DESC',
					'limit' => '1, 10',
				));
				if($rows)
				{
					$layout = 'product';
					$i = 1;
					foreach($rows as $row)
					{
						$brand = get_post('brand', array(
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
				}
			?>

			<div class="clearfix"></div>
			<div class="col-lg-12" style="text-align: center;">
				<a href="<?=site_url('san-pham-sale')?>"><div class="see-more">XEM THÊM SẢN PHẨM SALE</div></a>
			</div>
		</div>
	</element>

<?php
	$rows = get_posts('news', array(
		'status' => 1,
		'order_by' => 'ordering ASC',
		'limit' => '0, 4'
	));
	if($rows){ ?>
	<element id="titan-new-feed" class="container-fluid">
	<?php
		$layout = 'news';
		$i = 1;
		foreach($rows as $row){
			include dirname(__FILE__) .'/loop.php';
			$i++;
		}
	?>
    </element>
<?php } ?>

<?php
	$rows = get_posts('testimonial', array(
		'status' => 1,
		'order_by' => 'ordering ASC',
	));
	if($rows){ ?>
	<element id="titan-customer">
    	<div class="container">
    		<div class="titan-title">
				KHÁCH HÀNG ĐÁNH GIÁ
			</div>
    		<div id="customer-feedback" class="owl-carousel owl-theme">
			<?php
				$layout = 'testimonial';
				$i = 1;
				foreach($rows as $row)
				{
					$fields = @unserialize($row->fields);
					
					include dirname(__FILE__) .'/loop.php';
					$i++;
				}
			?>
			</div>
    	</div>
	</element>
<?php } ?>
	    
<?php include dirname(__FILE__) .'/footer.php'; ?>