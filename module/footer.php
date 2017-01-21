    <div class="titan-footer">
    	<div class="container">
	    	<?php
				$row = get_post('article', array(
					'status' => 1,
					'id' => 29,
				));
				if($row){
	    	?>
    		<div class="col-sm-4 footer-box">
    			<p class="titan-name"><?=$row->title?></p>
    			<div class="titan-description">
    				<?=$row->content?>
    			</div>
    		</div>
    		<?php } ?>
    		<div class="col-sm-4 footer-box">
    			<p class="titan-name">LIÊN HỆ</p>
    			<p class="titan-description">
    				<i class="fa fa-mobile"></i> Phone: <?=$config['phone']?><br> 
    				<i class="fa fa-mobile"></i> Tel: <?=$config['tel']?><br> 
    				<i class="fa fa-map-marker"></i> Location: <?=$config['address']?>
				</p>
    		</div>
    		<div class="col-sm-4 footer-box">
	    		<div class="fb-page" data-href="<?=$config['facebook']?>" data-tabs="timeline" data-height="250" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="<?=$config['facebook']?>" class="fb-xfbml-parse-ignore"></blockquote></div>
    		</div>
    	</div>
    </div>

	<div class="noti-popup">
		<div class="modal fade titan-noti" id="noti-modal" tabindex="-1" role="dialog">
		  	<div class="modal-dialog" role="document">
		    	<div class="modal-content container-fluid">
			    	<div class="col-lg-12">
			    		<img src="<?=base_url()?>assets/image/add-to-cart.png">
				      	<p>THÊM VÀO GIỎ HÀNG THÀNH CÔNG!</p>
			      	</div>
				    <div class="col-lg-12 noti-button">
				      	<a href="<?=site_url('gio-hang')?>"><button class="go-to-cart" type="button"><i class="fa fa-shopping-cart"></i>KIỂM TRA GIỎ HÀNG</button></a>
				      	<button class="done-check" type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fa fa-check-circle"></i>XÁC NHẬN</button>
			    	</div>
		    	</div>
		  	</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
	</div>
	
	
<script>
function social(url){
	window.open(url, '_blank', 'width=500,height=400,toolbar=0,location=0,menubar=0,left=300,status=0,toolbar=0');	
}

var base_url = '<?=base_url()?>';
$(document).ready(function() {
	
	$("#titan-herro-banner").owlCarousel({
		navigation : true,
		slideSpeed : 500,
		paginationSpeed : 400,
		singleItem : true,
		autoPlay: 5000,
		// "singleItem:true" is a shortcut for:
		// items : 1, 
		// itemsDesktop : false,
		// itemsDesktopSmall : false,
		// itemsTablet: false,
		// itemsMobile : false
	});
 
  var owl = $("#customer-logo");
 
  owl.owlCarousel({
     
      itemsCustom : [
        [0, 1],
        [450, 2],
        [600, 4],
        [700, 6],
        [1000, 8],
        [1200, 8],
        [1400, 8],
        [1600, 8]
      ],
      navigation : true,
      autoPlay: 3000,
 
  });
 
  var owl = $("#customer-feedback");
 
  owl.owlCarousel({
     
      itemsCustom : [
        [0, 1],
        [450, 1],
        [600, 2],
        [700, 2],
        [1000, 3],
        [1200, 3],
        [1400, 3],
        [1600, 3]
      ],
      navigation : true,
      autoPlay: 8000,
  });


  $( "body" ).on( "click", ".filtercategory", function(e) {
	  e.preventDefault();
	  var id = $(this).attr('id');
	  $('#filtercategory').val(id);
	  $('.filtercategoryname').text( $(this).text() );
	  
	  $.post('<?=site_url('pfilter')?>', {
		  parent: id,
	  }, function(json){
		  $('.resultBrand').html(json.brand);
		  $('.resultSize').html(json.size);
	  }, 'json');
  });
  
  $( "body" ).on( "click", ".filterbrand", function(e) {
	  e.preventDefault();
	  var id = $(this).attr('id');
	  $('#filterbrand').val(id);
	  $('.filterbrandname').text( $(this).text() );
	  
	  $.post('<?=site_url('pfilter')?>', {
		  brand: id,
	  }, function(json){
		  $('.resultCategory').html(json.category);
		  $('.resultSize').html(json.size);
	  }, 'json');
  });

  $( "body" ).on( "click", ".filtersize", function(e) {
	  e.preventDefault();
	  var id = $(this).attr('id');
	  $('#filtersize').val(id);
	  $('.filtersizename').text( $(this).text() );
	  
	  $.post('<?=site_url('pfilter')?>', {
		  size: id,
	  }, function(json){
		  $('.resultCategory').html(json.category);
		  $('.resultBrand').html(json.brand);
	  }, 'json');
  });

  $('.filterprice').on('click', function(e){
	  e.preventDefault();
	  var id = $(this).attr('id');
	  $('#filterprice').val(id);
	  $('.filterpricename').text( $(this).text() );
  });

  $('.btfilter').on('click', function(e){
	  var brand = $('#filterbrand').val();
	  var size = $('#filtersize').val();
	  var price = $('#filterprice').val();
	  var category = $('#filtercategory').val();
	  
	  location = '<?=site_url('tim-kiem')?>?brand='+ brand +'&size='+ size +'&price='+ price +'&category='+ category;
  });
  
  

  $( "body" ).on( "click", ".selcolor", function(e) {
	  e.preventDefault();
	  var id = $(this).attr('id');
	  $('.addcart').attr('color', id);
	  $('.selcolor').removeClass('active');
	  $(this).addClass('active');
  });

  $( "body" ).on( "click", ".selsize", function(e) {
	  e.preventDefault();
	  var id = $(this).attr('id');
	  $('.addcart').attr('size', id);
	  $('.size').text($(this).text());
	  $('.selsize').removeClass('product-size-active');
	  $(this).addClass('product-size-active');
  });

  $( "body" ).on( "click", ".selqty", function(e) {
	  e.preventDefault();
	  var id = $(this).attr('id');
	  $('.addcart').attr('quantity', id);
	  $('.qty').text(id);
	  $('.selqty').removeClass('active');
	  $(this).addClass('active');
  });


  	$("#form-login").submit(function(e) {
	    e.preventDefault();
	    $.ajax({
		    type: 'post',
		    url: base_url +'login',
		    data: $(this).serialize(),
		    dataType: 'json',
		    success: function(json){
			    if(json){
				    location = base_url;
			    }
			    else{
		    		alert('Đăng nhập thất bại, vui lòng thử lại');
			    }
		    }
	    });
    });
  

  	$("#form-subscribe").submit(function(e) {
	    e.preventDefault();
	    $.ajax({
		    type: 'post',
		    url: base_url +'subscribe',
		    data: $(this).serialize(),
		    dataType: 'json',
		    success: function(json){
		        if(json['res']){
		        	$("#form-subscribe").html('<p class="notice">'+ json['msg'] +'</p>');
		        }
		    }
	    });
    });
	
    $("#form-contact").submit(function(e) {
	    e.preventDefault();
	    $.ajax({
		    type: 'post',
		    url: base_url +'contact',
		    data: $(this).serialize(),
		    dataType: 'json',
		    success: function(json){
		        if(json['res']){
		        	$("#form-contact").html('<p class="notice">'+ json['msg'] +'</p>');
		        }
		    }
	    });
    });

    $( "body" ).on( "click", ".addcart", function(e) {
	    e.preventDefault();
	    var id = $(this).attr('id');
	    var size = $(this).attr('size');
	    var color = $(this).attr('color');
	    var quantity = $(this).attr('quantity');
	    
	    if(size)
	    {
		    $.ajax({
			    type: 'post',
			    url: base_url +'cart',
			    data: {
				    id: id,
				    size: size,
				    color: color,
				    qty: quantity
			    },
			    dataType: 'json',
			    success: function(json){
					$('.number-shopping').text( json['quantity'] );
					$('#noti-modal').modal('show');
			    }
		    });
	    }
	    else{
		    $('.sizealert').removeClass('hidden');
		    $('.sizewarning').addClass('warning');
	    }
    });

    $( "body" ).on( "click", ".delcart", function(e) {
	    e.preventDefault();
	    var me = $(this);
	    $.ajax({
		    type: 'post',
		    url: base_url +'delcart',
		    data: {
			    id: me.attr('id')
		    },
		    dataType: 'json',
		    success: function(json){
				me.parents('.tr').remove();
				$('.number-shopping').text( json['quantity'] );
		    }
	    });
    });
    
    $("#form-order").submit(function(e) {
	    e.preventDefault();
	    $.ajax({
		    type: 'post',
		    url: base_url +'order',
		    data: $(this).serialize(),
		    dataType: 'json',
		    success: function(json){
		        if(json['res']){
		        	$("#form-order").remove();
		        	$("#form-order-cart").addClass('notice').html(json['msg']);
					$('body, html').animate({
						scrollTop: 0
					}, 1000);
					setTimeout(function(){
						$('.notice').fadeOut(function(){
							$('.notice').fadeIn();
						});
					}, 1000);
		        }
		        else{
		        	$(".msg").text(json['msg']);
		        }
		    }
	    });
    });
    
    $('.ordercart').click(function(){

	    if($('#name').val() == ''  ||  $('#email').val() == ''  ||  $('#address').val() == ''  ||  $('#phone').val() == ''){
		    $(".shopping-user-infor").addClass('warning');
		    $(".shopping-warning-note").removeClass('hidden');
	    }
	    else{
		    $.ajax({
			    type: 'post',
			    url: base_url +'order',
			    data: $(".shopping-user-infor").serialize(),
			    dataType: 'json',
			    success: function(json){
			        if(json['res']){
			        	$("#form-order").html('<div class="col-md-12 col-xs-12 shopping-col">'+ json['msg'] +'</div>');
			        }
			        else{
			        	$(".msg").text('<div class="finish-product">'+ json['msg'] +'</div>');
			        }
			    }
		    });
	    }
    });
    
    $('.editcart').click(function() {
	    var id = $(this).attr('id');
		$.post(base_url +'product-ajax', { id: id }, function(res){
			$('#editcartresult').html(res);
		});
    });


	
	// var ajaxload = 0;
	// var offset = 1;
	// var loadmore = $('#loadmore').offset();
	
	// $(window).scroll(function () {
	// 	if(ajaxload == 0 && loadmore.top <= $(window).scrollTop()) {
	// 		ajaxload = 1;
			
	// 		$.post(base_url +'product-more', { offset: offset }, function(res){
	// 			if(res){
	// 				$('#loadmore').before(res);
	// 				ajaxload = 0;
	// 				offset++;
	// 			}
	// 		});
	// 	}
	// });

});

/*
$(function(){
	SyntaxHighlighter.all();
});
*/

$(window).load(function(){
	$('.flexslider').flexslider({
	  	animation: "slide",
	  	controlNav: "thumbnails",
	  	start: function(slider){
	    	$('body').removeClass('loading');
	  	}
	});
});
</script>

<script type="text/javascript">
	$(document).ready(function() {
	 
  	var owl = $("#product-correlate");
	 
  	owl.owlCarousel({
	     
      	itemsCustom : [
	        [0, 2],
	        [450, 2],
	        [600, 2],
	        [700, 3],
	        [1000, 3],
	        [1200, 3],
	        [1400, 4],
	        [1600, 4]
	      ],
      	navigation : true,
      	autoPlay: 8000,
	 
	  });
	 
	});
</script>

<?php if(empty($_GET['p'])){ ?>
<!-- HOME MENU SCRIPT -->
<script type="text/javascript">
	var topOfSidebar = $("#menu-01").offset().top;
	//when the window scrolls check to see whether it is about to go off screen. If so then switch to fixed.       
	$(window).scroll(function() {
	    var topOfWindow = $(window).scrollTop();
	    if (topOfSidebar < topOfWindow) {
	        $(".navbar").addClass("navscroll");
	        $("#logo-black").css("display", "block");
	        $("#logo-white").css("display", "none");     
	    }
	    else {
	        $(".navbar").removeClass("navscroll");
	        $("#logo-black").css("display", "none");
	        $("#logo-white").css("display", "block");
	    }
	});
	$(window).resize(function() {
	    var topOfWindow = $(window).scrollTop();
	    if (topOfSidebar < topOfWindow) {
	        $(".navbar").addClass("navscroll");          
	    }
	    else {
	        $(".navbar").removeClass("navscroll");
	    }
	});
</script>
<?php } ?>


<!-- MENU SCRIPT -->
<script>
	var topOfSidebar = $("#menu-01").offset().top;
	//when the window scrolls check to see whether it is about to go off screen. If so then switch to fixed.       
	$(window).scroll(function() {
	    var topOfWindow = $(window).scrollTop();
	    if (topOfSidebar < topOfWindow) {
	        $(".menu-01").addClass("small-menu");
	        $(".menu-01").removeClass("big-menu");   
	    }
	    else {
	        $(".menu-01").addClass("big-menu");
	        $(".menu-01").removeClass("small-menu");
	    }
	});
	
</script>

<!-- SOCIAL TAB SCRIPT -->
<script type="text/javascript">
	$('.social-tab a').hover(
       function(){ $(this).addClass('social-hover') },
       function(){ $(this).removeClass('social-hover') }
	);
</script>

<script>
$(window).load(function(){
	$('.loader-box').remove();
});

var fbid = "<?=$config['fbid']?>";
</script>
<!--script src="thirdparty/script.js"></script-->

<script lang="javascript">(function() {var pname = ( (document.title !='')? document.title : document.querySelector('h1').innerHTML );var ga = document.createElement('script'); ga.type = 'text/javascript';ga.src = '//live.vnpgroup.net/js/web_client_box.php?hash=324ccd2d9e51858fd0e4a0e939e14e6d&data=eyJzc29faWQiOjI2NzUzMSwiaGFzaCI6IjIwMGJiZTgzM2E4NmM3ZTczNDQyODc3YjFkNmY3NGRkIn0-&pname='+pname;var s = document.getElementsByTagName('script');s[0].parentNode.insertBefore(ga, s[0]);})();</script>	

<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.8&appId=682986701835990";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
</body>
</html>