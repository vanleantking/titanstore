$(document).ready(function(){
	var windowsize = $(window).width();
	if(windowsize > 976) {
		$(".product-box").addClass("col-sm-4");
	}
	if(windowsize < 976) {
		$(".product-box").removeClass("col-sm-4").addClass("col-xs-6");
	}
	if(windowsize < 580) {
		$(".product-box").removeClass("col-xs-6").addClass("col-xs-12");
	}
});



$(window).resize(function(){
	var windowresize = $(window).width();
	if(windowresize > 976) {
		$(".product-box").removeClass("col-xs-6").addClass("col-sm-4");
	}
	if(windowresize < 976) {
		$(".product-box").removeClass("col-sm-4","col-xs-12").addClass("col-xs-6");
	}
	if(windowresize < 580) {
		$(".product-box").removeClass("col-xs-6").addClass("col-xs-12");
	}
});

$(document).ready(function(){
	var windowherrosize = $(window).width();
	if(windowherrosize > 750) {
		$(".herro-banner-background").addClass("col-sm-6");
	}
	if(windowherrosize < 750) {
		$(".herro-banner-background").removeClass("col-sm-6").addClass("col-xs-12");
	}
});



$(window).resize(function(){
	var windowherroresize = $(window).width();
	if(windowherroresize > 750) {
		$(".herro-banner-background").removeClass("col-xs-12").addClass("col-sm-6");
	}
	if(windowherroresize < 750) {
		$(".herro-banner-background").removeClass("col-sm-6").addClass("col-xs-12");
	}
});

$(window).ready(function(){
	var a = $(".shopping-user-infor").width() - 38 + "px";
	$(".shopping-user-infor-box").find("input").css({"width": a, "max-width": a});
	$(".shopping-user-infor-box").find("textarea").css({"width": a, "max-width": a});
});

$(window).resize(function(){
	var a = $(".shopping-user-infor").width() - 38 + "px";
	$(".shopping-user-infor-box").find("input").css({"width": a, "max-width": a});
	$(".shopping-user-infor-box").find("textarea").css({"width": a, "max-width": a});
});



jQuery(document).ready(function($){
	// browser window scroll (in pixels) after which the "back to top" link is shown
	var offset = 1,
		//browser window scroll (in pixels) after which the "back to top" link opacity is reduced
		offset_opacity = 300,
		//duration of the top scrolling animation (in ms)
		scroll_top_duration = 700,
		//grab the "back to top" link
		$back_to_top = $('.cd-top');

	//hide or show the "back to top" link
	$(window).scroll(function(){
		( $(this).scrollTop() > offset ) ? $back_to_top.addClass('cd-is-visible') : $back_to_top.removeClass('cd-is-visible cd-fade-out');
		if( $(this).scrollTop() > offset_opacity ) { 
			$back_to_top.addClass('cd-fade-out');
		}
	});

	//smooth scroll to top
	$back_to_top.on('click', function(event){
		event.preventDefault();
		$('body,html').animate({
			scrollTop: 0 ,
		 	}, scroll_top_duration
		);
	});

});

