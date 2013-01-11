<?php
	
	if(!defined('THEMENAME'))
	{
		$themedata = get_theme_data(STYLESHEETPATH . '/style.css');
		define('THEMENAME', $themedata['Name']);
	}
	
	add_theme_support( 'automatic-feed-links' );
	
	/*
		Built-in breadcrumbs - means the end user doesn't need to intall a breadcrumb plugin. However,
		there's a theme option for them to remove these if they want (so they can use 3rd party)
	*/
	
	if(!function_exists('friendly_breadcrumbs')) :
	
		function friendly_breadcrumbs($message_pre=false)
		{
			
			/* ================================================================================ */
		
			$delimiter = '&rarr;';											// What to use between the breadcrumbs
			$home = 'Home'; 												// text for the 'Home' link
			$before = '<span class="current">'; 							// tag before the current crumb
			$after = '</span>'; 											// tag after the current crumb
			$before_all = '<span class="pre_breadcrumb">You Are Here: </span>';	// Message before any b/c
			
			/* ================================================================================ */
		
			if ( !is_home() && !is_front_page() || is_paged() )
			{
		
				echo '<div id="breadcrumbs">';
				if($message_pre)
					echo $before_all;
				global $post;
				$home_link = home_url();
				echo '<a href="' . $home_link . '">' . $home . '</a> ' . $delimiter . ' ';
		
				if ( is_category() )
				{
		
					global $wp_query;
					$cat_obj = $wp_query->get_queried_object();
					$this_cat = $cat_obj->term_id;
					$this_cat = get_category($this_cat);
					$parent_cat = get_category($this_cat->parent);
		
					if ($this_cat->parent != 0) echo(get_category_parents($parent_cat, TRUE, ' ' . $delimiter . ' '));
					echo $before . 'Archive by category "' . single_cat_title('', false) . '"' . $after;
		
				}
				elseif( is_day() )
				{
		
					echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
					echo '<a href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a> ' . $delimiter . ' ';
					echo $before . get_the_time('d') . $after;
		
				}
				elseif( is_month() )
				{
		
					echo '<a href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a> ' . $delimiter . ' ';
					echo $before . get_the_time('F') . $after;
		
				}
				elseif( is_year() )
				{
	
					echo $before . get_the_time('Y') . $after;
		
				}
				elseif( is_single() && !is_attachment() )
				{
		
					if ( get_post_type() != 'post' )
					{
		
						$post_type = get_post_type_object(get_post_type());
						$slug = $post_type->rewrite;
						echo '<a href="' . $home_link . '/' . $slug['slug'] . '/">' . $post_type->labels->singular_name . '</a> ' . $delimiter . ' ';
						echo $before . get_the_title() . $after;
						
					}
					else
					{
	
						$cat = get_the_category(); $cat = $cat[0];
						echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
						echo $before . get_the_title() . $after;
		
					}
		
				}
				elseif( !is_single() && !is_page() && get_post_type() != 'post' )
				{
				
					$post_type = get_post_type_object(get_post_type());
					echo $before . $post_type->labels->singular_name . $after;
		
				}
				elseif( is_attachment() )
				{
				
					$parent = get_post($post->post_parent);
					$cat = get_the_category($parent->ID); $cat = $cat[0];
					echo get_category_parents($cat, TRUE, ' ' . $delimiter . ' ');
					echo '<a href="' . get_permalink($parent) . '">' . $parent->post_title . '</a> ' . $delimiter . ' ';
					echo $before . get_the_title() . $after;
		
				}
				elseif( is_page() && !$post->post_parent )
				{
				
					echo $before . get_the_title() . $after;
		
				}
				elseif( is_page() && $post->post_parent )
				{
				
					$parent_id  = $post->post_parent;
					$breadcrumbs = array();
		
					while ($parent_id)
					{
		
						$page = get_page($parent_id);
						$breadcrumbs[] = '<a href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
						$parent_id  = $page->post_parent;
		
					}
		
					$breadcrumbs = array_reverse($breadcrumbs);
		
					foreach ($breadcrumbs as $crumb) echo $crumb . ' ' . $delimiter . ' ';
		
					echo $before . get_the_title() . $after;
		
				}
				elseif( is_search() )
				{
		
					echo $before . 'Search results for "' . get_search_query() . '"' . $after;
		
				}
				elseif( is_tag() )
				{
				
					echo $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;
		
				}
				elseif( is_author() )
				{
				
					global $author;
					$userdata = get_userdata($author);
					echo $before . 'Articles posted by ' . $userdata->display_name . $after;
		
				}
				elseif( is_404() )
				{
					
					echo $before . 'Error 404' . $after;
				
				}
		
				if ( get_query_var('paged') )
				{
				
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) 
						echo ' (';
		
					echo __(' Page', THEMENAME) . ' ' . get_query_var('paged');
		
					if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) 
						echo ')';
		
				}
		
				echo '</div>';
		
			}
			
		}/* friendly_breadcrumbs() */
	
	endif;
	
	/* ================================================================================ */

	/*
		Baked-in pagination so our end users don't have to use plugins for this (but it will be optional, so
		if they choose to use a 3rd party plugin, they can
	*/
	
	if(!function_exists('friendly_pagination')) :

		function friendly_pagination($pages = '', $range = 2)
		{  
		     
		     $showitems = ($range * 2)+1;  
		
		     global $paged;
		     if(empty($paged)) $paged = 1;
		
		     if($pages == '')
		     {
		         global $wp_query;
		         $pages = $wp_query->max_num_pages;
		         if(!$pages)
		         {
		             $pages = 1;
		         }
		     }   
		
		     if(1 != $pages)
		     {
		         echo "<div class='pagination'>";
		         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
		         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";
		
		         for ($i=1; $i <= $pages; $i++)
		         {
		             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
		             {
		                 echo ($paged == $i)? "<span class='current'>".$i."</span>":"<a href='".get_pagenum_link($i)."' class='inactive' >".$i."</a>";
		             }
		         }
		
		         if ($paged < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a>";  
		         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
		         echo "</div>\n";
		     }
		     
		}/* friendly_pagination() */
	
	endif;
	
	/* ================================================================================ */

	/*
		Function to let us know if there's an update available or not
	*/
	
	if(!function_exists('is_a_theme_update_available')) :
	
		function is_a_theme_update_available()
		{
		
			global $xml, $theme_data,$friendly_theme_update_available;
			$xml = get_latest_theme_version(5); // This tells the function to cache the remote call for 6 hours
			$theme_data = get_theme_data(TEMPLATEPATH . '/style.css'); // Get theme data from style.css
			
			$theme_version = $theme_data['Version'];
			$theme_name = $theme_data['Name'];
			
			$checked_data = array();
			$checked_data['checked'] = array();
			$checked_data['checked'][$theme_name] = $theme_version;
			
			if(defined('LOCAL_UPDATES') && (LOCAL_UPDATES === true) )
			{
			
				$update_check = check_for_update(array_to_object($checked_data));
	
				if(!empty($update_check->response))
				{
					if( (!empty($update_check)) && (array_key_exists('package',$update_check->response[$theme_name])) )
					{
						return true;
					}
					else
					{
						return false;
					}
				}
			
			}
			else
			{
			
				if(version_compare($theme_data['Version'], $xml->latest) == -1)
				{
					return true;
				}
				else
				{
					return false;
				}
			
			}	
		
		}/* is_a_theme_update_available() */
	
	endif;
	
	
	if(!function_exists('array_to_object')) :
	
		function array_to_object($array = array())
		{
	   	 	if (empty($array) || !is_array($array))
				return false;
			
			$data = new stdClass;
	    	foreach ($array as $akey => $aval)
	            $data->{$akey} = $aval;
			return $data;
		}
	
	endif;
	

	/* ================================================================================ */
	
	/*
		Function to output the theme update markup
	*/
	
	if(!function_exists('theme_update_available_markup')) :
	
		function theme_update_available_markup()
		{
		
			$xml = get_latest_theme_version(21600); 
			$theme_data = get_theme_data(TEMPLATEPATH . '/style.css'); 
		
			if( is_a_theme_update_available() ) : ?>
		
				<div id="theme-update" class="group">
				
					<div class="section">
						
						<h3 class="heading">
							Theme Updates<small><span style='color: rgb(170,170,170); font-size: 10px;'>&nbsp;Keep track of when an update is available</span></small>
						</h3>
						<div class="option">
							<img style="float: right; margin: 0 0 20px 20px; border: 1px solid #ddd;" src="<?php echo get_template_directory_uri() . '/screenshot.png'; ?>" />
		
							<div id="instructions" style="max-width: 800px;">
		
								<p style="color: #a81e1e; font-size: 1.2em; font-weight: bold;"><?php _e("There is an update available for this theme.",THEMENAME); ?></p>
								
								<p><?php _e("<strong>Please note:</strong> make a <strong>backup</strong> of the Theme inside your WordPress installation folder <strong>/wp-content/themes/",THEMENAME); ?><?php echo strtolower($theme_data['Name']); ?>/</strong></p>
								
								<p><?php _e("Next, backup your theme options by heading to the 'Import/Export' Tab over there on the left.",THEMENAME); ?></p>
		
								<p><?php _e("To update the Theme, login to <a href='http://www.themeforest.net/'>ThemeForest</a>, head over to your <strong>downloads</strong> section and re-download the theme like you did when you bought it.",THEMENAME); ?></p>
		
								<p><?php _e("Extract the zip's contents, look for the extracted theme folder, and after you have all the new files upload them using FTP to the <strong>/wp-content/themes/",THEMENAME); ?><?php echo strtolower($theme_data['Name']); ?>/</strong> <?php _e("folder overwriting the old ones (this is why it's important to backup any changes you've made to the theme files).",THEMENAME); ?> </p>
		
								<p><?php _e("If you didn't make any changes to the theme files, you are free to overwrite them with the new ones without the risk of losing theme settings, pages, posts, etc, and backwards compatibility is guaranteed",THEMENAME); ?>.</p>
		
							</div><!-- #instructions -->
		
							<div class="clear"></div>
		
							<h3 class="heading"><?php _e("Changelog",THEMENAME); ?></h3>
		
							<?php echo $xml->changelog; ?>
						
						</div><!-- .option -->
						
					</div><!-- .section -->
				
				</div><!-- #theme-update -->
				
			<?php endif;
		
		}/* theme_update_available_markup() */
	
	endif;

	/*
		This function retrieves a remote xml file on our server to see if there's a new update 
		For performance reasons this function caches the xml content in the database
	*/

	if(!function_exists('get_latest_theme_version')) :

		function get_latest_theme_version($interval)
		{
			
			// remote xml file location
			$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
			$notifier_file_url = 'http://friendlythem.es/notifiers/'.strtolower($theme_data['Name']).'.xml';
			
			$db_cache_field = 'contempo-notifier-cache';
			$db_cache_field_last_updated = 'contempo-notifier-last-updated';
			$last = get_option( $db_cache_field_last_updated );
			$now = time();
			
			// check the cache
			if ( !$last || (( $now - $last ) > $interval) )
			{
				
				// cache doesn't exist, or is old, so refresh it
				if( function_exists('curl_init') )
				{ 
					
					// if cURL is available, use it...
					$ch = curl_init($notifier_file_url);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_HEADER, 0);
					curl_setopt($ch, CURLOPT_TIMEOUT, 10);
					$cache = curl_exec($ch);
					curl_close($ch);
					
				}
				else
				{
					$cache = file_get_contents($notifier_file_url);	// ...if not, use the common file_get_contents()
				}
				
				if ($cache)
				{			
					update_option( $db_cache_field, $cache );
					update_option( $db_cache_field_last_updated, time() );			
				}
				
				$notifier_data = get_option( $db_cache_field );		// read from the cache file
				
			}
			else
			{
				$notifier_data = get_option( $db_cache_field );		// cache file is fresh enough, so read from it
			}
			
			$xml = simplexml_load_string($notifier_data); 
			
			return $xml;
		
		}/* get_latest_theme_version() */
	
	endif;
	
	/* ================================================================================ */
	
	/*
		Add an update notifier to the new WP 3.1 Admin bar
	*/
	
	if(!function_exists('update_notifier_bar_menu')) :
	
		function update_notifier_bar_menu()
		{
		
			global $wp_admin_bar, $wpdb;
	
			if ( !is_super_admin() || !is_admin_bar_showing() )
				return;
		
			$xml = get_latest_theme_version(21600); // Cache for 6 hours
			$theme_data = get_theme_data(TEMPLATEPATH . '/style.css');
		
			if(version_compare($theme_data['Version'], $xml->latest) == -1)
			{
			
				$wp_admin_bar->add_menu( array( 'id' => 'update_notifier', 'title' => '<span>' . $theme_data['Name'] . ' <span id="ab-updates">New Updates</span></span>', 'href' => get_admin_url() . 'index.php?page=' . strtolower($theme_data['Name']) . '-updates' ) );
		
			}
	
		}/* update_notifier_bar_menu() */
	
	endif;

	add_action( 'admin_bar_menu', 'update_notifier_bar_menu', 1000 );
	
	/* ================================================================================ */

	/*
		This file is for generic functions which can be used in all themes, not specifically for one theme
	*/
	
	/* ================================================================================ */
	
	/*
		allow us to calculate the number of widgets assigned to a sidebar
	*/
	
	if(!function_exists('friendly_count_widgets_on_sidebar')) :
	
		function friendly_count_widgets_on_sidebar($sidebar_name, $just_number = false)
		{
		
			$current_sidebar_widgets = get_option('sidebars_widgets');
		
			if(is_array($current_sidebar_widgets))
			{
				if(array_key_exists($sidebar_name,$current_sidebar_widgets))
				{
					$number_of_widgets =  count($current_sidebar_widgets[$sidebar_name]);
					
					if($just_number === true)
					{
						return $number_of_widgets;
					}
					else
					{
						return $sidebar_name."_".$number_of_widgets;
					}

				}
			}
		
		}/* friendly_count_widgets_on_sidebar() */
	
	endif;
	
	
	/* ================================================================================ */
	
	
	/*
		Custom Excerpts
	*/
	
	if(!function_exists('friendly_custom_excerpts')) :
	
		function friendly_custom_excerpts( $post_id ,$length = 40, $content = false )
		{
		
			$post = get_post($post_id);
			$default_excerpt = $post->post_excerpt;
			
			if(!$default_excerpt)
			{
				//No excerpt is set
				$post_excerpt = $post->post_content;
			}
			else
			{
				//Already have an excerpt
				$post_excerpt = $post->post_excerpt;
			}
			
			$orig = $post->ID;
				
			$post_excerpt = strip_shortcodes($post_excerpt);
			$post_excerpt = str_replace(']]>', ']]&gt;', $post_excerpt);
			$post_excerpt = strip_tags($post_excerpt);
			
			
			if($length)
			{
				$excerpt_length = $length;
			}
			else
			{
				$excerpt_length = 40;
			}
			
			$words = explode(' ', $post_excerpt, $excerpt_length + 1);
			
			if(count($words) > $excerpt_length)
			{
				array_pop($words);
				$post_excerpt = implode(' ', $words);
			}
			
			$post_excerpt = '<p>' . $post_excerpt . '</p>';
			
			return $post_excerpt;
	
		
		}/* friendly_custom_excerpts */
	
	endif;
	
	/* ================================================================================ */
	
	
	/*
		Get the first image from the post
	*/
	
	if(!function_exists('friendly_get_the_image')) :
	
		function friendly_get_the_image()
		{
	    
			//First check if this post has a featured image
			global $post;
			
			if ( has_post_thumbnail() )
			{
				$attachment_id =  get_post_thumbnail_id($post->ID);
				$image_with_atts = wp_get_attachment_image_src($attachment_id);
				
				return $image_with_atts[0];
			}
			else
			{
			
				//No featured image. First check for a custom field called 'thumbnail'
				if(get_post_meta($post->ID,'thumbnail'))
				{
					
					$thumbnail_url = get_post_meta($post->ID,'thumbnail', true);
					return $thumbnail_url;
				
				}
				else
				{
				
					//No featured image and no custom field. Trawl through the content
					$post_content = get_the_content();
					$number_of_images = substr_count($post_content, '<img');
					
					$start = 0;
					$image=array();
				    for($i=1;$i<=$number_of_images;$i++)
					{
						
						$imgBeg = strpos($post_content, '<img', $start);
						$post = substr($post_content, $imgBeg);
						$imgEnd = strpos($post, '>');
						$postOutput = substr($post, 0, $imgEnd+1);
						$postOutput = preg_replace('/width="([0-9]*)" height="([0-9]*)"/', '',$postOutput);;
						$image[$i] = $postOutput;
						$start = $imgEnd+1;
						
					}
					
					if(count($image)>0)
					{
						if($image[1])
						{
							$pattern = '/src="([^"]+)/';
							$subject = $image[1];
							preg_match($pattern,$subject, $attributes);
							
							return $attributes[1];
						}
					}
					else
					{
						//No images in content, so display a default image
						//See if the user has uploaded one to theme options
						global $data;
						if($data['home_page_no_feature_default_image'] && ($data['home_page_no_feature_default_image'] != "") )
						{
							return $data['home_page_no_feature_default_image'];
						}
						else
						{
							//Absolute last resort - display a holding image
							return get_stylesheet_directory_uri()."/images/leaves.jpg";
						}
						
					}
				
				}
			
			}
	
	
		}/* friendly_get_the_image() */
	
	endif;
	
	/* ================================================================================ */
	
	
	/*
		Function to alter the url of images if we're on MultiSite
	*/
	
	if(!function_exists('friendly_change_image_url_on_multisite')) :
	
		function friendly_change_image_url_on_multisite($raw_image_url)
		{
		
			global $blog_id, $current_site;
	
			//If we're not on MultiSite, $current_site wont exist.
			if($current_site)
			{
				
				//Split the url on /files/
				$url_parts = explode('/files/', $raw_image_url);
				
				if(isset($url_parts[1]))
				{
					//Splt the first part of that url again
					$new_url = $url_parts[0] . '/wp-content/blogs.dir/' . $blog_id . '/files/' . $url_parts[1];
					return $new_url;
				}
				
			}
			else
			{
				return $raw_image_url;
			}
		
		}
	
	endif;
	
	
	/* ================================================================================ */
	
	/*
		Function to allow us to conditionally load code to pages that contain certain content
	*/
	
	if(!function_exists('friendly_load_code_conditionally')) :
	
		function friendly_load_code_conditionally($text_to_search="")
		{
	    
			global $post;
			$found = false;
			
			if ( stripos($post->post_content, $text_to_search) !== false )
				$found = true;
				
			return $found;
			
		}/* friendly_load_code_conditionally() */
	
	endif;
	
	
	/*
		function to parse content for the attributes for the sliders/accordions
	*/
	
	if(!function_exists('friendly_parse_attributes')) :
	
		function friendly_parse_attributes($post_id=NULL,$item_name)
		{
			
			$attributes = array();
			
			switch ($item_name)
			{
			
				case 'friendly-slider':
					
					if($post_id)
					{
						$subjectpre = get_post($post_id);
						$subject = $subjectpre->post_content;
					}
					else
					{
						global $post;
						$subject = $post->post_content;
					}
					$pattern = '/<div id="FriendlySlider-container" class="([^"]+)">/';
					preg_match($pattern,$subject, $attributes);
					
					//$attributes[1] now has all the classes for the friendly slider
					//Similar to: 
					/*
						friendly-slider-width-672 friendly-slider-height-360 friendly-slider-transition-fade friendly-slider-controls-false friendly-slider-autoplay-true
					*/
					
					$slider_width_pre_pre = explode("friendly-slider-width-",$attributes[1]);
					$slider_width_pre = explode(" friendly-slider-height-",$slider_width_pre_pre[1]);
					
					$slider_height_pre_pre = explode("friendly-slider-height-",$attributes[1]);
					$slider_height_pre = explode(" friendly-slider-transition-",$slider_height_pre_pre[1]);
					
					$slider_transition_pre_pre = explode("friendly-slider-transition-",$attributes[1]);
					$slider_transition_pre = explode(" friendly-slider-controls-",$slider_transition_pre_pre[1]);
					
					$slider_controls_pre_pre = explode("friendly-slider-controls-",$attributes[1]);
					$slider_controls_pre = explode(" friendly-slider-autoplay-",$slider_controls_pre_pre[1]);
					
					$slider_autoplay_pre = explode("friendly-slider-autoplay-",$attributes[1]);
					
					$slider_width = $slider_width_pre[0];
					$slider_height = $slider_height_pre[0];
					$slider_transition = $slider_transition_pre[0];
					$slider_controls = $slider_controls_pre[0];
					$slider_autoplay = $slider_autoplay_pre[1];
					
					$atts_to_send = array(
						'width'=>$slider_width,
						'height'=>$slider_height,
						'transition'=>$slider_transition,
						'controls'=>$slider_controls,
						'autoplay'=>$slider_autoplay
					);
					
					return $atts_to_send;
					
				break;
				
				case 'friendly-accordion': 
				
					if($post_id)
					{
						$subjectpre = get_post($post_id);
						$subject = $subjectpre->post_content;
					}
					else
					{
						global $post;
						$subject = $post->post_content;
					}
					$pattern = '/<div class="accordion ([^"]+)"/';
					preg_match($pattern,$subject, $attributes);
					
					//$attributes[1] now has all the classes for the accordion, similar to:
					/*
						friendly_accordion width-672 height-320 autoplay-false basic ('basic' gets appended by the js)
					*/
					
					$accordion_width_pre_pre = explode("friendly_accordion width-",$attributes[1]);
					$accordion_width_pre = explode(" height-",$accordion_width_pre_pre[1]);
					
					$accordion_height_pre_pre = explode(" height-",$attributes[1]);
					$accordion_height_pre = explode(" autoplay-",$accordion_height_pre_pre[1]);
					
					$accordion_autoplay_pre_pre = explode(" autoplay-",$attributes[1]);
					$accordion_autoplay_pre = explode(" basic",$accordion_autoplay_pre_pre[1]);
					
					$accordion_width = $accordion_width_pre[0];
					$accordion_height = $accordion_height_pre[0];
					$accordion_autoplay = $accordion_autoplay_pre[0];
					
					$atts_to_send = array(
						'width' => $accordion_width,
						'height' => $accordion_height,
						'autoplay' => $accordion_autoplay
					);
					
					return $atts_to_send;
					
				break;
				
				case 'friendly-tabs-vert':
				
					if($post_id)
					{
						$subjectpre = get_post($post_id);
						$subject = $subjectpre->post_content;
					}
					else
					{
						global $post;
						$subject = $post->post_content;
					}
					$pattern = '/<div id="tabs_vertical" class="([^"]+)">/';
					preg_match($pattern,$subject, $attributes);
					
					/* friendly_themes_tabs tabs-size-300 tabs-vertical */
					$tabs_vert_height_pre_pre = explode("friendly_themes_tabs tabs-size-",$attributes[1]);
					$tabs_vert_height_pre = explode(" tabs-vertical",$tabs_vert_height_pre_pre[1]);
					$tabs_vert_height = $tabs_vert_height_pre[0];
					
					$atts_to_send = array(
						'height' => $tabs_vert_height
					);
					
					return $atts_to_send;
				
				break;
				
				case 'friendly-tabs-horiz':
				
					if($post_id)
					{
						$subjectpre = get_post($post_id);
						$subject = $subjectpre->post_content;
					}
					else
					{
						global $post;
						$subject = $post->post_content;
					}
					$pattern = '/<div id="tabs_horizontal" class="([^"]+)">/';
					preg_match($pattern,$subject, $attributes);
					
					/* friendly_themes_tabs tabs-size-620 tabs-horizontal */
					$tabs_horiz_width_pre_pre = explode("friendly_themes_tabs tabs-size-",$attributes[1]);
					$tabs_horiz_width_pre = explode(" tabs-horizontal",$tabs_horiz_width_pre_pre[1]);
					$tabs_horiz_width = $tabs_horiz_width_pre[0];
					
					$atts_to_send = array(
						'width' => $tabs_horiz_width
					);
					
					return $atts_to_send;
				
				break;
				
			}
		
		}
	
	endif;
	
	
	/* ================================================================================ */
	
	
	/*
		function to check for and load code and global variables, used on most templates
	*/
	
	if(!function_exists('friendly_check_and_load_scripts_and_set_global_vars')) :
	
		function friendly_check_and_load_scripts_and_set_global_vars()
		{
		
			global $this_post_contains_friendly_slider, $this_post_contains_friendly_accordion, $this_post_contains_map, $this_post_contains_tabs_vert, $this_post_contains_tabs_horiz;
			$this_post_contains_friendly_slider = 		friendly_load_code_conditionally("FriendlySlider-container");
			$this_post_contains_friendly_accordion = 	friendly_load_code_conditionally("friendly_accordion");
			$this_post_contains_map = 					friendly_load_code_conditionally("[map ");
			$this_post_contains_tabs_vert = 			friendly_load_code_conditionally("tabs_vertical");
			$this_post_contains_tabs_horiz = 			friendly_load_code_conditionally("tabs_horizontal");
		
		}/* friendly_check_and_load_scripts_and_set_global_vars() */
	
	endif;
	
	
	/* ================================================================================ */
	
	
	/*
		function to get a page ID from its slug
	*/
	
	if(!function_exists('friendly_get_id_from_slug')) :
	
		function friendly_get_id_from_slug($slug, $post_type)
		{
	    
	    	if($post_type == "page")
	    	{
	
	    		$page = get_page_by_path($slug);
		    
			    if($page)
			    {
			        return $page->ID;
			    }
			    else
			    {
			        return null;
			    }
			    
	    	}
	    	else
	    	{
	    	
	    		$args = array(
					'name' => $slug,
					'post_type' => $post_type,
					'post_status' => 'publish',
					'showposts' => 1,
					'caller_get_posts'=> 1
				);
				
				$post_data = get_posts($args);
				
				if($post_data)
				{
					return $post_data[0]->ID;	
				}
				else
				{
					return null;
				}
	    	
	    	}
		    
		}/* friendly_get_id_from_slug() */
	
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
					echo '<a href="'.$next_permalink.'" title="View previous portfolio item">&larr; Previous</a>';
				echo '</div>';
				
			}
			
			if($prev_id)
			{
				//There is a 'previous' item, so get it's permalink
				$previous_permalink = get_permalink($prev_id);
				
				echo '<div class="next_link">';
					echo '<a href="'.$previous_permalink.'" title="View next portfolio item">Next &rarr;</a>';
				echo '</div>';
			}
	
		}/* friendly_next_prev_portfolio_items() */
	
	endif;
	
	/* ================================================================================ */

	/*
		Function to globalise the things we need globalising at the top of each temp. page :)
	*/
	
	if(!function_exists('friendly_globalise_options')) :
	
		function friendly_globalise_options()
		{
		
			global $data, $post, $style_dir;
			$style_dir = get_stylesheet_directory_uri(); //Cache the stylesheet_directory call
			
			if(array_key_exists('use_friendly_breadcrumbs',$data))
				$use_friendly_breadcrumbs = $data['use_friendly_breadcrumbs'];
			
			//Get the sidebar choice
			if(!empty($post))
				$sidebar_choice = ( get_post_meta($post->ID,"sidebar_name",true) ) ? get_post_meta($post->ID,"sidebar_name",true) : false;
		
		}/* friendly_globalise_options() */
	
	endif;
	
	
	/* ================================================================================ */
	
	
	/*
		Function for the meta info in the head
	*/
	
	if(!function_exists('friendly_header_meta_info_for_seo')) :
	
		function friendly_header_meta_info_for_seo()
		{
			
			if(defined('FRIENDLY_THEMES_SITE_USES_AN_SEO_PLUGIN'))
			{
				
				if(FRIENDLY_THEMES_SITE_USES_AN_SEO_PLUGIN == "NO")
				{
					global $data;
				?>
				
	<?php if(is_front_page() && $data['home_page_title'] != "") : ?>
		<title><?php echo $data['home_page_title']; ?></title>
	<?php else : ?>
		<title><?php bloginfo('name'); ?> | <?php wp_title(''); ?></title>
	<?php endif; ?>
	
	<?php if(is_front_page() && $data['home_page_description_metatag'] != "") : ?>
		<meta name="Description" content="<?php echo $data['home_page_description_metatag']; ?>"> 
	<?php else : ?>
		<meta name="Description" content="<?php bloginfo('description'); ?>"> 
	<?php endif; ?>
				
				<?php
				
				}
				else
				{
				
				?>
				
		<title><?php wp_title(''); ?></title>
		<meta name="Description" content=""> 
				
				<?php
				
				}
				
			}
			else
			{
			
				global $data;
				?>
				
	<?php if(is_front_page() && array_key_exists('home_page_title',$data) && $data['home_page_title'] != "") : ?>
		<title><?php echo $data['home_page_title']; ?></title>
	<?php else : ?>
		<title><?php bloginfo('name'); ?> | <?php wp_title(''); ?></title>
	<?php endif; ?>
	
	<?php if(is_front_page() && array_key_exists('home_page_description_metatag',$data) && $data['home_page_description_metatag'] != "") : ?>
		<meta name="Description" content="<?php echo $data['home_page_description_metatag']; ?>"> 
	<?php else : ?>
		<meta name="Description" content="<?php bloginfo('description'); ?>"> 
	<?php endif; ?>
				
				<?php
			
			}
		
		}/* friendly_header_meta_info_for_seo() */
	
	endif;
	
	
	/* ================================================================================ */
	
	/*
		Function to output touch/fav icons
	*/
	
	if(!function_exists('friendly_touch_and_fav_icons')) :
	
		function friendly_touch_and_fav_icons()
		{
		
			global $data, $style_dir;
	
			if(array_key_exists('idevice_icon',$data))
			{
				
				if($data['idevice_icon'] != "")
				{
				?>
	<link rel="apple-touch-icon" href="<?php echo get_stylesheet_directory_uri() ; ?>/inc/thumb.php?src=<?php echo friendly_change_image_url_on_multisite($data['idevice_icon']); ?>&h=129&w=129&zc=1" />
				<?php
				}
				else
				{
					?>
	<link rel="apple-touch-icon" href="<?php echo $style_dir; ?>/images/apple-touch-icon.png" />
					<?php
				}
			
	?>
	
	<?php
			}
	
	
			if(array_key_exists('custom_favicon',$data))
			{
			
				if($data['custom_favicon'] != "")
				{
				?>
		<link rel="shortcut icon" href="<?php echo get_stylesheet_directory_uri() ; ?>/inc/thumb.php?src=<?php echo friendly_change_image_url_on_multisite($data['custom_favicon']); ?>&h=16&w=16&zc=1" />
				<?php
				}
				else
				{
				?>
		<link rel="shortcut icon" href="<?php echo $style_dir; ?>/images/favicon.png" type="image/png" /> 
				<?php
				}
	
			}
		
		}/* friendly_touch_and_fav_icons() */
	
	endif;
	
	
	/* ================================================================================ */
	
	/*
		Function to add a span around ampersands on post/page save
	*/
	
	if(!function_exists('friendly_make_fancy_ampersands')) :
	
		function friendly_make_fancy_ampersands($content)
		{
		
			//$content = preg_replace("@(?![^<]+>)&amp;@", "<span class=\"amp\">&amp;</span>", "$content");
	  		$content = preg_replace("@(?![^<]+>)&#038;@", "<span class=\"amp\">&#038;</span>", "$content");
	  		$content = str_replace(" &amp; ","&nbsp;<span class='amp'>&amp;&nbsp;</span>","$content");
		
			return $content;
		
		}/* friendly_make_fancy_ampersands() */
	
	endif;
	
	add_filter( 'content_save_pre', 'friendly_make_fancy_ampersands' );
	
	/* ================================================================================ */
	
	/*
		Function which checks if option is part of the array and is set to the value passed.
		This function does a check that the array_key [option_name] (1st arg) is part of the $data array and then checks 
		that the value of it is the same as the option_value (2nd arg), if both are true, returns true, else returns false. If the
		3rd argument is set to true, then we return the value, rather than true/false
		
		USAGE:
		
		<?php  if( friendly_option( 'show_dummy_content', 1 ) ) :  ?>
	 		one
	 	<?php else : ?>
	 		nope
	 	<?php endif; ?>
	*/
	
	if(!function_exists('friendly_option')) :
	
		function friendly_option( $option_name, $option_value, $return_value = false )
		{
		
			global $data;
			
			if( array_key_exists($option_name, $data) )
			{
				
				if( $data["$option_name"] == $option_value )
				{
					
					//The option exists and is the same as the passed value
					if($return_value)
					{
						return $option_value;
					}
					else
					{
						return true;
					}
					
				}
				else
				{
				
					if($return_value)
					{
						return $data["$option_name"];
					}
					else
					{
						return false;
					}
				
				}
				
			}
			else
			{
				return false;
			}
		
		}/* friendly_option */
	
	endif;
	
	/* ===================================================================================== */
	
	/*
		Add browser info to the body classes
	*/
	
	if(!function_exists('friendly_browser_body_class')) :
	
		function friendly_browser_body_class($classes)
		{
			
			global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;
		
			if($is_lynx) $classes[] = 'lynx';
			elseif($is_gecko) $classes[] = 'gecko';
			elseif($is_opera) $classes[] = 'opera';
			elseif($is_NS4) $classes[] = 'ns4';
			elseif($is_safari) $classes[] = 'safari';
			elseif($is_chrome) $classes[] = 'chrome';
			elseif($is_IE) $classes[] = 'ie';
			else $classes[] = 'unknown';
		
			if($is_iphone) $classes[] = 'iphone';
			
			/* Add OS Detection */
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			// detecting OS
			if ( stripos($user_agent, 'windows') !== false )
			{
				$classes[] = 'win';
			}
			elseif ( stripos($user_agent, 'macintosh') !== false )
			{
				$classes[] = 'mac';
			}
			elseif ( stripos($user_agent, 'iphone') !== false )
			{
				$classes[] = 'iphone';
			}
			
			if(is_admin())
			{
				$classes = implode('',$classes);
				return $classes;
			}
			else
			{
				return $classes;
			}
	
		}/* friendly_browser_body_class() */
	
	endif;

	add_filter('body_class','friendly_browser_body_class');
	add_filter('admin_body_class', 'friendly_browser_body_class');
	
	/* ===================================================================================== */
	
	/*
		Add thumbnails to edit posts/pages screen based on user choice (show_thumbnail_posts_pages_screen)
	*/
	
	if( (array_key_exists('show_thumbnail_posts_pages_screen', $data)) && ($data['show_thumbnail_posts_pages_screen'] == "1") )
	{
	
		if ( !function_exists('friendly_add_thumbnail_edit_screens') && function_exists('add_theme_support') )
		{
	
	    	// for post and page
	    	add_theme_support('post-thumbnails', array( 'post', 'page' ) );
	    	
	    	if(!function_exists('friendly_theme_support_and_image_sizes')) :
	
		    	function friendly_add_thumbnail_column($cols)
		    	{
		
		        	$cols['thumbnail'] = __('Thumbnail', THEMENAME);
		
		        	return $cols;
		    	
		    	}/* friendly_add_thumbnail_column() */
	    	
	    	endif;
	    	
	    	
	    	if(!function_exists('friendly_add_thumbnail_edit_screens')) :
	
		    	function friendly_add_thumbnail_edit_screens($column_name, $post_id)
		    	{
		
					$width = (int) 35;
					$height = (int) 35;
					
					if ( 'thumbnail' == $column_name )
					{
					
						// thumbnail of WP 2.9
						$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
					
						// image from gallery
						$attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
					
						if ($thumbnail_id)
							$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
						elseif ($attachments)
						{
							foreach ( $attachments as $attachment_id => $attachment )
							{
								$thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
							}
						}
					
						if ( isset($thumb) && $thumb )
						{
							echo $thumb;
						}
						else
						{
							echo __('None', THEMENAME);
						}
						
					}
				
				}/* friendly_add_thumbnail_edit_screens() */
			
			endif;
	
		    // for posts
		    add_filter( 'manage_posts_columns', 'friendly_add_thumbnail_column' );
		    add_action( 'manage_posts_custom_column', 'friendly_add_thumbnail_edit_screens', 10, 2 );
		
		    // for pages
		    add_filter( 'manage_pages_columns', 'friendly_add_thumbnail_column' );
		    add_action( 'manage_pages_custom_column', 'friendly_add_thumbnail_edit_screens', 10, 2 );
		
		}
	
	}
	
	
	/* ===================================================================================== */
	
	/*
		Conditionally add CPTs to Site Search
	*/
	
	if( (array_key_exists('add_cpt_to_search_results', $data)) && ($data['add_cpt_to_search_results'] == "1") )
	{
	
		if(!function_exists('friendly_add_cpt_to_search_results')) :
	
			function friendly_add_cpt_to_search_results( $query )
			{
			
				if ( $query->is_search )
				{
					$query->set( 'post_type', array( 'site','plugin', 'theme','person' ));
				} 
	
				return $query;
	
			}/* friendly_add_cpt_to_search_results() */
		
		endif;

		add_filter( 'the_search_query', 'friendly_add_cpt_to_search_results' );
	
	}
	
	/* ===================================================================================== */
	
	
	/*
		Conditionally add CPTs to RSS Feed
	*/
	
	if( (array_key_exists('add_cpt_to_rss_feed', $data)) && ($data['add_cpt_to_rss_feed'] == "1") )
	{
	
		if(!function_exists('friendly_add_cpt_to_rss_feed')) :
	
			function friendly_add_cpt_to_rss_feed( $vars )
			{
	
				if (isset($vars['feed']) && !isset($vars['post_type']))
					$vars['post_type'] = array( 'post', 'site', 'plugin', 'theme', 'person' );
				
				return $vars;
			
			}
		
		endif;
		
		add_filter( 'request', 'friendly_add_cpt_to_rss_feed' );
	
	}
	
	/* ===================================================================================== */
	
	
	/*
		Limit post revisions, if use has set a number
	*/
	
	if( (array_key_exists('number_of_revisions_for_posts', $data)) && ($data['number_of_revisions_for_posts'] != "") )
	{
	
		$number_of_revisions = ( is_numeric($data['number_of_revisions_for_posts']) ) ? $data['number_of_revisions_for_posts'] : false;
		
		if($number_of_revisions)
		{
			if (!defined('WP_POST_REVISIONS'))
				define('WP_POST_REVISIONS', $number_of_revisions);
		}
	
	}
	
	/* ===================================================================================== */
	
	/*
		Adjust category widget output to add a span around the class
	*/
	
	if(!function_exists('friendly_add_span_count_to_widgets')) :
	
		function friendly_add_span_count_to_widgets($links)
		{
		
			$links = str_replace('</a> (', '</a> <span>', $links);
			$links = str_replace(')', '</span>', $links);
			return $links;
		
		}/* friendly_add_span_count_to_widgets() */
	
	endif;

	add_filter('wp_list_categories', 'friendly_add_span_count_to_widgets');
	
	/* ===================================================================================== */
	
	/*
		Functions to add category and month classes to body (to allow highlighting from default widgets)
	*/
	
	if(!function_exists('friendly_add_cat_classes'))
	{
	
		function friendly_add_cat_classes( $classes )
		{
		
			global $post;
			if( !empty($post) && !is_page() && !is_404() && !is_search() )
			{
				foreach((get_the_category($post->ID)) as $category)
					$classes[] = "cat-item-".$category->cat_ID;
			}
		
			return $classes;
		
		}/* friendly_add_cat_and_month_classes() */
	
	}
	
	if(!function_exists('friendly_add_month_classes'))
	{
	
		function friendly_add_month_classes( $classes )
		{
		
			global $post;
			if( !empty($post) && !is_page() && !is_404() && !is_search() )
			{
				$whole_post = get_post( $post->ID );
				$nice_date = strtolower( date( 'F-Y', strtotime( $whole_post->post_date ) ) );
			
				$classes[] = $nice_date;
			}
			return $classes;
		
		}/* friendly_add_month_classes() */	
	
	}
	
	add_filter('post_class', 'friendly_add_cat_classes');
	add_filter('body_class', 'friendly_add_cat_classes');
	
	add_filter('post_class', 'friendly_add_month_classes');
	add_filter('body_class', 'friendly_add_month_classes');
	
	/* ===================================================================================== */
	
	/*
		Allows us to remove the password link from the login page
	*/
	
	if(!class_exists('friendly_password_removal')) : 
	
		class friendly_password_removal
		{
		
			function __construct()
			{
				add_filter( 'show_password_fields', array( $this, 'disable' ) );
				add_filter( 'allow_password_reset', array( $this, 'disable' ) );
				add_filter( 'gettext',              array( $this, 'remove' ) );
			}
			
			function disable()
			{
				
				if ( is_admin() )
				{
					$userdata = wp_get_current_user();
					$user = new WP_User($userdata->ID);
			
					if ( !empty( $user->roles ) && is_array( $user->roles ) && $user->roles[0] == 'administrator' )
						return true;
				}
			
				return false;
				
			}
			
			function remove($text)
			{
				return str_replace( array('Lost your password?', 'Lost your password'), '', trim($text, '?') );
			}
		
		}/* friendly_password_removal() */
	
	endif;
	
	global $data;
	if( (array_key_exists('remove_password_reset', $data)) && ($data['remove_password_reset'] == 1))
		$pass_reset_removed = new friendly_password_removal();
	
	
	/* ===================================================================================== */
	
	/*
		Allows us to remove the comments column from admin pages
	*/
	
	if(!function_exists('friendly_remove_comments_column_from_admin_pages'))
	{
	
		function friendly_remove_comments_column_from_admin_pages( $defaults )
		{
		
			unset( $defaults['comments'] );
			return $defaults;
		
		}/* friendly_remove_comments_column_from_admin_pages() */
		
		global $data;
		if( array_key_exists('remove_comments_col_from_pages', $data) && ($data['remove_comments_col_from_pages'] != "") )
		{
			add_filter('manage_pages_columns', 'friendly_remove_comments_column_from_admin_pages');
		}
	
	}
	
	
	/* ===================================================================================== */
	
	/*
		Add body class to Visual Editor to match class used live
	*/
	
	if(!function_exists('friendly_mce_settings_adjust_body_class')) :
	
		function friendly_mce_settings_adjust_body_class( $initArray )
		{
	
			$initArray['body_class'] = 'post_content';
			return $initArray;
	
		}/* friendly_mce_settings_adjust_body_class() */
	
	endif;

	add_filter( 'tiny_mce_before_init', 'friendly_mce_settings_adjust_body_class' );
	
	/* ===================================================================================== */
	
	/*
		Allow shortcodes in widgets
	*/
	
	if ( !is_admin() )
	{
    	add_filter('widget_text', 'do_shortcode', 11);
	}
	
	/* ===================================================================================== */
	
	/*
		Stop WordPress putting unnecessary <br> tags (not even <br />!) into the HTML editor. (Helps make our slide
		work properly)
	*/
	
	if( !function_exists('friendly_better_wpautop') ) :
	
		function friendly_better_wpautop($pee)
		{
			
			return wpautop($pee,$br=0);
			
		}/* friendly_better_wpautop() */
	
	endif;

	remove_filter('the_content','wpautop');
	add_filter('the_content','friendly_better_wpautop');
	
	/* ===================================================================================== */
	
	/*
		Function to output the necessary javascript for google analytics in the footer
	*/
	
	if( !function_exists('friendly_google_analytics_in_footer') ) :
	
		function friendly_google_analytics_in_footer()
		{
		
			//Check if the google_analytics option is blank (and return the value to the variable)
			$analytics_code = friendly_option( 'google_analytics', '', true );
			
			if( $analytics_code && $analytics_code != "" )
			{
			
				?>
				
				<script type="text/javascript">

					var _gaq = _gaq || [];
					_gaq.push(['_setAccount', '<?php echo $analytics_code; ?>']);
					_gaq.push(['_trackPageview']);
					
					(function() {
						var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
						ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
						var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
					})();
					
				</script>
				
				<?php
			
			}
		
		}/* friendly_google_analytics_in_footer() */
	
	endif;
	
	add_action( "wp_footer", "friendly_google_analytics_in_footer", 15 );
	
	/* ===================================================================================== */
	
	/*
		Function, used during install, to determine if the site has an active SEO plugin
	*/
	
	if( !function_exists('friendly_is_an_seo_plugin_installed') ) :
	
		function friendly_is_an_seo_plugin_installed()
		{
		
			require_once(ABSPATH.'wp-admin/includes/plugin.php');
			
			if( is_plugin_active('wordpress-seo/wp-seo.php') )
			{
				//Yoast's WordPress SEO Plugin is active
				define('FRIENDLY_THEMES_SITE_USES_AN_SEO_PLUGIN', 'WP SEO');
				return true;
			}
			elseif( is_plugin_active('seo-ultimate/seo-ultimate.php') )
			{
				//SEO Ultimate Plugin is active
				define('FRIENDLY_THEMES_SITE_USES_AN_SEO_PLUGIN', 'SEO Ultimate');
				return true;
			}
			elseif( is_plugin_active('all-in-one-seo-pack/all_in_one_seo_pack.php') )
			{
				//AIO SEO Plugin is active
				define('FRIENDLY_THEMES_SITE_USES_AN_SEO_PLUGIN', 'AIO SEO');
				return true;
			}
			else
			{
				define('FRIENDLY_THEMES_SITE_USES_AN_SEO_PLUGIN', 'NO');
				return false;
			}
		
		}/* friendly_is_an_seo_plugin_installed() */
	
	endif;
	
	/* ===================================================================================== */
	
	if( !function_exists('friendly_add_jquery') ) :
	
		function friendly_add_jquery()
		{
			do_action( 'load_jquery' );
		}
	
	endif;
	
	if( !function_exists('friendly_add_jquery_above_head') ) : 
	
		function friendly_add_jquery_above_head()
		{
			
			wp_enqueue_script( "jquery" );
			
		}
		
		add_action( 'load_jquery', 'friendly_add_jquery_above_head', 1 );
	
	endif;
	
	/* ===================================================================================== */

?>