$(function() {
	var w = document.body.clientWidth;
	var h = w/3;
	$('#slider').attr('width', w);
	$('#slider').attr('height', h);
	$('.flash_slides img').attr('width', w);
	$('.flash_slides img').attr('height', h);
	$('.logo').css({top:0,left:361/1920*w});
	$('.navi_bar').css({top:0,left:483/1920*w});
	$('.login').css({top:0,left:1500/1920*w});
	$('.menu1').css({top:805/1920*w,left:818/1920*w});
	$('.intro').css({top:877/1920*w,left:663/1920*w});
	$('.intro_head').css({top:869/1920*w,left:556/1920*w});
	$('.intro_tail').css({top:869/1920*w,left:1331/1920*w});
	$('.school_content').css({top:1017/1920*w,left:360/1920*w});
	$('.school_content_more').css({top:1357/1920*w,left:896/1920*w});
	$('.menu2').css({top:1595/1920*w,left:764/1920*w});
	$('.foot').css({top:6340/1920*w,left:0});
	$(".flash_slides").slick({
		dots: true,
		infinite: true,
		autoplay: true
	});
	$(".school_slides").slick({
		dots: true,
		infinite: true,
		slidesToShow: 4,
		// autoplay: true
	});
	// $('#dowebok').responsiveSlides({
	// 	pager: true,
	// 	nav: true,
	// 	namespace: 'centered-btns', 
	// });
});