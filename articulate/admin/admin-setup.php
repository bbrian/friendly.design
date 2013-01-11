<?php

	/*
		The admin head hook
	*/

	if(!function_exists('of_head')) :

		function of_head()
		{ 
		
			do_action( 'of_head' );
			
		}/* of_head() */
	
	endif;

	/* ====================================================================================== */

	
	/*
		Add default options after activation 
	*/
	global $pagenow;
	if (is_admin() && isset($_GET['activated'] ) && $pagenow == "themes.php" )
	{
	
		//Call action that sets
		add_action('admin_head','of_option_setup');

	}


	/*
		set options=defaults if DB entry does not exist, else update defaults only
	*/
	
	if(!function_exists('of_option_setup')) :

		function of_option_setup()
		{
	
			global $options_machine;
			
			if (!get_option(OPTIONS))
			{
				
				//doesnt exist in db
				update_option(OPTIONS, $options_machine->Defaults);	
			
			}
		
		}/* of_option_setup() */
	
	endif;
	
	if(!defined('THEMENAME'))
	{
		$themedata = get_theme_data(STYLESHEETPATH . '/style.css');
		define('THEMENAME', $themedata['Name']);	
	}


	/* ====================================================================================== */


	/*
		Install admin message
	*/
	
	if(!function_exists('optionsframework_admin_message')) :

		function optionsframework_admin_message()
		{ 
		
	
		?>
	    	<script type="text/javascript">
	    
	    		jQuery(function(){
	
	    			var message = '<p><?php _e("This theme comes with an ",THEMENAME); ?>';
	    			var message = message + '<a href="<?php echo admin_url('admin.php?page=optionsframework'); ?>">';
	    			var message = message + '<?php _e("options panel",THEMENAME); ?>';
	    			var message = message + '</a>';
	    			var message = message + ' <?php _e("to configure its settings. It also supports",THEMENAME); ?>';
	    			var message = message + ' <a href="<?php echo admin_url('widgets.php'); ?>">';
	    			var message = message + 'widgets ';
	    			var message = message + '</a>';
	    			var message = message + ' and custom menus.';
	    			var message = message + '</p>';
	    	
	    		jQuery('.themes-php #message2').html(message);
	    
	    		});
	    
	    	</script>
	    <?php
		
		}/* optionsframework_admin_message() */
	
	endif;

	add_action('admin_head', 'optionsframework_admin_message'); 

	/* ====================================================================================== */


?>