<?php

	/* ====================================================================================== */
	
	/* ====================================================================================== */
	
	/*
		Google Map With Directions
	*/
	
	if(!function_exists('friendly_map_with_directions')) :
	
		function friendly_map_with_directions($atts, $content = null)
		{
		
			extract(shortcode_atts(array(
				'destination' => '',
				'size' => ''
			), $atts));
			
			global $map_destination, $this_post_contains_map;
			$map_destination = $destination;
			$this_post_contains_map = false;
			
			if( ($destination != false) && ($size != false))
			{
			
				$this_post_contains_map = true;
			
				if($size == "small")
				{
					return '<div class="map map-small"></div>';
				}
				else
				{
					return '<div class="map map-large"></div>';
				}
			
			}
		
		}/* friendly_map_with_directions() */
	
	endif;
	
	add_shortcode('map', 'friendly_map_with_directions');
	
	/* ====================================================================================== */
	
	/* ====================================================================================== */

	/*
		Simple twitter widget with username and number of tweets
	*/
	
	if(!function_exists('friendly_twitter_status')) :
	
		function friendly_twitter_status($atts)
		{
		
			extract(shortcode_atts(array(
				'screenname' => '',
				'count' => 1
			), $atts));
		
			$transient = "$screenname"."_$count"."_twitter_status";
			$statuses =  get_transient($transient);
		
			if ($statuses == true  )
			{
				return $statuses;
			}
			elseif ($screenname != false)
			{
				
				$site = "http://twitter.com/statuses/user_timeline.json?screen_name=$screenname&count=$count";
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($ch, CURLOPT_URL, $site);
				$result = curl_exec($ch);
				$tweets = json_decode($result);
				ob_start();
				
				echo "<ul class='tweet_list'>";
				foreach ( (array) $tweets as $tweet)
				{
					
					$tweetcontent = $tweet->text;
					$tweet_time = human_time_diff($tweet->created_at,current_time('timestamp'));
					echo "<li class='tweet'>";
						echo "<p class='tweet_content'>";
							echo $tweetcontent;
						echo "</p>";
						echo "<p class='tweet_date'>";
							echo friendly_twitter_time($tweet->created_at);
						echo "</p>";
					echo "</li>";
		 
				}
				echo "</ul>";
				
				$tweet_display = ob_get_clean();
				
				//cache for 2 mins
				set_transient($transient, $tweet_display, 120);
				return $tweet_display;
				
			}
			else
			{
				return false;
			}
			
		}/* friendly_twitter_status() */
	
	endif;
	 
	add_shortcode('twitter_status', 'friendly_twitter_status');
	
	
	/*
		Helper function for the twitter time/date
	*/
	
	if(!function_exists('friendly_twitter_time')) :
	
		function friendly_twitter_time($a)
		{
			
			//get current timestampt
			$b = strtotime("now"); 
			//get timestamp when tweet created
			$c = strtotime($a);
			//get difference
			$d = $b - $c;
			
			//calculate different time values
			$minute = 60;
			$hour = $minute * 60;
			$day = $hour * 24;
			$week = $day * 7;
			
			if(is_numeric($d) && $d > 0)
			{
			
				//if less then 3 seconds
				if($d < 3) return "right now";
				//if less then minute
				if($d < $minute) return floor($d) . " seconds ago";
				//if less then 2 minutes
				if($d < $minute * 2) return "about 1 minute ago";
				//if less then hour
				if($d < $hour) return floor($d / $minute) . " minutes ago";
				//if less then 2 hours
				if($d < $hour * 2) return "about 1 hour ago";
				//if less then day
				if($d < $day) return floor($d / $hour) . " hours ago";
				//if more then day, but less then 2 days
				if($d > $day && $d < $day * 2) return "yesterday";
				//if less then year
				if($d < $day * 365) return floor($d / $day) . " days ago";
				//else return more than a year
				return "over a year ago";
			
			}
			
		}/* friendly_twitter_time() */
	
	endif;



	/* ====================================================================================== */
	
	/* ====================================================================================== */

	/*
		Columated content - Halves
	*/
	
	if(!function_exists('friendly_columns_one_half')) :
	
		function friendly_columns_one_half( $atts, $content = null )
		{
			return '<div class="one_half">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_two_third() */
	
	endif;

	add_shortcode('one_half', 'friendly_columns_one_half');
	
	
	if(!function_exists('friendly_columns_one_half_last')) :
	
		function friendly_columns_one_half_last( $atts, $content = null )
		{
			return '<div class="one_half last">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_one_half_last() */
	
	endif;

	add_shortcode('one_half_last', 'friendly_columns_one_half_last');
	
	/* ====================================================================================== */
	
	/*
		Columnated content -- One Thirds
	*/
	
	if(!function_exists('friendly_columns_one_third')) :
	
		function friendly_columns_one_third( $atts, $content = null )
		{
			return '<div class="one_third">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_one_third() */
	
	endif;

	add_shortcode('one_third', 'friendly_columns_one_third');
	
	
	if(!function_exists('friendly_columns_one_third')) :
	
		function friendly_columns_one_third_last( $atts, $content = null )
		{
			return '<div class="one_third last">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_one_third_last() */
	
	endif;

	add_shortcode('one_third_last', 'friendly_columns_one_third_last');
	
	/* ====================================================================================== */
	
	
	/*
		Columated content - Two thirds
	*/
	
	if(!function_exists('friendly_columns_two_third')) :
	
		function friendly_columns_two_third( $atts, $content = null )
		{
			return '<div class="two_third">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_two_third() */
	
	endif;

	add_shortcode('two_third', 'friendly_columns_two_third');
	
	
	if(!function_exists('friendly_columns_two_third_last')) :
	
		function friendly_columns_two_third_last( $atts, $content = null )
		{
			return '<div class="two_third last">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_two_third_last() */
	
	endif;

	add_shortcode('two_third_last', 'friendly_columns_two_third_last');
	
	/* ====================================================================================== */
	
	
	/*
		Columated content - quarters
	*/
	
	if(!function_exists('friendly_columns_one_quarter')) :
	
		function friendly_columns_one_quarter( $atts, $content = null )
		{
			return '<div class="one_quarter">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_two_third() */
	
	endif;

	add_shortcode('one_quarter', 'friendly_columns_one_quarter');
	
	
	if(!function_exists('friendly_columns_one_quarter_last')) :
	
		function friendly_columns_one_quarter_last( $atts, $content = null )
		{
			return '<div class="one_quarter last">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_one_half_last() */
	
	endif;

	add_shortcode('one_quarter_last', 'friendly_columns_one_quarter_last');
	
	/* ====================================================================================== */
	
	
	/*
		Columated content - three quarters
	*/
	
	if(!function_exists('friendly_twitter_status')) :
	
		function friendly_columns_three_quarter( $atts, $content = null )
		{
			return '<div class="three_quarter">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_three_quarter() */
		
	endif;

	add_shortcode('three_quarter', 'friendly_columns_one_quarter');
	
	
	if(!function_exists('friendly_columns_three_quarter_last')) :
	
		function friendly_columns_three_quarter_last( $atts, $content = null )
		{
			return '<div class="three_quarter last">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_three_quarter_last() */
	
	endif;

	add_shortcode('three_quarter_last', 'friendly_columns_three_quarter_last');
	
	/* ====================================================================================== */
	
	
	/*
		Columated content - fifths
	*/
	
	if(!function_exists('friendly_columns_one_fifth')) :
	
		function friendly_columns_one_fifth( $atts, $content = null )
		{
			return '<div class="one_fifth">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_one_fifth() */
	
	endif;

	add_shortcode('one_fifth', 'friendly_columns_one_fifth');
	
	
	if(!function_exists('friendly_columns_one_fifth_last')) :	
	
		function friendly_columns_one_fifth_last( $atts, $content = null )
		{
			return '<div class="one_fifth last">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_one_fifth_last() */
	
	endif;

	add_shortcode('one_fifth_last', 'friendly_columns_one_fifth_last');
	
	/* ====================================================================================== */
	
	
	/*
		Columated content - two fifths
	*/
	
	if(!function_exists('friendly_columns_two_fifth')) :
		
		function friendly_columns_two_fifth( $atts, $content = null )
		{
			return '<div class="two_fifth">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_two_fifth() */
	
	endif;

	add_shortcode('two_fifth', 'friendly_columns_two_fifth');
	
	
	if(!function_exists('friendly_columns_two_fifth_last')) :
	
		function friendly_columns_two_fifth_last( $atts, $content = null )
		{
			return '<div class="two_fifth last">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_two_fifth_last() */
	
	endif;

	add_shortcode('two_fifth_last', 'friendly_columns_two_fifth_last');
	
	/* ====================================================================================== */
	
	
	/*
		Columated content - three fifths	
	*/
	
	if(!function_exists('friendly_columns_three_fifth')) :
	
		function friendly_columns_three_fifth( $atts, $content = null )
		{
			return '<div class="three_fifth">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_three_fifth() */
	
	endif;

	add_shortcode('three_fifth', 'friendly_columns_three_fifth');
	
	
	if(!function_exists('friendly_columns_three_fifth_last')) :
	
		function friendly_columns_three_fifth_last( $atts, $content = null )
		{
			return '<div class="three_fifth last">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_three_fifth_last() */
	
	endif;

	add_shortcode('three_fifth_last', 'friendly_columns_three_fifth_last');
	
	/* ====================================================================================== */
	
	
	/*
		Columated content - four fifths
	*/
	
	if(!function_exists('friendly_columns_four_fifth')) :
	
		function friendly_columns_four_fifth( $atts, $content = null )
		{
			return '<div class="four_fifth">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_four_fifth() */
	
	endif;

	add_shortcode('four_fifth', 'friendly_columns_four_fifth');
	
	
	if(!function_exists('friendly_columns_four_fifth_last')) :
	
		function friendly_columns_four_fifth_last( $atts, $content = null )
		{
			return '<div class="four_fifth last">' . do_shortcode($content) . '</div>';
		}/* friendly_columns_four_fifth_last() */
	
	endif;

	add_shortcode('four_fifth_last', 'friendly_columns_four_fifth_last');
	
	/* ====================================================================================== */
	
	/* ====================================================================================== */
	
	
	/*
		Separators
	*/
	
	if(!function_exists('friendly_separators')) :
	
		function friendly_separators( $atts, $content = null )
		{
		
			extract(shortcode_atts(array(
				'style'	=> '1',
				'size'	=> 'full'
			), $atts));
			
			if($style == "default" && $size == "default")
			{
				$out = "<hr class='default_hr' />";
			}
			
			if($size == "full")
			{
				$dimensions = "large";
			}
			
			return $out;
		
		}/* friendly_separators() */
	
	endif;
	
	add_shortcode('separator', 'friendly_separators');
	
	/* ====================================================================================== */
	
	/* ====================================================================================== */
	
	
	/*
		Buttons
	*/
	
	if(!function_exists('friendly_buttons')) :
	
		function friendly_buttons( $atts, $content = null )
		{
			
			extract(shortcode_atts(array(
				'link'	=> '#',
				'target'	=> '',
				'variation'	=> '',
				'size'	=> '',
				'align'	=> ''
			), $atts));
			
			$style = ($variation) ? ' '.$variation. '_gradient' : '';
			$align = ($align) ? ' align'.$align : '';
			$size = ($size == 'large') ? ' large_button' : '';
			$target = ($target == 'blank') ? ' target="_blank"' : '';
			
			$out = '<a' .$target. ' class="button_link' .$style.$size.$align. '" href="' .$link. '"><span>' .do_shortcode($content). '</span></a>';
			
			return $out;
		
		}/* friendly_buttons() */
	
	endif;
		
	add_shortcode('button', 'friendly_buttons');

	/* ====================================================================================== */
	
	/* ====================================================================================== */
	
	
	/*
		Twitter Hashtag widget
	*/
	
	if(!function_exists('friendly_hashtage_tweets')) :
	
		function friendly_hashtage_tweets($atts, $content = null)
		{
			
			extract(shortcode_atts(array(
				"hashtag" => 'default_tag',
				"number" => 5
			), $atts));
			
			$api_url = 'http://search.twitter.com/search.json';
			$raw_response = wp_remote_get("$api_url?q=%23$hashtag&rpp=$number");
			
			if ( is_wp_error($raw_response) )
			{
			
				$output = "<p>Failed to update from Twitter!</p>\n";
				$output .= "<!--{$raw_response->errors['http_request_failed'][0]}-->\n";
				$output .= get_option('twitter_hash_tag_cache');
			
			}
			else
			{
			
				if ( function_exists('json_decode') )
				{
					$response = get_object_vars(json_decode($raw_response['body']));
					for ( $i=0; $i < count($response['results']); $i++ )
					{
						$response['results'][$i] = get_object_vars($response['results'][$i]);
					}
				}
				else
				{
					include(ABSPATH . WPINC . '/js/tinymce/plugins/spellchecker/classes/utils/JSON.php');
					$json = new Moxiecode_JSON();
					$response = @$json->decode($raw_response['body']);
				}
				
				$output = "<div class='twitter-hash-tag'>\n";
				
				foreach ( $response['results'] as $result )
				{
					
					$text = $result['text'];
					$user = $result['from_user'];
					$image = $result['profile_image_url'];
					$user_url = "http://twitter.com/$user";
					$source_url = "$user_url/status/{$result['id']}";
				
					$text = preg_replace('|(https?://[^\ ]+)|', '<a href="$1">$1</a>', $text);
					$text = preg_replace('|@(\w+)|', '<a href="http://twitter.com/$1">@$1</a>', $text);
					$text = preg_replace('|#(\w+)|', '<a href="http://search.twitter.com/search?q=%23$1">#$1</a>', $text);
				
					$output .= "<div>";
				
					if ( $images )
						$output .= "<a href='$user_url'><img src='$image' alt='$user' /></a>";
				
					$output .= "<a href='$user_url'>$user</a>: $text <a href='$source_url'>&raquo;</a></div>\n";
				
				}
				
				$output .= "<div class='view-all'><a href='http://search.twitter.com/search?q=%23$hashtag'>" . __('View All', 'mercury') . "</a></div>\n";
				$output .= "</div>\n";
			
			}
			
			return $output;
			
		}/* friendly_hashtage_tweets() */
	
	endif;

	add_shortcode("my_hashtag_tweets", "friendly_hashtage_tweets");

	/*
		[my_hashtag_tweets hashtag="YOUR_TAG" number="NUMBER_OF_TWEETS_TO_GET"]
	*/

	/* ====================================================================================== */
	
	/* ====================================================================================== */
	
		
	/*
		Fix the wpautop and wptexturize filter problems
	*/
	
	if(!function_exists('friendly_wpautop_wptexturize_filter')) :
	
		function friendly_wpautop_wptexturize_filter($content)
		{
	
			$new_content = '';
		
			/* Matches the contents and the open and closing tags */
			$pattern_full = '{(\[raw\].*?\[/raw\])}is';
		
			/* Matches just the contents */
			$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
		
			/* Divide content into pieces */
			$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);
		
			/* Loop over pieces */
			foreach ($pieces as $piece)
			{
				
				/* Look for presence of the shortcode */
				if (preg_match($pattern_contents, $piece, $matches))
				{
		
					/* Append to content (no formatting) */
					$new_content .= $matches[1];
					
				}
				else
				{
		
					/* Format and append to content */
					$new_content .= wptexturize(wpautop($piece));
	
				}
				
			}
		
			return $new_content;
			
		}/* friendly_wpautop_wptexturize_filter() */
	
	endif;

	remove_filter('the_content', 'wpautop');
	remove_filter('the_content', 'wptexturize');
	
	add_filter('the_content', 'friendly_wpautop_wptexturize_filter', 99);
	add_filter('widget_text', 'friendly_wpautop_wptexturize_filter', 99);
	
	/* ====================================================================================== */
	
	/* ====================================================================================== */
	
	/*
		Create a shortcode for a custom loop within the post content
	*/
	
	if(!function_exists('friendly_shortcode_custom_wp_query')) :

		function friendly_shortcode_custom_wp_query($atts, $content)
		{
			
			extract(shortcode_atts(array( // a few default values
				'posts_per_page' => '10',
				'caller_get_posts' => 1,
				'post__not_in' => get_option('sticky_posts')
			), $atts));
			
			global $post;
			
			$posts = new WP_Query($atts);
			$output = '';
			
			if ($posts->have_posts())
			{
				
				while ($posts->have_posts())
				{
			
					$posts->the_post();
			
					// these arguments will be available from inside $content
					$parameters = array(
						'PERMALINK' => get_permalink(),
						'TITLE' => get_the_title(),
						'CONTENT' => get_the_content(),
						'COMMENT_COUNT' => $post->comment_count,
						'CATEGORIES' => get_the_category_list(', ')
					);
			
					$finds = $replaces = array();
			
					foreach($parameters as $find => $replace)
					{
			
						$finds[] = '{'.$find.'}';
						$replaces[] = $replace;
			
					}
			
					$output .= str_replace($finds, $replaces, $content);
			
				}
			
			}
			else
			{
				return; // no posts found
			}
			
			wp_reset_query();
			return html_entity_decode($output);
			
		}
	
	endif;

	add_shortcode('custom_query', 'friendly_shortcode_custom_wp_query');
	
	/*
		Usage:
		
		[custom_query post_type=page posts_per_page=5]
		Listing some pages:    
		<h5>{TITLE}</h5>
		<div>{CONTENT}</div>
		<p><a href="{PERMALINK}">{COMMENT_COUNT} comments</a></p>
		[/query]
	*/
	
	/* ====================================================================================== */
	
	
	/*
		Fix the backtrack_limit bug - sometimes happens if too many shortcodes are used on one page
	*/
	
	//@ini_set('pcre.backtrack_limit', 500000);
	
	/* ====================================================================================== */
	
	
	/* ====================================================================================== */
	
	/* ====================================================================================== */
	
	
	/*
		Shortcode Editor
	*/
	
	/* Add our button to the TinyMCE Editor */
	
	if(!function_exists('friendly_themes_add_tinymce_button')) :
	
		function friendly_themes_add_tinymce_button($buttons)
		{
		    
		    array_push($buttons, "separator", "friendlythemes");
		    return $buttons;
		    
		}/* friendly_themes_add_tinymce_button() */
	
	endif;
	
	
	if(!function_exists('friendly_themes_register_shortcode_overlay')) :
	 
		function friendly_themes_register_shortcode_overlay($plugin_array)
		{
		    
		    $url = get_stylesheet_directory_uri().'/admin/js/editor_plugin.js';
		 
		    $plugin_array["friendlythemes"] = $url;
		    
		    return $plugin_array;
		    
		}/* friendly_themes_register_shortcode_overlay() */
	
	endif;
	
	add_filter('mce_external_plugins', "friendly_themes_register_shortcode_overlay");
	add_filter('mce_buttons', 'friendly_themes_add_tinymce_button', 0);
	
	/* ====================================================================================== */
	
	/* ====================================================================================== */

?>