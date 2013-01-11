<?php

/*
	Add a 'featured' column to the portfolio listings page
*/

if(!function_exists('friendly_register_featured_column_for_portfolio')) :

	function friendly_register_featured_column_for_portfolio( $columns )
	{
	
		$columns['featured'] = __( 'Featured', THEMENAME );
		$columns['type'] = __( 'Type', THEMENAME );
 
		return $columns;
	
	}/* friendly_register_featured_column_for_portfolio() */

endif;


if(!function_exists('friendly_display_if_featured_in_featured_column')) :

	function friendly_display_if_featured_in_featured_column( $column )
	{
	
		if($column == "featured")
		{
			
			global $post;
			$featured_meta = get_post_meta($post->ID,'featured_portfolio_item', true);
			
			if($featured_meta == "1")
			{
				echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&#x2714;";
			}
			
		}
		
		if($column == "type")
		{
			
			global $post;
			$types_array = wp_get_object_terms( $post->ID, 'type' );
		
			if( (is_array($types_array)) && (count($types_array) > 0) )
			{
				foreach($types_array as $type)
				{
					$type_name = $type->slug;
					echo $type_name.", ";
				}
			}
		
		}
	
	}/* friendly_display_if_featured_in_featured_column() */

endif;

add_filter( 'manage_edit-portfolio_columns', 'friendly_register_featured_column_for_portfolio' );
add_action( 'manage_posts_custom_column', 'friendly_display_if_featured_in_featured_column' );

/* ===================================================================================== */


/*
	Function for the Featured metabox in the portfolio edit screens
*/

if(!function_exists('friendly_add_featured_metabox_to_portfolio')) :

	function friendly_add_featured_metabox_to_portfolio()
	{
	
	    add_meta_box( 'friendly_portfolio_featured_item', __( 'Featured Portfolio Item', THEMENAME ), 
	                'friendly_display_portfolio_featured_metabox', 'portfolio', 'side', 'default' );
	                
	    add_meta_box( 'friendly_portfolio_client_comments', __( 'Comments &amp; Recommendations', THEMENAME ), 
	                'friendly_display_portfolio_comments_metabox', 'portfolio', 'normal', 'high' );

		add_meta_box( 'friendly_portfolio_client_logo', __( 'Client Logo', THEMENAME ), 
	                'friendly_display_portfolio_logo_metabox', 'portfolio', 'normal', 'high' );
	                
	}/* friendly_add_custom_sidebar_metabox() */

endif;


/* Prints the box content */

if(!function_exists('friendly_display_portfolio_featured_metabox')) :

	function friendly_display_portfolio_featured_metabox()
	{
		
		global $post;
		// Use nonce for verification
		wp_nonce_field( plugin_basename(__FILE__), 'friendly_portfolio_nonce' );
		
		$featured_portfolio_value = get_post_meta($post->ID, "featured_portfolio_item", true );
		
		$featured_portfolio_item_pre = friendly_check_for_featured_portfolio_items();
		$featured_portfolio_item = $featured_portfolio_item_pre[0][0];
		
		//enable the checkbox only if we're on the page where it is checked
		if($featured_portfolio_item)
		{
			$disable_cb = true;
			if($post->ID == $featured_portfolio_item)
				$disable_cb = false;
		}
		else
		{
			$disable_cb = false;
		}
		
		?>
		
		<input type="checkbox" id="featured_portfolio_item" name="featured_portfolio_item" <?php if($disable_cb) : ?>disabled="disabled"<?php endif; ?> value="1" <?php checked($featured_portfolio_value, 1); ?> /><label for="featured_portfolio_item">&nbsp;Set As Featured Portfolio Item</label>
		<?php if($disable_cb) : ?>
			<p style="margin-top: 10px; padding: 5px; background: rgb(255,255,224); border: 1px solid rgb(230,219,85);">
				Note: This checkbox is disabled as you have already selected a <a href="<?php echo site_url(); ?>/wp-admin/post.php?post=<?php echo $featured_portfolio_item; ?>&action=edit" title="">featured portfolio item</a>.
			</p>
		<?php endif; ?> 
		
		<?php
		
	
	}/* friendly_display_portfolio_featured_metabox() */

endif;


if(!function_exists('friendly_save_portfolio_featured_metabox')) :

	/* When the post is saved, saves our custom data */
	function friendly_save_portfolio_featured_metabox( $post_id )
	{
	
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		
		if ( (array_key_exists('friendly_portfolio_nonce',$_POST)) && (!wp_verify_nonce( $_POST['friendly_portfolio_nonce'], plugin_basename(__FILE__) )) )
		{
			return $post_id;
		}
		
		// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
		// to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;
		

		if ( !current_user_can( 'edit_post', $post_id ) )
		  	return $post_id;
		
		// OK, we're authenticated: we need to find and save the data
		
		if(array_key_exists('featured_portfolio_item',$_POST))
		{
			$mydata = $_POST['featured_portfolio_item'];
		
			update_post_meta($post_id,"featured_portfolio_item",$mydata);
		
			return $mydata;
		}
	
	}/* friendly_save_portfolio_featured_metabox() */

endif;

add_action('save_post', 'friendly_save_portfolio_featured_metabox');
	

/* ===================================================================================== */

if(!function_exists('friendly_display_portfolio_comments_metabox')) :

	function friendly_display_portfolio_comments_metabox()
	{
	
		global $post;
		// Use nonce for verification
		wp_nonce_field( plugin_basename(__FILE__), 'friendly_portfolio_nonce' );
		
		$comment_text = get_post_meta($post->ID, "friendly_portfolio_comment_text", true );
		$client_name = get_post_meta($post->ID, "friendly_portfolio_client_name", true );
		
		?>
		
		<p><label for="friendly_portfolio_comment_text"><?php _e( 'Comment by this client', THEMENAME ); ?></label></p>
		<p><textarea id="friendly_portfolio_comment_text" name="friendly_portfolio_comment_text" cols="5" class="widefat"><?php echo $comment_text; ?></textarea></p>
		<p>&nbsp;</p>
		
		<p><label for="friendly_portfolio_client_name"><?php _e( 'Name of client', THEMENAME ); ?></label></p>
		<p><input type="text" class="widefat" id="friendly_portfolio_client_name" name="friendly_portfolio_client_name" value="<?php echo $client_name; ?>" /></p>
		
		<?php
	
	}/* friendly_display_portfolio_comments_metabox() */

endif;

if(!function_exists('friendly_save_portfolio_comments_metabox')) :

	function friendly_save_portfolio_comments_metabox( $post_id )
	{
	
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		
		if ( (array_key_exists('friendly_portfolio_nonce',$_POST)) && (!wp_verify_nonce( $_POST['friendly_portfolio_nonce'], plugin_basename(__FILE__) )) )
		{
			return $post_id;
		}
		
		// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
		// to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;
		

		if ( !current_user_can( 'edit_post', $post_id ) )
		  	return $post_id;
		
		// OK, we're authenticated: we need to find and save the data
		
		if( (array_key_exists('friendly_portfolio_comment_text',$_POST)) || (array_key_exists('friendly_portfolio_client_name',$_POST)) )
		{
			$client_comment 	= $_POST['friendly_portfolio_comment_text'];
			$client_name			= $_POST['friendly_portfolio_client_name'];
		
			update_post_meta($post_id,"friendly_portfolio_comment_text",$client_comment);
			update_post_meta($post_id,"friendly_portfolio_client_name",$client_name);
		
			//return $mydata;
		}
	
	}/* friendly_save_portfolio_comments_metabox() */

endif;

add_action( 'save_post', 'friendly_save_portfolio_comments_metabox' );


/* ===================================================================================== */


/* For the logo, we need to add multipart to the form */

if(!function_exists('friendly_portfolio_edit_form_tag')) :

	function friendly_portfolio_edit_form_tag()
	{
	    echo ' enctype="multipart/form-data"';
	}/* friendly_portfolio_edit_form_tag() */
	
endif;

add_action('post_edit_form_tag', 'friendly_portfolio_edit_form_tag');


if(!function_exists('friendly_display_portfolio_logo_metabox')) :

	function friendly_display_portfolio_logo_metabox()
	{
	
		global $post;

	    $custom         = get_post_custom($post->ID);
	    $download_id    = get_post_meta($post->ID, 'document_file_id', true);
	
	    echo __('<p><label for="document_file">Upload Client\'s Logo as an image (ideally an 86x86 transparent .png file):</label></p>',THEMENAME);
	    echo '<p><input type="file" name="document_file" id="document_file" /></p>';
	    echo '</p>';
	
	    if(!empty($download_id) && $download_id != '0')
	    {
	        echo '<p><a href="' . wp_get_attachment_url($download_id) . '"><img src="'.wp_get_attachment_url($download_id).'" alt="" /></a></p>';
	    }
	
	}/* friendly_display_portfolio_logo_metabox() */
	
endif;


if(!function_exists('friendly_save_portfolio_logo_metabox')) :

	function friendly_save_portfolio_logo_metabox( $post_id )
	{
	
		global $post;
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		
		if ( (array_key_exists('friendly_portfolio_nonce',$_POST)) && (!wp_verify_nonce( $_POST['friendly_portfolio_nonce'], plugin_basename(__FILE__) )) )
		{
			return $post_id;
		}
		
		// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
		// to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;
		

		if ( !current_user_can( 'edit_post', $post_id ) )
		  	return $post_id;
		
		// OK, we're authenticated: we need to find and save the data
		
		if(!empty($_FILES['document_file']))
		{
        
        	$file   = $_FILES['document_file'];
        	$upload = wp_handle_upload($file, array('test_form' => false));
        
        	if(!isset($upload['error']) && isset($upload['file']))
        	{
            
            	$wp_filetype   = wp_check_filetype(basename($upload['file']), null);
            	$title      = $file['name'];
            	$ext        = strrchr($title, '.');
            	$title      = ($ext !== false) ? substr($title, 0, -strlen($ext)) : $title;
            	$attachment = array(
                	'post_mime_type'    => $wp_filetype['type'],
                	'post_title'        => addslashes($title),
                	'post_content'      => '',
                	'post_status'       => 'inherit',
                	'post_parent'       => $post->ID
            	);

            	$attach_key = 'document_file_id';
            	$attach_id  = wp_insert_attachment($attachment, $upload['file']);
            	$existing_download = (int) get_post_meta($post->ID, $attach_key, true);

            	if(is_numeric($existing_download))
            	{
                	wp_delete_attachment($existing_download);
            	}

            	update_post_meta($post->ID, $attach_key, $attach_id);
        	}
   		}
	
	}/* friendly_save_portfolio_logo_metabox() */

endif;

add_action( 'save_post', 'friendly_save_portfolio_logo_metabox' );

/* ===================================================================================== */

/*
	Function to check if the user has selected a 'featured' portfolio item (checks for a meta box being checked)
*/

if(!function_exists('friendly_check_for_featured_portfolio_items')) :

	function friendly_check_for_featured_portfolio_items()
	{
	
		global $wpdb, $post;
		$we_have_featured_portfolio_items = false;
			
		//Start with a test to see if any of the portfolio items are 'featured'
		$check_for_featured_portfolio_items_query_pre = "SELECT DISTINCT post_id FROM $wpdb->postmeta WHERE (post_id IN (SELECT ID FROM $wpdb->posts WHERE (post_type = 'portfolio' AND post_status = 'publish')) AND (meta_key = 'featured_portfolio_item' AND meta_value = 1))";
		
		$featured_posts = $wpdb->get_results($check_for_featured_portfolio_items_query_pre, ARRAY_N);
		
		if(is_array($featured_posts))
		{
			
			$number_of_featured_posts = count($featured_posts);
			
			if($number_of_featured_posts > 0)
			{
			
				//^^ just a double check to make sure we have a featured portfolio item
				$we_have_featured_portfolio_items = true;
			
			}
			
		}
		
		if($we_have_featured_portfolio_items)
		{
			
			//Return the array of IDs
			return $featured_posts;
			
		}
		else
		{
			return false;
		}
		
	
	}/* friendly_check_for_featured_portfolio_items() */

endif;


/* ===================================================================================== */

/*
	Function to disable the checkbox for the featured portfolio item if one is already selected
*/

if(!function_exists('friendly_disable_checkbox_for_featured_portfolio_item_if_one_selected_already')) :

	function friendly_disable_checkbox_for_featured_portfolio_item_if_one_selected_already()
	{
	
		$featured_portfolio_item = friendly_check_for_featured_portfolio_items();
		
		if($featured_portfolio_item)
		{
		
			//There is a portfolio item set, disable the checkbox
		
		}
	
	}/* friendly_disable_checkbox_for_featured_portfolio_item_if_one_selected_already() */

endif;

/* ================================================================================ */
	
/*
	Function for next/previous items on the portfolio page
*/

if(!function_exists('friendly_next_prev_portfolio_items')) :

	function friendly_next_prev_portfolio_items()
	{
	
		global $wpdb, $post;
						
		$next_query = "SELECT ID FROM $wpdb->posts WHERE (post_type='portfolio' AND ID < $post->ID AND post_status = 'publish' ) ORDER BY ID DESC LIMIT 1";
		
		$prev_query = "SELECT ID FROM $wpdb->posts WHERE (post_type='portfolio' AND ID > $post->ID AND post_status = 'publish' ) ORDER BY ID ASC LIMIT 1";
		
		$next_id = $wpdb->get_var($next_query);
		$prev_id = $wpdb->get_var($prev_query);
		
		$next_permalink = false;
		$previous_permalink = false;

		if($next_id)
		{
			//There is a 'next' item, so get the permalink for it
			$next_permalink = get_permalink($next_id);
			
			echo '<div class="previous_link">';
				echo '<a class="button" href="'.$next_permalink.'" title="View previous portfolio item">&larr; Previous</a>';
			echo '</div>';
			
		}
		
		if($prev_id)
		{
			//There is a 'previous' item, so get it's permalink
			$previous_permalink = get_permalink($prev_id);
			
			echo '<div class="next_link">';
				echo '<a class="button" href="'.$previous_permalink.'" title="View next portfolio item">Next &rarr;</a>';
			echo '</div>';
		}

	}/* friendly_next_prev_portfolio_items() */

endif;

/* ================================================================================ */

/*
	This theme needs additional metaboxes for the SlideJS slider - to display the buttons
*/

add_action('add_meta_boxes', 'friendly_add_slidejs_button_metaboxes_to_posts');

if(!function_exists('friendly_add_slidejs_button_metaboxes_to_posts')) :

	function friendly_add_slidejs_button_metaboxes_to_posts()
	{
	
	    add_meta_box( 'friendly_post_slidejs_metaboxes', __( 'SlideJS Button Text and Links', THEMENAME ), 'friendly_display_slide_js_button_metaboxes', 'post', 'advanced', 'default' );
	                         
	}/* friendly_add_slidejs_button_metaboxes_to_posts() */

endif;

if(!function_exists('friendly_display_slide_js_button_metaboxes')) :

	function friendly_display_slide_js_button_metaboxes()
	{
	
		global $post;
		// Use nonce for verification
		wp_nonce_field( plugin_basename(__FILE__), 'friendly_post_nonce' );
		
		//$comment_text = get_post_meta($post->ID, "friendly_portfolio_comment_text", true );
		//$client_name = get_post_meta($post->ID, "friendly_portfolio_client_name", true );
		$button_1_text = get_post_meta($post->ID, "friendly_slide_js_button_text_1", true );
		$button_1_link = get_post_meta($post->ID, "friendly_slide_js_button_link_1", true );
		$button_2_text = get_post_meta($post->ID, "friendly_slide_js_button_text_2", true );
		$button_2_link = get_post_meta($post->ID, "friendly_slide_js_button_link_2", true );
		
		?>
		
		<p><label for="friendly_slide_js_button_text_1"><?php _e( 'Button 1 Text', THEMENAME ); ?></label></p>
		<p><input type="text" class="widefat" id="friendly_slide_js_button_text_1" name="friendly_slide_js_button_text_1" value="<?php echo $button_1_text; ?>" /></p>
		<p><label for="friendly_slide_js_button_link_1"><?php _e( 'Button 1 Link', THEMENAME ); ?></label></p>
		<p><input type="text" class="widefat" id="friendly_slide_js_button_link_1" name="friendly_slide_js_button_link_1" value="<?php echo $button_1_link; ?>" /></p>
		<p>&nbsp;</p>
		
		<p><label for="friendly_slide_js_button_text_2"><?php _e( 'Button 2 Text', THEMENAME ); ?></label></p>
		<p><input type="text" class="widefat" id="friendly_slide_js_button_text_2" name="friendly_slide_js_button_text_2" value="<?php echo $button_2_text; ?>" /></p>
		<p><label for="friendly_slide_js_button_link_2"><?php _e( 'Button 2 Link', THEMENAME ); ?></label></p>
		<p><input type="text" class="widefat" id="friendly_slide_js_button_link_2" name="friendly_slide_js_button_link_2" value="<?php echo $button_2_link; ?>" /></p>
		
		<?php
	
	}

endif;

if(!function_exists('friendly_save_post_slide_js_metabox')) :

	/* When the post is saved, saves our custom data */
	function friendly_save_post_slide_js_metabox( $post_id )
	{
	
		// verify this came from the our screen and with proper authorization,
		// because save_post can be triggered at other times
		
		if ( (array_key_exists('friendly_post_nonce',$_POST)) && (!wp_verify_nonce( $_POST['friendly_post_nonce'], plugin_basename(__FILE__) )) )
		{
			return $post_id;
		}
		
		// verify if this is an auto save routine. If it is our form has not been submitted, so we dont want
		// to do anything
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) 
			return $post_id;
		

		if ( !current_user_can( 'edit_post', $post_id ) )
		  	return $post_id;
		
		// OK, we're authenticated: we need to find and save the data
		
		/*if(array_key_exists('featured_portfolio_item',$_POST))
		{
			$mydata = $_POST['featured_portfolio_item'];
		
			update_post_meta($post_id,"featured_portfolio_item",$mydata);
		
			return $mydata;
		}*/
		
		$button_1_text = (array_key_exists("friendly_slide_js_button_text_1",$_POST)) ? $_POST["friendly_slide_js_button_text_1"] : "";
		$button_1_link = (array_key_exists("friendly_slide_js_button_link_1",$_POST)) ? $_POST["friendly_slide_js_button_link_1"] : "";
		$button_2_text = (array_key_exists("friendly_slide_js_button_text_2",$_POST)) ? $_POST["friendly_slide_js_button_text_2"] : "";
		$button_2_link = (array_key_exists("friendly_slide_js_button_link_2",$_POST)) ? $_POST["friendly_slide_js_button_link_2"] : "";
		
		update_post_meta( $post_id, "friendly_slide_js_button_text_1", $button_1_text );
		update_post_meta( $post_id, "friendly_slide_js_button_link_1", $button_1_link );
		update_post_meta( $post_id, "friendly_slide_js_button_text_2", $button_2_text );
		update_post_meta( $post_id, "friendly_slide_js_button_link_2", $button_2_link );
	
	}/* friendly_save_post_slide_js_metabox() */

endif;

add_action('save_post', 'friendly_save_post_slide_js_metabox');

?>