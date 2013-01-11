<?php

/*
	Load menu items once
*/

if(!function_exists('friendly_create_demo_menu_items')) :

	function friendly_create_demo_menu_items()
	{

		//Automatically installs menus with the posts and pages we've just created as per the demo
		$run_once = get_option('friendly_install_default_menu_items');
	
		if (!$run_once)
		{
		    //give your menu a name
		    $name = 'Main Menu';
		    //create the menu
		    $menu_id = wp_create_nav_menu($name);
		    //then get the menu object by its name
		    $menu = get_term_by( 'name', $name, 'nav_menu' );
		    
		    $page_1_id = friendly_get_id_from_slug('contact-page','page');
		    $page_2_id = friendly_get_id_from_slug('example-pages','page');
		    $page_3_id = friendly_get_id_from_slug('404-error-page','page');
		    $page_4_id = friendly_get_id_from_slug('column-example','page');
		    $page_5_id = friendly_get_id_from_slug('example-product-page','page');
		    $page_6_id = friendly_get_id_from_slug('holding-page','page');
		    $page_7_id = friendly_get_id_from_slug('left-hand-sidebar','page');
		    $page_8_id = friendly_get_id_from_slug('no-sidebar','page');
		    $page_9_id = friendly_get_id_from_slug('right-hand-sidebar','page');
		    $page_10_id = friendly_get_id_from_slug('slider-and-accordion','page');
		    
		    $portfolio_1_id = friendly_get_id_from_slug('featured-portfolio-item','portfolio');
		    $portfolio_2_id = friendly_get_id_from_slug('portfolio-item-1','portfolio');
		    $portfolio_3_id = friendly_get_id_from_slug('full-width-with-large-slider','portfolio');
		
		    //then add the actual link/ menu item and you do this for each item you want to add
		    $home_page_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
		        'menu-item-title' =>  __('Home', THEMENAME),
		        'menu-item-classes' => 'home',
		        'menu-item-url' => home_url( '/' ), 
		        'menu-item-status' => 'publish',
		        'menu-item-parent-id' => 0
		    ));
		    
		    $example_pages_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
		        'menu-item-title' =>  __('Example Pages', THEMENAME),
		        'menu-item-classes' => '',
		        'menu-item-url' => home_url( '/' ).'example-pages', 
		        'menu-item-status' => 'publish',
		        'menu-item-parent-id' => 0
		    ));
		    
			$error_page_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('404 Error Page', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'example-pages/404-error-page', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $example_pages_menu_item
			));
			
			$column_example_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('Columns Example', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'example-pages/column-example', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $example_pages_menu_item
			));
			
			$example_product_page_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('Example Product Page', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'example-pages/example-product-page', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $example_pages_menu_item
			));
			
			$holding_page_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('Demo Holding Page', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'example-pages/holding-page', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $example_pages_menu_item
			));
			
			$left_hand_sidebar_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('Left Hand Sidebar', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'example-pages/left-hand-sidebar', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $example_pages_menu_item
			));
			
			$right_hand_sidebar_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('Right Hand Sidebar', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'example-pages/right-hand-sidebar', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $example_pages_menu_item
			));
			
			$no_sidebar_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('No Sidebar - Full Width', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'example-pages/no-sidebar', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $example_pages_menu_item
			));
			
			$slider_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('Slider And Accordion', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'example-pages/slider-and-accordion', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $example_pages_menu_item
			));
			
			
			$portfolio_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('Portfolio', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'portfolio', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => 0
			));
			
			$featured_portfolio_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('Featured Portfolio Item', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'portfolio/featured-portfolio-item', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $portfolio_menu_item
			));
			
			$first_portfolio_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('Example portfolio item', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'portfolio/portfolio-item-1', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $portfolio_menu_item
			));
			
			$full_width_portfolio_menu_item = wp_update_nav_menu_item($menu->term_id, 0, array(
				'menu-item-title' =>  __('Full width with large slider', THEMENAME),
				'menu-item-classes' => '',
				'menu-item-url' => home_url( '/' ).'portfolio/full-width-with-large-slider', 
				'menu-item-status' => 'publish',
				'menu-item-parent-id' => $portfolio_menu_item
			));
			
		
		    //then you set the wanted theme  location
		    $locations = get_theme_mod('nav_menu_locations');
		    
		    $locations['main-menu'] = $menu->term_id;
		    
		    set_theme_mod( 'nav_menu_locations', $locations );
		
		    // then update the menu_check option to make sure this code only runs once
		    update_option('friendly_install_default_menu_items', true);
		}
	
	}/* friendly_create_demo_menu_items() */

endif;

?>