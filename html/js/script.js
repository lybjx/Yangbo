$(function() {
	var w = document.body.clientWidth;
	var h = w/3;
	$('#slider').attr('width', w);
	$('#slider').attr('height', h);
	$('.rslides img').attr('width', w);
	$('.rslides img').attr('height', h);
	$('.logo').css({top:0,left:361/1920*w});
	$('.navi_bar').css({top:0,left:483/1920*w});
	$('.login').css({top:0,left:1500/1920*w});
	$('.menu1').css({top:805/1920*w,left:818/1920*w});
	$('.intro').css({top:877/1920*w,left:663/1920*w});
	$('.intro_head').css({top:869/1920*w,left:556/1920*w});
	$('.intro_tail').css({top:869/1920*w,left:1331/1920*w});
	$('.menu2').css({top:1595/1920*w,left:764/1920*w});
	$('.foot').css({top:6340/1920*w,left:0});
	$("#dowebok").slick({
		dots: true,
		infinite: true,
		// centerMode: true,
		// slidesToShow: 1,
		// slidesToScroll: 1
	});
	// $('#dowebok').responsiveSlides({
	// 	pager: true,
	// 	nav: true,
	// 	namespace: 'centered-btns', 
	// });
});