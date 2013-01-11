<?php

if(!function_exists('friendly_register_sidebars')) :
	
	function friendly_register_sidebars()
	{

		/* 
			Register the 'primary' sidebar for use on pages/posts.
		*/
		
		register_sidebar(
			array(
				'id' => 'primary',
				'name' => __( 'Primary', THEMENAME ),
				'description' => __( 'The primary sidebar used on pages and posts. By default on the Left Hand Side', THEMENAME ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			)
		);
	
		/* ================================================================================ */
		
		/*
			Register the sidebar for the holding page (primarily for the e-mail signup)
		*/
		
		register_sidebar(
			array(
				'id' => 'holding_page_below_countdown',
				'name' => __( 'Holding Page Widget Area', THEMENAME ),
				'description' => __( 'This widget area is used just below the countdown on the holding page (Only visible if you activate it in your theme options page)', THEMENAME ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			)
		);
		
		/* ================================================================================ */
		
		/*
			Register the sidebar for the 404 Page
		*/
		
		register_sidebar(
			array(
				'id' => 'error_404_page_widget_area',
				'name' => __( '404 Page Widget Area', THEMENAME ),
				'description' => __( 'Widget area for the 404 page (the page shown when a user gets to a page which does not exist)', THEMENAME ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			)
		);
		
		/* ================================================================================ */
		
		/*
			Register the sidebar for the bottom of single blog posts so people can add widgets
		*/
		
		register_sidebar(
			array(
				'id' => 'single_blog_post_after_content_before_comments',
				'name' => __( 'Single Blog Post - After Content', THEMENAME ),
				'description' => __( 'This widget area allows you to add custom widgets after your blog post\'s content and before the comments.', THEMENAME ),
				'before_widget' => '<div id="%1$s" class="widget %2$s">',
				'after_widget' => '</div>',
				'before_title' => '<h3 class="widget-title">',
				'after_title' => '</h3>'
			)
		);
		
		/* ================================================================================ */
		
		/* ================================================================================ */
		
	
	}/* friendly_register_sidebars() */

endif;

add_action( 'widgets_init', 'friendly_register_sidebars' );

?>