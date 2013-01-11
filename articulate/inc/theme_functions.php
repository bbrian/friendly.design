<?php

	/* ===================================================================================== */

	global $data;
	$data = get_option(OPTIONS);
	
	//On first install this might not exist when we immediately activate theme (and throw a couple of errors)
	if(!$data || !is_array($data))
	{
		$data = array();
	}
	
	//Check if we have the themename defined
	if(!defined('THEMENAME'))
	{
		$themedata = get_theme_data(STYLESHEETPATH . '/style.css');
		define('THEMENAME', $themedata['Name']);
	}
	
	/* ===================================================================================== */
	
	//Add our image sizes
	if ( function_exists( 'add_image_size' ) )
	{
	
		//add_image_size( 'category-thumb', 300, 9999 ); //300 pixels wide (and unlimited height)
		//add_image_size( 'homepage-thumb', 220, 180, true ); //(cropped)
	
	}
	
	//If we use post formats, add support for them here
	if ( function_exists( 'add_theme_support' ) )
	{ 
	
		add_theme_support( 'post-formats', array( 'aside', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat', 'gallery' ) );
		add_theme_support( 'post-thumbnails', array( 'post', 'page', 'portfolio', 'services' ) );
	
	}
	
	//Remove the default [gallery] styles
	add_filter( 'use_default_gallery_style', '__return_false' );
	
	/* ===================================================================================== */
	
	require_once( dirname( __FILE__ ) . '/menu_registration.php' );
	require_once( dirname( __FILE__ ) . '/menu_functions.php' );
	
	require_once( dirname( __FILE__ ) . '/sidebar_registration.php' );
	
	require_once( dirname( __FILE__ ) . '/taxonomy_registration.php' );
	require_once( dirname( __FILE__ ) . '/taxonomy_functions.php' );
	
	require_once( dirname( __FILE__ ) . '/cpt_functions.php' );
	require_once( dirname( __FILE__ ) . '/cpt_registration.php' );
	
	require_once( dirname( __FILE__ ) . '/comment_functions.php' );
	
	require_once( dirname( __FILE__ ) . '/custom_theme_widgets.php' );
	
	require_once( dirname( __FILE__ ) . '/custom_shortcodes.php' );
	
	/* ===================================================================================== */

	/* 
		These are functions specific to this theme
	*/

	/* ===================================================================================== */
	
	/*
		Now that jQuery is set up, we need to load the rest of our scripts, doing so properly
	*/
	
	if(!function_exists('friendly_enqueue_scripts'))
	{
	
		function friendly_enqueue_scripts()
		{
			
			global $style_dir;
			
			wp_enqueue_script( 'tiptip_js',  $style_dir.'/theme_assets/js/jquery.tipTip.minified.js', '', '', true );
			wp_enqueue_script( 'friendly_widgets',  $style_dir.'/theme_assets/js/widgets.js', '', '', true );
			wp_enqueue_script( 'mosaic',  $style_dir.'/theme_assets/js/mosaic.js', '', '', true );
			wp_enqueue_script( 'jqeasing',  $style_dir.'/theme_assets/js/jquery.easing.1.3.min.js', '', '', true );
			
			
			wp_enqueue_script( 'site_js', $style_dir.'/theme_assets/js/site.js', '', '', true );
		
		}/* friendly_enqueue_scripts() */
		
		add_action( 'wp_enqueue_scripts', 'friendly_enqueue_scripts' );
	
	}
	
	/* ===================================================================================== */
	
	/*
		WordPress Editor Styles
	*/
	
	if(!function_exists('friendly_add_editor_styles')) :
	
		function friendly_add_editor_styles()
		{
	    
			global $current_screen;
			
			if( ($current_screen) && ($current_screen != '') )
			{
			
				if( property_exists($current_screen,'post_type') )
				{
				
					switch ($current_screen->post_type)
					{
						case 'post':
						case 'page':
						case 'portfolio':
						case 'services':
							add_editor_style('theme_assets/css/friendly-editor-style.css');
						break;

					}
				
				}
			
			}
	
		}/* friendly_add_editor_styles() */
	
	endif;

	add_action( 'admin_head', 'friendly_add_editor_styles' );
	
	/* ===================================================================================== */
	
	/*
		Adjust the default search form markup
	*/
	
	if(!function_exists('friendly_main_search_form')) :
	
		function friendly_main_search_form( $form )
		{
	
			$search_form_value = get_search_query();
			$search_form_value = ($search_form_value && ($search_form_value != "")) ? $search_form_value : "Start typing...";
	
		    $form = '<form role="search" method="get" id="searchform" action="' . home_url( '/' ) . '" ><div>
		    <input type="text" value="' . $search_form_value . '" name="s" id="s" onFocus="clearText(this)" onBlur="clearText(this)" />
		    <input type="submit" id="searchsubmit" value="'. esc_attr__('Search', THEMENAME) .'" />
		    </div>
		    </form>';
		
		    return $form;
		
		}/* friendly_main_search_form() */
	
	endif;

	add_filter( 'get_search_form', 'friendly_main_search_form' );
	
	/* ===================================================================================== */
	
	if ( ! isset( $content_width ) ) $content_width = 960;
	
?>