<?php

	//There's a file, in this directory, called test_data.xml which is a WordPress import .xml file. Try and use the built-in
	//WP_Importer class to import the files.

	require_once ABSPATH . 'wp-admin/includes/import.php';
	
	if( !class_exists('WP_Import') )
		require_once('wordpress-importer.php');
	
	if( class_exists('WP_Import') )
	{
	
		$dir_name = dirname( __FILE__ );
		$file_path = $dir_name . "/test_data.xml";
		
		if( file_exists($file_path) )
		{
		
			$WP_Import = new WP_Import();
			
			if ( ! function_exists ( 'wp_insert_category' ) )
				include ( ABSPATH . 'wp-admin/includes/taxonomy.php' );
			if ( ! function_exists ( 'post_exists' ) )
				include ( ABSPATH . 'wp-admin/includes/post.php' );
			if ( ! function_exists ( 'comment_exists' ) )
				include ( ABSPATH . 'wp-admin/includes/comment.php' );
				
			ob_start();
			
				$WP_Import->fetch_attachments = true;
				$WP_Import->allow_fetch_attachments();
				
				$WP_Import->import( $file_path );
			
			ob_end_clean();
		
		}
		else
		{
			
			wp_die( __("Unable to locate test_data.xml file.", THEMENAME) );
			
		}
	
	}
	else
	{
	
		wp_die( __("Couldn't install the test demo data as we were unable to use the WP_Import class.", THEMENAME) );
	
	}
	
	

?>