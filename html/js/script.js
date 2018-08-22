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
	$('.menu2').css({top:1595/1920*w,left:764/1920*w});
	$('.foot').css({top:6340/1920*w,left:0});
	$('#dowebok').responsiveSlides({
		pager: true,
		nav: true,
		namespace: 'centered-btns', 
	});
});