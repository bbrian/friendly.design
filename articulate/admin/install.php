<?php

	/*
		This file contains functions which are run when the plugin is activated or when the user wants to 
		(re)set the options to the same as the demo site 
	*/
	
	$data = get_option(OPTIONS);
	if( !is_array($data) )
		$data = array();
	
	//We will have a completely separate option to tell us whether the options/posts have been installed.
	$separate_install_option_name = THEMENAME."_theme_installed";
	$have_we_installed = get_option( $separate_install_option_name );
	
	
	
	if( $have_we_installed === false )
	{
	
		//If the db option is empty OR if we've emptied the specific install option
		if( !empty($data) && ( array_key_exists('install_options_radio', $data) && $data['install_options_radio'] != "" ) )
		{
		
			$chosen_install = $data['install_options_radio'];
		
			if( $chosen_install == "demo" )
			{
				
				//Run the demo install
				include_once('install_postdata.php');
				
				//Ensure we don't run this more than once
				update_option( $separate_install_option_name, TRUE );
				
				//Define our constant if an SEO plugin is used
				if( function_exists('friendly_is_an_seo_plugin_installed') )
					friendly_is_an_seo_plugin_installed();
				
				//Show the theme options
				$data['first_run_option_selected'] = "1";
				$data['show_dummy_content'] = "1";
				update_option(OPTIONS,$data);
				
			}
			
			if( $chosen_install == "minimum" )
			{
				//Define our constant if an SEO plugin is used
				if( function_exists('friendly_is_an_seo_plugin_installed') )
					friendly_is_an_seo_plugin_installed();
					
				$data['show_dummy_content'] = "1";
				$data['first_run_option_selected'] = "1";
				update_option(OPTIONS,$data);
			}
			
			if( $chosen_install == "none" )
			{
				//Define our constant if an SEO plugin is used
				if( function_exists('friendly_is_an_seo_plugin_installed') )
					friendly_is_an_seo_plugin_installed();
			
				$data['first_run_option_selected'] = "1";
				update_option(OPTIONS,$data);
			}
		
		}
	
	}
	else
	{
	
		//We're now back on the install page, first_run_option_selected doesn't exist or is blank and install_options_radio 
		//is blank too.
		$data = get_option(OPTIONS);
		if( array_key_exists('install_options_radio', $data) && $data['install_options_radio'] != "" )
		{
			$data['first_run_option_selected'] = "1";
			update_option(OPTIONS,$data);
		}
	
	
	}
	
	/* ===================================================================================== */
	
	/* ===================================================================================== */


?>