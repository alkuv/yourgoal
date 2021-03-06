/*bild watermark*/	
(function( $ ){
	$.fn.WaterMark = function() {
		if(this.length){
				$(this).each(function(index, element) {
				var tmp_line = $(this).attr('placeholder');
				$(this).attr('placeholder','');
				$(this).wrap('<div class="watermark-box" style="position:relative;"></div>');
			
				var	wmb = $(this).parent('.watermark-box');
				wmb.append('<span></span>');
			
				wmb
					.children('span')
								.css({
									'padding-top':(parseInt($(this).css('padding-top'))-2)+'px',
									'padding-left':(parseInt($(this).css('padding-left'))-2)+'px'
								})
								.html(tmp_line);
		
				if(wmb.children('input').val() != ''){wmb.children('span').hide();}
			
				wmb
					.children('span')
								.click(function(e) {
									$(this).hide().siblings('input').focus();
								})
					.siblings('input')
								.blur(function(e) {
									if($(this).val()==''){
										$(this).siblings('span').show();
									}
								})
								.focus(function(e) {
									$(this).siblings('span').hide();
								});
                });
		}
	};
})( jQuery );
/*end bild watermark*/



$(document).ready(function() {
	//init
	$('.watermark').WaterMark();
	if($('select').length){$('select').styler();}
	
	if($('.reviews-list').length){
		$('.reviews-list').carouFredSel({
				auto: {
					timeoutDuration:8000
				},
				scroll:{
					items:1,
					pauseOnHover:true,
					duration:700,
					onAfter:function(data){
						$('.reviews-list-item').removeClass('odd');
						$(this).children('li:odd').addClass('odd');
					}
				},
				prev:'.prev-review',
				next:'.next-review',
				onCreate:function(data){
					$(this).children('li:odd').addClass('odd');
				}
		});
	}
	if($('.scroll-pane').length){
		$('.scroll-pane').jScrollPane({
			verticalDragMinHeight: 40,
	    	verticalDragMaxHeight: 40,
			contentWidth:300
		});
	}
	
	
	
	if($('.progressState').length){
		$('.progressState').each( function(){
			var state = parseInt($(this).attr('data-state'));
			$(this).width(state);
		});
	}

/*	$('.mainMenu-item').click(function(e) {
        $('.mainMenu-item').removeClass('active');
        $(this).addClass('active');
		var tmp = $(this).parent().index() + 1;
		$('.mainMenu-tabs').removeClass('active');
		$('.mainMenu-tab'+tmp).addClass('active');
		
		
		return false;
    });*/
	$('.textarea-editor-func').click( function(){
			if($(this).hasClass('active')){
				$(this).removeClass('active')
			} else{$(this).addClass('active')}
		return false;
	});

	$('.stepTab-next').click( function(){
		var pos = $(this).parents('.stepTab').index();
		var steps = $('.stepTab').length;
		if( pos+1 < steps ){
                     jQuery('body,html').animate({ scrollTop: 100 });
			$('.stepTab-head').removeClass('active');
			$('.stepTab').removeClass('active');
			$('.stepTab-head').eq(pos+1).addClass('active');
			$('.stepTab').eq(pos+1).addClass('active');
		}
		return false;
	});
	$('.stepTab-prev').click( function(){
		var pos = $(this).parents('.stepTab').index();
		var steps = $('.stepTab').length;
		
		if( pos > 0 ){
			$('.stepTab-head').removeClass('active');
			$('.stepTab').removeClass('active');
			$('.stepTab-head').eq(pos-1).addClass('active');
			$('.stepTab').eq(pos-1).addClass('active');
		}

		
		
		return false;
	});
	/* slidTo anchors*/
	/* click on header */
	/*
		$('.stepTab-head').click( function(){
		var pos = $(this).parents('.stepTab').index();
		var steps = $('.stepTab').length;
		if( pos+1 < steps ){
			$('.stepTab-head').removeClass('active');
			$('.stepTab').removeClass('active');
			$('.stepTab-head').eq(pos+1).addClass('active');
			$('.stepTab').eq(pos+1).addClass('active');
		}
		return false;
	});
	
	*/
	
	
	

	
});/*end document.ready*/


function tabing(id) 
	{
	jQuery(".stepTab-head").removeClass('active');
	jQuery("#"+id).addClass('active');
	jQuery(".stepTab").removeClass('active');
	if(id=="head1"){jQuery(".step1").addClass('active');}
	else if(id=="head2"){jQuery(".step2").addClass('active');}
	else if(id=="head3"){jQuery(".step3").addClass('active');}
	
	
	//alert(id);
	}
