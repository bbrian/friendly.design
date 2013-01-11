<?php 

/*
	Register our menu locations
*/

if( function_exists( 'register_nav_menus' ) )
{

	if(!function_exists('friendly_register_menus')) :

		function friendly_register_menus()
		{
		
			register_nav_menus(
				array(
					'main-menu' => __( '01 - Main Menu', THEMENAME ),
					'sidebar-menu' => __( '02 - Sidebar Menu', THEMENAME ),
					'footer-menu' => __( '03 - Footer Menu', THEMENAME )
				)
			);
		
		}/* friendly_register_menus() */
	
	endif;

	add_action('init','friendly_register_menus');

}

?>