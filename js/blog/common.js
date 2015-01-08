head.ready(function() {

	// $(document).on("click", function(){
			
	// });
	$('.js-open-nav').on('click', function(){
		$(this).toggleClass('is-active');
		$('.js-nav').toggleClass('is-active');
		$('body').toggleClass('is-active');
	});
	
	// scrollTop
	$(document).scroll(function() {    
		var scroll = $(this).scrollTop();
		var h_doc = $(document).height();
		var h_wind = $('.height').height();
		var h_footer = $('.footer').height();
		var scroll_position = h_doc - h_wind - h_footer;
		// alert(scroll_position)
		if (scroll > 0) {
			$(".scrolltop").fadeIn();
			if (scroll >= scroll_position) {
				$(".scrolltop").css({'position':'absolute'});
			}else{
				$(".scrolltop").css({'position':'fixed'});
			}
		}
		else{
			$(".scrolltop").fadeOut();
		}
	});
	$(".scrolltop").on('click', function(){
		var page = $(this).attr("href");
		$('html, body').animate({
			scrollTop: $(page).offset().top + 20
		}, 600);
		return false;
	});
	// $(function () {
	// 	var a = $(".scrolltop"),
	// 		c = a.offset(),
	// 		d = a.outerHeight(!0),
	// 		e = $(".footer").offset();
	// 	$(document).scroll(function () {
	// 		var b = $(this).scrollTop(),
	// 			b = e.top - (b + d + c.top);
	// 		0 < b ? a.css({
	// 			top: c.top
	// 		}) : a.css({
	// 			top: c.top + b
	// 		})
	// 	})
	// });
	
});
