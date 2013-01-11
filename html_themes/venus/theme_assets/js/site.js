/* Silly IE8 */

jQuery(document).ready(function($) {

	if( $('body').hasClass('ie') ){
	
		$('#main_footer .footer_row .inner div.widget:last-of-type').addClass('last-no-margin-please');
	
	}

});

/* ======================================================================================= */

/* For TipTip */
jQuery(document).ready(function($) {
	
	//tipTip for any element with a 'tip' class
	$(".tip").tipTip();
	$(".tip_left").tipTip({defaultPosition: "left"});
	$(".tip_right").tipTip({defaultPosition: "right"});
	
	//tipTip for mailchimp input
	if( $('#mc_mv_EMAIL').length != 0 ){
		$("#mc_mv_EMAIL").tipTip({content: "Enter your e-mail address, then press Subscribe!"});
	}
	
	//tipTip for all inputs, but only run on inputs with the data-tip attribute
	$("input").each(function(){
	
		if( $(this).attr('data-tip') ){
			$(this).tipTip({attribute: "data-tip", defaultPosition: "right"});
		}
		
	});
	
});

/* ======================================================================================= */

/* Scroll to comments */
jQuery(document).ready(function($) {

	if( $('body').hasClass('single-post') ){
	
		if( $('.single_post_comment_bubble').length != 0 ){
		
			$('.single_post_comment_bubble').click(function(){
				$('html, body').animate({
					scrollTop: $("#comments").offset().top
				}, 1000);
				
				return false;                
			});
		
		}
	
	}

});
/* ======================================================================================= */

/* Main Menu */
;(function($) {

	$.friendlyMenu = function(el, options) {
	
		var defaults = {
			selector: '#nav',
			autoAlign: false
		}
		
		var plugin = this;
		
		plugin.settings = {}
		
		var init = function() {
			
			plugin.settings = $.extend({}, defaults, options);
			plugin.el = el;
			
			var selector = plugin.el ? plugin.el.selector : plugin.settings.selector;
			
			//$(selector + " ul").css({display: "none"});		//Opera…why you so not working?
			$(selector + " a").removeAttr("title");			//Title hover styles can cause problems
			
			//If the user wants to autoAlign the submenus if too close to edge of screen
			if(plugin.el && plugin.el.autoAlign){
            	
            	$(selector + '>li').has('ul').each(function(){
            		
            			//If the hovered menu would cause a horizontal scrollbar, force it to go the left, not right
            			
						var ww = $(window).width();
	           	 		var subUL = $(this).find("ul:first");
	            		var locUL = subUL.offset().left + subUL.width();

						if( $('body').hasClass('ie') ){
							$(this).addClass("goleft");
						}
	            		
	            		if (locUL > ww) {
	            			$(this).addClass("goleft");
	            		}
             		
            	});
				
			}
			
			$(selector + " li").hover(function(){
			
				$(this).find('ul:first').css({visibility: "visible", display: "none"}).fadeIn(300);
			
			},function(){
			
				$(this).find('ul:first').css({visibility: "hidden"});
			
			});
			
			//Add a class to the 'main' menu item when we're hovering over one of its children
			$(selector + " > li > ul").hover(function(){
			
				$(this).parent().addClass("hovering");
			
			},function(){
			
				$(this).parent().removeClass("hovering");
			
			});
		
		}
		
		init();
	
	}

})(jQuery);

jQuery(document).ready(function($) {
	
	var myplugin = new $.friendlyMenu({selector: "#nav", autoAlign: true});
	
	/*
		Add span to the bloody archives widget which doesn't have a userful filter
	*/
	
	if( $('div.widget_archive').length == 0 ){
	
	}else{

		$('div.widget_archive ul li').each(function(){
	
			var thishtml = $(this).html();
			var before_1 = thishtml.replace("(","<span>");
			var before = before_1.replace(")","</span>");
			
			$(this).html(before);
		
		});
	
	}


});

/* ======================================================================================= */

/*
	Function to clear form fields on focus if their value is not default
*/

function clearText(field){
	if (field.defaultValue == field.value) field.value = '';
	else if (field.value == '') field.value = field.defaultValue;
}

/* ======================================================================================= */

/*
	Because the archive and category widgets don't highlight the current post being shown, we need to do it. 
	NOT AWESOME
*/

jQuery(document).ready(function($) {

	if($('body').hasClass('single-post')){
	
		//Categories widget is "easy"
		if( $('div.widget_categories').length == 0 ){
		
		}else{
		
			var classes = $('div.widget_categories ul li').attr('class').split(/ /);
			$.each(classes, function(){ 
				
				if ($('body').hasClass(this)){ 
				
					$("li."+this).addClass("current-post");
				
				}
				
			});
		
		}
		
		//Archive widget rather brilliantly doesn't give you any classes at all. Awesome.
		if( $('.widget_archive').length == 0 ){
		
		}else{
		
			var all_lis = $('div.widget_archive ul li');
			$.each(all_lis, function(){
			
				var full_title = $(this).children('a').attr('title');
				var title = full_title.replace(/ /, "-").toLowerCase();
				
				if ($('body').hasClass(title)){
					$(this).addClass('current-post');
				} 
			
			});
		
		}
	
	}

});

/* ======================================================================================= */

/*
	NivoSlider home portfolio home page
*/

jQuery(document).ready(function($) {
	
	//Portfolio slider auto
	if( $('body').hasClass('single-portfolio') ){
	
		if( $('.port_home_slider').length != 0 ){
		
			$('.port_home_slider').nivoSlider({
				effect: 'random',
				manualAdvance: false,
				controlNav: false,
				keyboardNav: false
			});
		
		}
	
	}
	
	if( $('.port_home_slider').length != 0 ){
	
		$('.port_home_slider').nivoSlider({
			effect: 'fade',
			manualAdvance: true,
			controlNav: false,
			keyboardNav: false
		});
	}
	
});

/* ======================================================================================= */

jQuery(document).ready(function($) {

	if( $('.gallery-icon a[href$=".jpg"], .gallery-icon a[href$=".gif"], .gallery-icon a[href$=".png"]').length != 0 ){
		$('.gallery-icon a[href$=".jpg"], .gallery-icon a[href$=".gif"], .gallery-icon a[href$=".png"]').attr("rel","prettyPhoto");
	}

	if( $('a[rel^="prettyPhoto"]').length != 0 ){
		$('a[rel^="prettyPhoto"]').prettyPhoto({social_tools: false});
	}
	
	if( $('.makebig').length != 0 ){
		$('.makebig').prettyPhoto({social_tools: false});
	}
	
	if( $('.widget_sp_image a[target="_self"]').length != 0 ){
		$('.widget_sp_image a[target="_self"]').prettyPhoto({social_tools: false});
	}


});

/* ======================================================================================= */

jQuery(document).ready(function($) {

	if( $('p.comment_author').length != 0 ){
	
		$('p.comment_author').lettering('words');
	
	}

});

/* ======================================================================================= */

/*
	Fix the menu in place on scroll and fadeout
*/

jQuery(document).ready(function($) {

	$(window).scroll(function(){
		
		var scrollTop = $(window).scrollTop();
		if(scrollTop != 0)
			$('header[role="banner"]').stop().animate({'opacity':'0.75'},800);
		else
			$('header[role="banner"]').stop().animate({'opacity':'1'},300);
	});

	$('header[role="banner"]').hover(
		function (e) {
			var scrollTop = $(window).scrollTop();
			if(scrollTop != 0){
				$('header[role="banner"]').stop().animate({'opacity':'1'},300);
			}
		},
		function (e) {
			var scrollTop = $(window).scrollTop();
			if(scrollTop != 0){
				$('header[role="banner"]').stop().animate({'opacity':'0.75'},300);
			}
		}
	);

});