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
	$('.student_content').css({top:1669/1920*w,left:360/1920*w});
	$('.student_content_more').css({top:2242/1920*w,left:896/1920*w});
	$('.announce_content').css({top:2480/1920*w,left:360/1920*w});
	$('.enrolment_content').css({top:3220/1920*w,left:0/1920*w});
	$('.media_center_title').css({top:4119/1920*w,left:864/1920*w});
	$('.media_center_english').css({top:4174/1920*w,left:848/1920*w});
	$('.media_content').css({top:4270/1920*w,left:360/1920*w});
	$('.media_content_more').css({top:4659/1920*w,left:896/1920*w});
	$('.home_title').css({top:4867/1920*w,left:864/1920*w});
	$('.home_english').css({top:4922/1920*w,left:851/1920*w});
	$('.home_content').css({top:5027/1920*w,left:360/1920*w});
	$('.home_content_more').css({top:5706/1920*w,left:896/1920*w});
	$('.site_map_content').css({top:5854/1920*w,left:0/1920*w,width:w,height:487/1920*w});
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
		autoplay: true
	});
	$(".media_slide").slick({
		dots: true,
		infinite: true,
		slidesToShow: 3,
		autoplay: true
	});
	$('.media_play_button').css({display:none});
	// $('#dowebok').responsiveSlides({
	// 	pager: true,
	// 	nav: true,
	// 	namespace: 'centered-btns', 
	// });
});