<?php

/*
	Register the Portfolio Custom Post Type
*/

if(!function_exists('friendly_register_portfolio_cpt')) :

	function friendly_register_portfolio_cpt()
	{
		
		/* User has option to rename slug and title */
		
		$custom_p_slug = ( function_exists('friendly_option') ) ? friendly_option( 'portfolio_slug', 'portfolio', true ) : "portfolio";
		if($custom_p_slug && $custom_p_slug != 'portfolio')
		{
			$portfolio_slug = $custom_p_slug;
		}
		else
		{
			$portfolio_slug = "portfolio";
		}
		
		$custom_p_title = ( function_exists('friendly_option') ) ? friendly_option( 'portfolio_title', 'Portfolio', true ) : "Portfolio";
		if($custom_p_title && $custom_p_title != 'Portfolio')
		{
			$portfolio_title = $custom_p_title;
		}
		else
		{
			$portfolio_title = "Portfolio";
		}
		  
		$labels = array(
			'name' => _x($portfolio_title, 'post type general name', THEMENAME),
			'singular_name' => _x('Portfolio', 'post type singular name', THEMENAME),
			'add_new' => __('Add New', 'portfolio', THEMENAME),
			'add_new_item' => __('Add New Portfolio Item', THEMENAME),
			'edit_item' => __('Edit Portfolio Item', THEMENAME),
			'new_item' => __('New Portfolio Item', THEMENAME),
			'view_item' => __('View Portfolio Item', THEMENAME),
			'search_items' => __('Search Portfolio', THEMENAME),
			'not_found' =>  __('No portfolio items found', THEMENAME),
			'not_found_in_trash' => __('No portfolio items found in Trash', THEMENAME), 
			'parent_item_colon' => '',
			'menu_name' => 'Portfolio'
		);
		
		  $args = array(
		    'labels' => $labels,
		    'public' => true,
		    'publicly_queryable' => true,
		    'show_ui' => true, 
		    'show_in_menu' => true, 
		    'query_var' => true,
		    'rewrite' => true,
		    'rewrite' => array(
		    	'slug' => $portfolio_slug,
		    	'with_front' => FALSE
		    ),
		    'capability_type' => 'post',
		    'has_archive' => true, 
		    'hierarchical' => false,
		    'menu_position' => 20,
		    'supports' => array('title','editor','author','thumbnail','excerpt','comments','revisions','custom-fields'),
		    'register_meta_box_cb' => 'friendly_add_featured_metabox_to_portfolio',
		    //'taxonomies' => array('category')
		    'menu_icon' => get_stylesheet_directory_uri()."/admin/images/portfolio-icon.png"
		  );
		  
	  register_post_type('portfolio',$args);
	
	}/* iamfriendly_regitser_portfolio_post_type() */

endif;

add_action('init', 'friendly_register_portfolio_cpt');


/* ===================================================================================== */
/* ===================================================================================== */


/*
	Register the Portfolio Custom Post Type
*/

if(!function_exists('friendly_register_wwcd_cpt')) :

	function friendly_register_wwcd_cpt()
	{
	
		/* User has option to rename slug */
		  global $data;
		  $custom_s_slug = ( function_exists('friendly_option') ) ? friendly_option( 'services_slug', 'services', true ) : "services";
		  if($custom_s_slug && $custom_s_slug != 'services')
		  {
		  	$services_slug = $custom_s_slug;
		  }
		  else
		  {
		  	$services_slug = "services";
		  }
	
		$custom_s_title = ( function_exists('friendly_option') ) ? friendly_option( 'services_title', 'Services', true ) : "Services";
		if($custom_s_title && $custom_s_title != 'Services')
		{
			$services_title = $custom_s_title;
		}
		else
		{
			$services_title = "Services";
		}
	
		$labels = array(
		    'name' => _x($services_title, THEMENAME),
		    'singular_name' => _x('Service', THEMENAME),
		    'add_new' => __('Add New', THEMENAME),
		    'add_new_item' => __('Add New Service', THEMENAME),
		    'edit_item' => __('Edit Service', THEMENAME),
		    'new_item' => __('New Service', THEMENAME),
		    'view_item' => __('View Service', THEMENAME),
		    'search_items' => __('Search Services', THEMENAME),
		    'not_found' =>  __('No services found', THEMENAME),
		    'not_found_in_trash' => __('No services found in Trash', THEMENAME), 
		    'parent_item_colon' => '',
		    'menu_name' => 'Services'
		
		  );
		  
		  $args = array(
		    'labels' => $labels,
		    'public' => true,
		    'publicly_queryable' => true,
		    'show_ui' => true, 
		    'show_in_menu' => true, 
		    'query_var' => true,
		    'rewrite' => true,
		    'rewrite' => array(
		    	'slug' => $services_slug,
		    	'with_front' => FALSE
		    ),
		    'capability_type' => 'post',
		    'has_archive' => true, 
		    'hierarchical' => false,
		    'menu_position' => 20,
		    'supports' => array('title','editor','author','thumbnail','excerpt','comments','revisions','custom-fields'),
		    'menu_icon' => get_stylesheet_directory_uri()."/admin/images/box.png"
		  );
		  
	  register_post_type('services',$args);
	
	}/* iamfriendly_regitser_portfolio_post_type() */

endif;

add_action('init', 'friendly_register_wwcd_cpt');



?>