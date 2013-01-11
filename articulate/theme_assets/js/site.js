(function($) {

	/* Fix the menu on the home page after it reaches the top */
	$(window).scroll(function(){
	
		if( $('#lead_feature').length != 0 ){
		
			var feature_height = $('#lead_feature').height();
			var menu_offset = $('#main_header').position().top;
			var window_top = $(window).scrollTop();
			
			//When window_top >= tp menu_offset, make the menu fixed
			if( window_top >= menu_offset ){
				$('#main_header').addClass('fix_to_top');
			}
			
			//When the menu is fixed at the top and is about to get to the feature, "release" it.
			if( (window_top < feature_height) && ( $('#main_header').hasClass('fix_to_top') ) ){
				$('#main_header').removeClass('fix_to_top');
			}
		
		}
	
	});

})(jQuery);

jQuery(document).ready(function($) {

	/* ======================================================================================= */

	/* For TipTip */
	$(function(){
		
		//tipTip for any element with a 'tip' class
		$(".tip").tipTip();
		$(".tip_left").tipTip({defaultPosition: "left"});
		
		//tipTip for all inputs, but only run on inputs with the data-tip attribute
		$("input").each(function(){
		
			if( $(this).attr('data-tip') ){
				$(this).tipTip({attribute: "data-tip", defaultPosition: "right"});
			}
			
		});
		
	});
	
	/* ======================================================================================= */
	
	/*
		Add span to the bloody archives widget which doesn't have a userful filter
	*/
	
	if( $('div.widget_archive').length != 0 ){

		$('div.widget_archive ul li').each(function(){
	
			var thishtml = $(this).html();
			var before_1 = thishtml.replace("(","<span>");
			var before = before_1.replace(")","</span>");
			
			$(this).html(before);
		
		});
	
	}
	
	/* ======================================================================================= */
	
	/*
		Because the archive and category widgets don't highlight the current post being shown, we need to do it. 
		NOT AWESOME
	*/
	
	if($('body').hasClass('single-post')){
	
		//Categories widget is "easy"
		if( $('div.widget_categories').length != 0 ){
		
			var classes = $('div.widget_categories ul li').attr('class').split(/ /);
			$.each(classes, function(){ 
				
				if ($('body').hasClass(this)){ 
				
					$("li."+this).addClass("current-post");
				
				}
				
			});
		
		}
		
		//Archive widget rather brilliantly doesn't give you any classes at all. Awesome.
		if( $('.widget_archive').length != 0 ){
		
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
	
	
	/* ======================================================================================= */
	
	/*
		Function to clear form fields on focus if their value is not default
	*/
	
	function clearText(field){
		if (field.defaultValue == field.value) field.value = '';
		else if (field.value == '') field.value = field.defaultValue;
	}
	
	/* ======================================================================================= */
	
	/* Cards mosaic */
	if( $('.card_posts').length != 0 ){
	
		$('.fade').mosaic();
	
	}

	
	
	/* ======================================================================================= */
	
	/* Initalise the menu */
	$(document).ready(function(){
		var myplugin = new $.friendlyMenu({selector: ".text_menu", autoAlign: true});
	});
	
	/* ======================================================================================= */
	

});

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
	
	/* ======================================================================================= */
	
	

})(jQuery);