<?php if($layout == 'banner'){ ?>

	<div class="item herro-banner-item raw">
	<?php if($row->position == 1){ ?>
    	<div class="herro-banner-background" style="<?=$row->color ? 'background-color: #'. $row->color : ''?>">
        	<div class="herro-banner-content">
        		<p class="herro-banner-big-title"><?=$row->title?></p>
    			<p class="herro-banner-sub-title"><?=nl2br($row->intro)?></p>
    			<?php if($row->link){ ?>
    			<a href="<?=$row->link?>"><div class="call-to-action"><?=$fields['button']?></div></a>
    			<?php } ?>
        	</div>
    		
    	</div>
    	<div id="img-background-01" class="herro-banner-background" style="<?=$row->photo ? 'background-image: url('. base_url('upload/'. $row->photo) .');' : ''?>"></div>
    	
	<?php } else if($row->position == 2){ ?>
    	<div class="herro-banner-background pull-right" style="<?=$row->color ? 'background-color: #'. $row->color : ''?>">
        	<div class="herro-banner-content">
        		<p class="herro-banner-big-title"><?=$row->title?></p>
    			<p class="herro-banner-sub-title"><?=nl2br($row->intro)?></p>
    			<?php if($row->link){ ?>
    			<a href="<?=$row->link?>"><div class="call-to-action"><?=$fields['button']?></div></a>
    			<?php } ?>
        	</div>
    		
    	</div>
    	<div id="img-background-02" class="herro-banner-background" style="<?=$row->photo ? 'background-image: url('. base_url('upload/'. $row->photo) .');' : ''?>"></div>
    	
	<?php } else { ?>
    	<div class="herro-banner-full-img" style="<?=$row->photo ? 'background-image: url('. base_url('upload/'. $row->photo) .');' : ''?> <?=$row->color ? 'background-color: #'. $row->color : ''?>">
    		<div class="herro-banner-content">
        		<p class="herro-banner-big-title"><?=$row->title?></p>
    			<p class="herro-banner-sub-title"><?=nl2br($row->intro)?></p>
    			<?php if($row->link){ ?>
    			<a href="<?=$row->link?>"><div class="call-to-action"><?=$fields['button']?></div></a>
    			<?php } ?>
        	</div>
    	</div>
	<?php } ?>
	</div>
	
<?php } ?>

<?php if($layout == 'sub-banner'){
	$row = get_post('banner', array(
		'status' => 1,
		'type' => 'sub',
		'order_by' => 'created DESC',
	));
	if($row){ ?>
    <div class="sub-banner" style="<?=$row->photo ? 'background-image: url('. base_url('upload/'. $row->photo) .');' : ''?> <?=$row->color ? 'background-color: '. $row->color : ''?>"></div>
<?php }} ?>

<?php if($layout == 'brand'){
	$rows = get_posts('brand', array(
		'status' => 1,
		'order_by' => 'ordering ASC',
	));
	if($rows){ ?>
	<div id="customer-logo" class="owl-carousel owl-theme">
		<?php foreach($rows as $row){ ?>
		  	<div class="item">
				<a href="<?=site_url('thuong-hieu/'. $row->alias)?>" title="<?=$row->title?>"><img src="<?=base_url('upload/'. $row->photo)?>" alt="<?=$row->title?>"></a>
			</div>
		<?php } ?>
	</div>
<?php }} ?>

<?php if($layout == 'testimonial'){ ?>
  	<div class="item">
  		<div>
  			<div id="customer-0<?=$i?>" class="customer-avata" style="background-image: url(<?=base_url('upload/'. $row->photo)?>);"></div>
  			<div class="customer-feedback-detail">
	  			<div class="customer-star">
	            <?php for($i=1; $i <= 5; $i++){ ?>
                    <i class="fa fa-star<?=@$fields['rate'] < $i ? '-o' : '' ?>"></i>
                <?php } ?>
	  			</div>
  				<div class="costomer-name"><?=$row->title?></div>
  				<div class="feedback"><?=nl2br($row->intro)?></div>
  			</div>
  		</div>
	</div>
<?php } ?>

<?php if($layout == 'news'){ ?>
	<div class="col-md-3 new-feed-box">
		<div id="new-feed-01" class="new-feed-img" style="background-image: url(<?=base_url('upload/'. $row->photo)?>);">
			<div class="new-feed-infor">
				<a href="<?=site_url('tin-tuc/'. $row->alias)?>"><div class="new-feed-title"><?=$row->title?></div></a>
				<div class="new-feed-content"><?=nl2br($row->intro)?></div>
			</div>
		</div>
	</div>
<?php } ?>

<?php if($layout == 'product'){ ?>
	<a href="<?=site_url($brand->alias .'/'. $row->alias)?>">
		<div class="product-box">
			<div class="product-img-box">
				<img src="<?=base_url()?>assets/image/product/tranperance.png" alt="<?=$row->title?>" class="product-img" style="background-image: url(<?=base_url('upload/'. $row->photo)?>);">
			</div>
			<div class="label">
				<?php if($row->hot){ ?>
				<div class="hot-label">Hot</div>
				<?php } ?>
				<div class="new-label">New</div>
				<?php if($row->sale){ ?>
				<div class="sale-label">Sale</div>
				<?php } ?>
			</div>
			<div class="product-infor">
				<p class="product-brand"><?=$brand->title?></p>
				<p class="product-id"><?=$row->title?></p>
				<?php if($row->discount){
					$price_new = $row->price - ($row->price * $row->discount / 100);
					$price_new = $price_new > 0 ? $price_new : 0; ?>
					<p class="product-price"><strike><?=format_price($row->price)?></strike> &nbsp; <?=format_price($price_new)?></p>
				<?php } else { ?>
					<p class="product-price"><?=format_price($row->price)?></p>
				<?php } ?>
			</div>
		</div>
	</a>
<?php } ?>

<?php if($layout == 'product-hot'){ ?>
	<a href="<?=site_url($brand->alias .'/'. $row->alias)?>">
		<div class="product-box">
			<div class="product-img-box">
				<img src="<?=base_url()?>assets/image/product/tranperance.png" alt="<?=$row->title?>" class="product-big-img" style="background-image: url(<?=base_url('upload/'. $row->photo)?>);">
			</div>
			<div class="label">
				<?php if($row->hot){ ?>
				<div class="hot-label">Hot</div>
				<?php } ?>
				<div class="new-label">New</div>
				<?php if($row->sale){ ?>
				<div class="sale-label">Sale</div>
				<?php } ?>
			</div>
			<div class="hoted-product"><?=$best?></div>
			<div class="product-big-infor">
				<p class="product-brand"><?=$brand->title?></p>
				<p class="product-id"><?=$row->title?></p>
				<?php if($row->discount){
					$price_new = $row->price - ($row->price * $row->discount / 100);
					$price_new = $price_new > 0 ? $price_new : 0; ?>
					<p class="product-price"><strike><?=format_price($row->price)?></strike> &nbsp; <?=format_price($price_new)?></p>
				<?php } else { ?>
					<p class="product-price"><?=format_price($row->price)?></p>
				<?php } ?>
			</div>
		</div>
	</a>
<?php } ?>

<?php if($layout == 'product-related'){ ?>
  	<div class="item">
  		<a href="<?=site_url($brand2->alias .'/'. $row->alias)?>">
	  		<div class="product-correlate-item">
	  			<div class="product-correlate-img-box">
	  				<img src="<?=base_url('upload/'. $row->photo)?>">
	  			</div>
	  			<div class="product-correlate-info-box">
	  				<div><?=$brand2->title?></div>
	  				<div><?=$row->title?></div>
					<?php if($row->discount){
						$price_new = $row->price - ($row->price * $row->discount / 100);
						$price_new = $price_new > 0 ? $price_new : 0; ?>
						<div><strike><?=format_price($row->price)?></strike> &nbsp; <?=format_price($price_new)?></div>
					<?php } else { ?>
						<div><?=format_price($row->price)?></div>
					<?php } ?>
	  			</div>
  			</div>
		</a>
	</div>
<?php } ?>

<?php if($layout == 'news-list'){ ?>
	<div class="news">
		<a href="<?=site_url('tin-tuc/'. $row->alias)?>">
			<div id="news-img-id-01" class="news-img" style="background-image: url(<?=base_url('upload/'. $row->photo)?>);"></div>
		</a>
		<div class="time-post">
			<?=date('F d, Y', strtotime($row->created))?> BY <?=@ getUser($row->uid)->name ?>
		</div>
		<div class="social-network">
			<a href="javascript:;" onClick="social('https://facebook.com/sharer/sharer.php?u=<?=site_url('tin-tuc/'. $row->alias)?>')"><i class="fa fa-facebook"></i></a>
			<a href="javascript:;" onClick="social('https://plus.google.com/share?url=<?=site_url('tin-tuc/'. $row->alias)?>')"><i class="fa fa-google-plus"></i></a>
			<a href="javascript:;" onClick="social('https://instagram.com/share.php?u=<?=site_url('tin-tuc/'. $row->alias)?>')"><i class="fa fa-instagram"></i></a>
		</div>
		<div class="news-titel">
			<?=$row->title?>
		</div>
		<div class="news-brief"><?=nl2br($row->intro)?></div>
		<a href="<?=site_url('tin-tuc/'. $row->alias)?>">
			<div class="read-more">ĐỌC BÀI VIẾT</div>
		</a>
	</div>
<?php } ?>

<?php if($layout == 'gallery'){ ?>
	<figure data-toggle="modal" data-target="#modal-img<?=$i?>">
		<img src="<?=base_url('upload/'. $row->photo)?>" alt="<?=$row->title?>">
	</figure>

	<div class="modal fade" id="modal-img<?=$i?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog modal-lg titan-modal" role="document">
	    <div class="modal-content">
	    	<div class="modal-close" type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-times"></i></div>
	      	<div class="modal-body container-fluid">
	      		<div class="col-md-8">
		      		<?php if($row->link){ $youtube = explode('=', $row->link); ?>
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
		      		<?php } else { ?>
	      			<img src="<?=base_url('upload/'. $row->photo)?>" alt="<?=$row->title?>">
	      			<?php } ?>
	      		</div>
	      		<div class="col-md-4">
	      			<div class="news-titel">
	    				<?=$row->title?>
					</div>
		      		<p><?=$row->content?></p>
		      		<div class="time-post"><?=date('F d, Y', strtotime($row->created))?> by <?=@ getUser($row->uid)->name ?></div>
					<div class="social-network">
						<a href="javascript:;" onClick="social('https://facebook.com/sharer/sharer.php?u=<?=site_url('gallery')?>')"><i class="fa fa-facebook"></i></a>
						<a href="javascript:;" onClick="social('https://plus.google.com/share?url=<?=site_url('gallery')?>')"><i class="fa fa-google-plus"></i></a>
						<a href="javascript:;" onClick="social('https://instagram.com/share.php?u=<?=site_url('gallery')?>')"><i class="fa fa-instagram"></i></a>
					</div>
	      		</div>
	      	</div>
	    </div>
	  </div>
	</div>
<?php } ?>

<?php if($layout == 'filter'){ ?>
	<div class="container all-product-fillter">

		<div class="fillter-box">
      		<div class="btn-group">
			  	<button type="button" class="btn btn-light fillter-data-button filtercategoryname" data-toggle="dropdown">
	        	<?php
		        	if(isset($_GET['category'])){
						$row = get_post('category-product', array(
							'status' => 1,
							'id' => $_GET['category'],
						));
						echo @$row->title;
		        	}
		        	else{
			        	echo 'Mặt hàng';
		        	}
	        	?></button>
			  	<button type="button" class="btn btn-light dropdown-toggle fillter-data-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    	<span class="caret"></span>
			    	<span class="sr-only">Toggle Dropdown</span>
			  	</button>
			  	<ul class="dropdown-menu">
			  		<div class="fillter-category resultCategory">
					<?php
						$rows = get_posts('category-product', array(
							'status' => 1,
							'order_by' => 'ordering ASC',
						));
						if($rows){ foreach($rows as $row){ ?>
						<li><a href="#" id="<?=$row->id?>" class="filtercategory"><?=$row->title?></a></li>
					<?php }} ?>
				    </div>
			  	</ul>
			</div>
		</div>

      	<div class="fillter-box">
      		<div class="btn-group">
			  	<button type="button" class="btn btn-light fillter-data-button filterbrandname" data-toggle="dropdown">
	        	<?php
		        	if(isset($_GET['brand'])){
						$row = get_post('brand', array(
							'status' => 1,
							'id' => $_GET['brand'],
						));
						echo @$row->title;
		        	}
		        	else{
			        	echo 'Thương hiệu';
		        	}
	        	?></button>
			  	<button type="button" class="btn btn-light dropdown-toggle fillter-data-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    	<span class="caret"></span>
			    	<span class="sr-only">Toggle Dropdown</span>
			  	</button>
			  	<ul class="dropdown-menu">
				    <div class="fillter-category resultBrand">
					<?php
						$rows = get_posts('brand', array(
							'status' => 1,
							'order_by' => 'ordering ASC',
						));
						if($rows){ foreach($rows as $row){ ?>
						<li><a href="#" id="<?=$row->id?>" class="filterbrand"><?=$row->title?></a></li>
					<?php }} ?>
				    </div>
			  	</ul>
			</div>
		</div>

		<div class="fillter-box">
      		<div class="btn-group">
			  	<button type="button" class="btn btn-light fillter-data-button filtersizename" data-toggle="dropdown">
	        	<?php
		        	if(isset($_GET['size'])){
						$row = get_post('size', array(
							'status' => 1,
							'id' => $_GET['size'],
						));
						echo @$row->title;
		        	}
		        	else{
			        	echo 'Size';
		        	}
	        	?></button>
			  	<button type="button" class="btn btn-light dropdown-toggle fillter-data-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    	<span class="caret"></span>
			    	<span class="sr-only">Toggle Dropdown</span>
			  	</button>
			  	<ul class="dropdown-menu">
				    <div class="fillter-category resultSize">
					<?php
						$rows = get_posts('size', array(
							'status' => 1,
							'parent' => 0,
							'order_by' => 'ordering ASC',
						));
						if($rows){ foreach($rows as $row){ ?>
						<div class="fillter-category">
					  		<li class="fillter-category-title"><?=$row->title?></li>
							<?php
								$rows2 = get_posts('size', array(
									'status' => 1,
									'parent' => $row->id,
									'order_by' => 'ordering ASC',
								));
								if($rows2){ foreach($rows2 as $row2){ ?>
								<li><a href="#" id="<?=$row2->id?>" class="filtersize"><?=$row2->title?></a></li>
							<?php }} ?>
						</div>
					<?php }} ?>
				    </div>
			  	</ul>
			</div>
		</div>

		<div class="fillter-box">
      		<div class="btn-group">
			  	<button type="button" class="btn btn-light fillter-data-button filterpricename" data-toggle="dropdown">
	        	<?php
		        	if(isset($_GET['price'])){
						echo $_GET['price'] ? 'Từ cao đến thấp' : 'Từ thấp đến cao';
		        	}
		        	else{
			        	echo 'Giá';
		        	}
	        	?></button>
			  	<button type="button" class="btn btn-light dropdown-toggle fillter-data-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
			    	<span class="caret"></span>
			    	<span class="sr-only">Toggle Dropdown</span>
			  	</button>
			  	<ul class="dropdown-menu">
			  		<div class="fillter-category">
					    <li><a href="#" id="0" class="filterprice">Từ thấp đến cao</a></li>
					    <li><a href="#" id="1" class="filterprice">Từ cao đến thấp</a></li>
			    	</div>
			  	</ul>
			</div>
		</div>
		<div style="text-align: center;">
      		<button class="fillter-button btfilter">LỌC</button>
  		</div>
  	</div>
<?php } ?>

<?php if($layout == 'article-list'){ ?>
	<div class="news">
		<a href="<?=site_url('gioi-thieu/'. $row->alias)?>">
			<div id="news-img-id-01" class="news-img" style="background-image: url(<?=base_url('upload/'. $row->photo)?>);"></div>
		</a>
		<div class="time-post">
			<?=date('F d, Y', strtotime($row->created))?> BY <?=@ getUser($row->uid)->name ?>
		</div>
		<div class="social-network">
			<a href="javascript:;" onClick="social('https://facebook.com/sharer/sharer.php?u=<?=site_url('gioi-thieu/'. $row->alias)?>')"><i class="fa fa-facebook"></i></a>
			<a href="javascript:;" onClick="social('https://plus.google.com/share?url=<?=site_url('gioi-thieu/'. $row->alias)?>')"><i class="fa fa-google-plus"></i></a>
			<a href="javascript:;" onClick="social('https://instagram.com/share.php?u=<?=site_url('gioi-thieu/'. $row->alias)?>')"><i class="fa fa-instagram"></i></a>
		</div>
		<div class="news-titel">
			<?=$row->title?>
		</div>
		<div class="news-brief"><?=nl2br($row->intro)?></div>
		<a href="<?=site_url('gioi-thieu/'. $row->alias)?>">
			<div class="read-more">ĐỌC BÀI VIẾT</div>
		</a>
	</div>
<?php } ?>