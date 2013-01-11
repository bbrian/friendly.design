<?php

if( !function_exists('friendly_dev_loader') ) :

	function friendly_dev_loader()
	{
	
		if( !is_admin() )
		{
		
			wp_enqueue_script( "grid_overlay_css", get_bloginfo('stylesheet_directory') . "/dev/js/overlay_grid.js", '' , '', '' );
			wp_enqueue_style( "grid_overlay_css", get_bloginfo('stylesheet_directory') . "/dev/js/overlay_grid.css", '', '', '' );
			wp_enqueue_script( "activate_grid_js", get_bloginfo('stylesheet_directory') . "/dev/js/activate_grid.js", '' , '', '' );
		
		}
	
	}/* friendly_dev_loader() */
	
endif;

add_action( "wp_enqueue_scripts", "friendly_dev_loader" );

?>