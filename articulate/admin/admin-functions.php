<?php

	/* 
		These are functions specific to these options settings and this theme 
	*/
	
	/* ================================================================================ */
	
	/*
		Our sidebar manager
	*/
	
	if(!function_exists('friendly_sidebar_manager')) :
	
		function friendly_sidebar_manager()
		{
		
			$my_data = get_option(OPTIONS);
			if( !is_array($my_data) )
				$my_data = array();
			
			if(array_key_exists('theme_custom_sidebars',$my_data))
			{
				if( ($my_data['theme_custom_sidebars']) && (is_array($my_data['theme_custom_sidebars'])) )
				{
				
					foreach( $my_data['theme_custom_sidebars'] as $sidebar_num => $new_sidebar )
					{
						
						register_sidebar(
							array(
								'id' => 'custom-sidebar-'.friendly_name_to_usable_string($new_sidebar),
								'name' => __( $new_sidebar ),
								'description' => __( $new_sidebar ),
								'before_widget' => '<div id="%1$s" class="widget %2$s">',
								'after_widget' => '</div>',
								'before_title' => '<h3 class="widget-title">',
								'after_title' => '</h3>'
							)
						);
		
					}
				
				}
			}
		
		}/* friendly_sidebar_manager() */
	
	endif;

	add_action( 'widgets_init', 'friendly_sidebar_manager' );
	
	
	/* ================================================================================ */
	
	
	/*
		Add a metabox to the Post/Page/CPT screen to allow user to select which sidebar to display
	*/
	
	/* Define the custom box */

	add_action('add_meta_boxes', 'friendly_add_custom_sidebar_metabox');
	add_action('save_post', 'friendly_save_custom_sidebar_metabox');

	/* Adds a box to the main column on the Post and Page edit screens */
	
	if(!function_exists('friendly_add_custom_sidebar_metabox')) :
	
		function friendly_add_custom_sidebar_metabox()
		{
		
			add_meta_box( 'friendly_sidebar_management', __( 'Sidebar Management', THEMENAME ), 'friendly_display_custom_sidebar_metabox', 'post' );
			add_meta_box( 'friendly_sidebar_management', __( 'Sidebar Management', THEMENAME ), 'friendly_display_custom_sidebar_metabox', 'page' );
			add_meta_box( 'friendly_sidebar_management', __( 'Sidebar Management', THEMENAME ), 'friendly_display_custom_sidebar_metabox', 'portfolio' );
		                
		}/* friendly_add_custom_sidebar_metabox() */
	
	endif;


	/* Prints the box content */
	
	if(!function_exists('friendly_display_custom_sidebar_metabox')) :
	
		function friendly_display_custom_sidebar_metabox()
		{
			
			global $post, $wp_registered_sidebars;
			// Use nonce for verification
			wp_nonce_field( plugin_basename(__FILE__), 'friendly_sidebar_nonce' );
			
			$sidebar_name = get_post_meta($post->ID, "sidebar_name", true );
			
			// The actual fields for data entry
			echo __("You can replace the sidebar with ones that you create on the theme options panel. Please select which sidebar you want. If you do not select one, the default sidebar will be used instead.",THEMENAME);
			echo '<br /><br /><p><em><label for="sidebar_name">' . __("Use this sidebar: ", THEMENAME ) . '</label></em>';
			//echo '<input type="text" id= "sidebar_name" name="sidebar_name" value="'.$sidebar_name.'" size="25" />';
			echo '<select class="of-input" name="sidebar_name">';
			
			echo '<option value="Primary" ' . selected($sidebar_name, "Primary") . ' />Primary</option>';
			
			foreach ($wp_registered_sidebars as $all_sidebars)
			{			
				
				if($all_sidebars['name'] != "Primary")
				{
					echo '<option value="'.$all_sidebars['name'].'" ' . selected($sidebar_name, $all_sidebars['name']) . ' />'.$all_sidebars['name'].'</option>';
				}
					 
			}
			echo '<option value="No-Sidebar" ' . selected($sidebar_name, "No-Sidebar") . ' />No Sidebar</option>';
			echo '</select></p>';
		
		}/* friendly_display_custom_sidebar_metabox() */
	
	endif;


	/* When the post is saved, saves our custom data */
	
	if(!function_exists('friendly_save_custom_sidebar_metabox')) :
	
		function friendly_save_custom_sidebar_metabox( $post_id )
		{
		
			// verify this came from the our screen and with proper authorization,
			// because save_post can be triggered at other times
			
			if ( (array_key_exists('friendly_sidebar_nonce',$_POST)) && !wp_verify_nonce( $_POST['friendly_sidebar_nonce'], plugin_basename(__FILE__) ))
			{
				return $post_id;
			}
			
			// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
			// to do anything
			if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
				return $post_id;
			
			if(array_key_exists('post_type',$_POST))
			{
				// Check permissions
				if ( 'page' == $_POST['post_type'] )
				{
					if ( !current_user_can( 'edit_page', $post_id ) )
				  		return $post_id;
				}
				else
				{
					if ( !current_user_can( 'edit_post', $post_id ) )
				  		return $post_id;
				}
			}
			
			// OK, we're authenticated: we need to find and save the data
			
			if(array_key_exists('friendly_sidebar_nonce',$_POST))
			{
				$mydata = $_POST['sidebar_name'];
			
				update_post_meta($post_id,"sidebar_name",$mydata);
			
				return $mydata;
			}
			
		
		}/* friendly_save_custom_sidebar_metabox() */
	
	endif;
	
	/* ================================================================================ */
	
	
	/*
		Converts the name to a usable id
	*/
	
	if(!function_exists('friendly_name_to_usable_string')) :
	
		function friendly_name_to_usable_string($name)
		{
			
			$usable_string = strtolower(str_replace(array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$name));
			return $usable_string;
	
		}/* friendly_name_to_usable_string() */
	
	endif;
	
	
	/* ================================================================================ */
	
	$data = get_option(OPTIONS);
	if( !is_array($data) )
		$data = array();
	
	if(!function_exists('friendly_custom_login_logo')) :
	
		if(array_key_exists('custom_login_logo',$data) && $data['custom_login_logo'] != "")
		{
		
			function friendly_custom_login_logo()
			{
	
				$data = get_option(OPTIONS);
				$logo_url = $data['custom_login_logo'];
	
				echo '<style type="text/css">
							h1 a { background-image:url("'.$logo_url.'") !important; }
						</style>';
	
			}/* friendly_custom_login_logo() */
	
			add_action('login_head', 'friendly_custom_login_logo');
		
		}
	
	endif;
	
	
	if(!function_exists('friendly_custom_admin_logo')) :
	
		if(array_key_exists('custom_admin_logo',$data) && $data['custom_admin_logo'] != "")
		{
			
			function friendly_custom_admin_logo()
			{
	
				$data = get_option(OPTIONS);
				$admin_logo = $data['custom_admin_logo'];
				
				echo '<style type="text/css">
							#header-logo { background-image: url("'.$admin_logo.'") !important; }
						</style>';
			
			}/* friendly_custom_admin_logo() */
	
			add_action('admin_head', 'friendly_custom_admin_logo');
		
		}
	
	endif;
	
	
	if(!function_exists('friendly_custom_footer_admin')) :
	
		if(array_key_exists('custom_dashboard_footer_text',$data) && $data['custom_dashboard_footer_text'] != "")
		{
			
			function friendly_custom_footer_admin ()
			{
				
				$data = get_option(OPTIONS);
				$custom_admin_footer_text = $data['custom_dashboard_footer_text'];
				echo $custom_admin_footer_text;
	
			}/* friendly_custom_footer_admin() */
	
			add_filter('admin_footer_text', 'friendly_custom_footer_admin');
		
		}
	
	endif;
	
	/* ================================================================================ */

	/*
		Code highlighting in the theme editor
	*/
	
	if( !function_exists('friendly_add_theme_editor_highlighting') ) :

	function friendly_add_theme_editor_highlighting()
	{
	
		global $current_screen;
		
		//Load CodeMirror for Theme Editor
		if( ($current_screen) && ($current_screen->id =="theme-editor") )
		{
			wp_enqueue_script( 'jquery' );
			wp_enqueue_style( 'codemirror_css', get_template_directory_uri().'/admin/js/codemirror/lib/codemirror.css' );
			wp_enqueue_script( 'codemirror_js', get_template_directory_uri().'/admin/js/codemirror/lib/codemirror.js' );
			wp_enqueue_script( 'xml_js', get_template_directory_uri().'/admin/js/codemirror/xml/xml.js' );
			wp_enqueue_script( 'javascript_js', get_template_directory_uri().'/admin/js/codemirror/javascript/javascript.js' );
			wp_enqueue_script( 'css_js', get_template_directory_uri().'/admin/js/codemirror/css/css.js' );
			wp_enqueue_script( 'clike_js', get_template_directory_uri().'/admin/js/codemirror/clike/clike.js' );
			wp_enqueue_script( 'php_js', get_template_directory_uri().'/admin/js/codemirror/php.js' );
			wp_enqueue_script( 'codemirror_load', get_template_directory_uri().'/admin/js/codemirror/load.js','','',true );
		
		}
	
	}/* friendly_add_theme_editor_highlighting() */
	
	add_action( 'admin_enqueue_scripts', 'friendly_add_theme_editor_highlighting' );
		
endif;

?>
