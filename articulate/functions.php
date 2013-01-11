<?php


	/*
		Set path to Options Framework and theme specific functions
	*/
	
	//define some constant paths
	define( 'ADMIN_PATH', dirname( __FILE__ ) . '/admin/' );
	define( 'INC_PATH', dirname( __FILE__ ) . '/inc/' );
	
	//define some constants
	define( 'CHILDTHEME', get_stylesheet_directory_uri() . '/' );
	define( 'ADMIN', CHILDTHEME . 'admin/' );
	
	$themedata = get_theme_data( STYLESHEETPATH . '/style.css' );
	define( 'THEMENAME', $themedata['Name'] );
	define( 'THEMEVERSION', $themedata['Version'] );
	define( 'OPTIONS', 'friendly_'.THEMENAME.'_options' );
	define( 'THEME_AUTHOR', 'iamfriendly' );	//iamfriendly or "Friendly Themes"
	
	define( 'LOCAL_UPDATES', false );
	define( 'REQUIRED_PLUGINS', false );
	define( 'FRIENDLY_DEV', true );
	
	/*
		Define internationalisation-related functions
	*/
	
	load_theme_textdomain( THEMENAME, get_template_directory() . '/languages');
	
	$locale = get_locale();
	$locale_file = get_template_directory()."/languages/$locale.php";
	if ( is_readable($locale_file) )
		require_once($locale_file);

	/* =========================================================================================== */
	
	/*
		Use a function to set up our includes to allow for child theming
	*/
	
	if ( ! function_exists( 'friendly_theme_setup' ) ) :
	
		function friendly_theme_setup()
		{
		
			/* ================================================================================ */
	
			/*
				Include files for the Theme Options Framework
			*/
			
			require_once ( dirname( __FILE__ ) . '/admin/admin-setup.php');			// Custom functions and plugins
			require_once ( dirname( __FILE__ ) . '/admin/admin-interface.php');		// Admin Interfaces 
			
			require_once ( dirname( __FILE__ ) . '/admin/theme-options.php'); 		// Options panel settings and custom settings
			require_once ( dirname( __FILE__ ) . '/admin/admin-functions.php'); 	// Theme actions based on options settings
			
			/* ================================================================================ */
			
			/*
				These files contain the custom theme functions 
			*/
			
			require_once ( dirname( __FILE__ ) . '/inc/theme_functions.php'); 		// custom functions
			require_once ( dirname( __FILE__ ) . '/admin/generic_functions.php');		// Generic friendly themes functions
			require_once ( dirname( __FILE__ ) . '/admin/install.php');				// Install & (re)set functions
			
			/* ================================================================================ */
			
			/*
				Custom Widgets
			*/
		
			require_once ( dirname( __FILE__ ) . '/admin/custom_widgets.php');
			
			/* ================================================================================ */
			
			/*
				Custom Shortcodes
			*/
		
			require_once ( dirname( __FILE__ ) . '/admin/custom_shortcodes.php');
			
			/* ================================================================================ */
			
			/*
				Contact Form
			*/
		
			require_once ( dirname( __FILE__ ) . '/admin/tiny-contact-form.php');

		
		}/* friendly_theme_setup() */
	
	endif;

	add_action( 'after_setup_theme', 'friendly_theme_setup' );
	
	
	/* =========================================================================================== */
	
	if(defined('REQUIRED_PLUGINS') && (REQUIRED_PLUGINS === true) )
	{
		require_once( dirname( __FILE__ ) . '/admin/required_plugins.php' );
	}
	
	/* =========================================================================================== */
	
	if(defined('LOCAL_UPDATES') && (LOCAL_UPDATES === true) )
	{
		require_once( dirname( __FILE__ ) . '/admin/update.php');
	}
	
	if(defined('FRIENDLY_DEV') && (FRIENDLY_DEV === true) )
	{
		require_once( dirname( __FILE__ ) . '/dev/dev.php');
	}
	

?>