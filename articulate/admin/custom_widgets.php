<?php
	
	/* =========================================================================================== */
	
	/* =========================================================================================== */
	
	
	/*
		Twitter widget
	*/
	
	class friendly_twitter_widget extends WP_Widget
	{

		function friendly_twitter_widget()
		{
									
			// Widget settings
			$widget_ops = array('classname' => 'friendly-twitter-widget', 'description' => 'Display your latest tweets.');

			// Create the widget
			$this->WP_Widget('friendly-twitter-widget', 'Friendly Twitter', $widget_ops);
			
		}/* friendly_twitter_widget */
		
		/* ========================================================================================= */
		
		
		function widget($args, $instance)
		{
			
			extract($args);
			
			global $interval;
			
			// User-selected settings
			$title = apply_filters('widget_title', $instance['title']);
			$username = $instance['username'];
			$posts = $instance['posts'];
			$interval = $instance['interval'];
			$date = $instance['date'];
			$datedisplay = $instance['datedisplay'];
			$datebreak = $instance['datebreak'];
			$clickable = $instance['clickable'];
			$hideerrors = $instance['hideerrors'];

			// Before widget (defined by themes)
			echo $before_widget;


			// Widget action happens from here
			
			// Set internal Wordpress feed cache interval, by default it's 12 hours or so
			add_filter('wp_feed_cache_transient_lifetime', array(&$this, 'set_interval'));
			include_once(ABSPATH . WPINC . '/feed.php');

			// Get current upload directory
			$upload = wp_upload_dir();
			$cachefile = $upload['basedir'] . '/_twitter_' . $username . '.txt';


			// Title of widget (before and after defined by themes)
			if (!empty($title)) echo $before_title . $title . $after_title;


			// If cachefile doesn't exist or was updated more than $interval ago, create or update it, otherwise load from file
			if (!file_exists($cachefile) || (file_exists($cachefile) && (filemtime($cachefile) + $interval) < time()))
			{

				$feed = fetch_feed('http://twitter.com/statuses/user_timeline.rss?screen_name=' . $username);
				
				// This check prevents fatal errors - which can't be turned off in PHP - when feed updates fail
				if (method_exists($feed, 'get_items'))
				{

					$tweets = $feed->get_items(0, $posts);

					$result = '
						<ul>';

					foreach	($tweets as $t)
					{
						
						$result .= '
							<li>';

						// Get message
						$text = $t->get_description();
						
						// Get date/time and convert to Unix timestamp
						$time = strtotime($t->get_date());

						// If status update is newer than 1 day, print time as "... ago" instead of date stamp
						if ((abs(time() - $time)) < 86400)
						{
							$time = human_time_diff($time) . ' ago';
						}
						else
						{
							$time = date(($date), $time);
						}

						// Make links and Twitter names clickable
						if ($clickable)
						{
							
							// Match URLs
				    		$text = preg_replace('`\b(([\w-]+://?|www[.])[^\s()<>]+(?:\([\w\d]+\)|([^[:punct:]\s]|/)))`', '<a href="$0">$0</a>', $text);

				    		// Match @name
				    		$text = preg_replace('/(@)([a-zA-Z0-9\_]+)/', '@<a href="http://twitter.com/$2">$2</a>', $text);
						}

			    		// Display date/time
						if($datedisplay)
						{
							$result .= '<span class="twitter-date"><a href="'. $t->get_permalink() .'">' . $time . '</a></span>' . ($datebreak ? '<br />' : '');
						}
							
			    		// Display message without username prefix
						$prefixlen = strlen($username . ": ");
						$result .= '
								<span class="twitter-text">' . substr($text, $prefixlen, strlen($text) - $prefixlen) . '</span>';

						$result .= '
							</li>';
					
					}
					
					$result .= '
						</ul>
						';
					
					// Save updated feed to cache file
					@file_put_contents($cachefile, $result);

					// Display everything
					echo $result;


				// If loading from Twitter fails, try loading from the file instead
				}
				else
				{
					
					if (file_exists($cachefile))
					{
						$result = @file_get_contents($cachefile);
					}

					if (!empty($result))
					{
						echo $result;
					}
					elseif (!$hideerrors)
					{
						echo '<p>Error while loading Twitter feed.</p>';
					}
					
				}


			// If cache file exists or if it was updated not long ago, load from file straight away
			}
			else
			{
				$result = @file_get_contents($cachefile);

				if (!empty($result))
				{
					echo $result;
				}
				elseif(!$hideerrors)
				{
					echo '<p>Error while loading Twitter feed.</p>';			
				}
			}



			// After widget (defined by themes)
			echo $after_widget;
		
		}/* widget() */
		
		/* ========================================================================================= */
		
		
		// Callback helper for the cache interval filter
		function set_interval()
		{
			
			global $interval;
			
			return $interval;
		
		}/* set_interval() */
		
		/* ========================================================================================= */

		
		function update($new_instance, $old_instance)
		{
			
			$instance = $old_instance;

			$instance['title'] = $new_instance['title'];
			$instance['username'] = $new_instance['username'];
			$instance['posts'] = $new_instance['posts'];
			$instance['interval'] = $new_instance['interval'];
			$instance['date'] = $new_instance['date'];
			$instance['datedisplay'] = $new_instance['datedisplay'];
			$instance['datebreak'] = $new_instance['datebreak'];
			$instance['clickable'] = $new_instance['clickable'];
			$instance['hideerrors'] = $new_instance['hideerrors'];
			
			// Delete the cache file when options were updated so the content gets refreshed on next page load
			$upload = wp_upload_dir();
			$cachefile = $upload['basedir'] . '/_twitter_' . $old_instance['username'] . '.txt';
			@unlink($cachefile);

			return $instance;

		}/* update() */
		
		/* ========================================================================================= */
		
		
		function form($instance)
		{

			// Set up some default widget settings
			$defaults = array('title' => 'Latest Tweets', 'username' => '', 'posts' => 5, 'interval' => 1800, 'date' => 'j F Y', 'datedisplay' => true, 'datebreak' => true, 'clickable' => true, 'hideerrors' => true);
			$instance = wp_parse_args((array) $instance, $defaults);
?>
				
			<p>
				<label for="<?php echo $this->get_field_id('title'); ?>">Title:</label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $instance['title']; ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('username'); ?>">Your Twitter username:</label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('username'); ?>" name="<?php echo $this->get_field_name('username'); ?>" value="<?php echo $instance['username']; ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('posts'); ?>">Display how many posts?</label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('posts'); ?>" name="<?php echo $this->get_field_name('posts'); ?>" value="<?php echo $instance['posts']; ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('interval'); ?>">Update interval (in seconds):</label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('interval'); ?>" name="<?php echo $this->get_field_name('interval'); ?>" value="<?php echo $instance['interval']; ?>" />
			</p>

			<p>
				<label for="<?php echo $this->get_field_id('date'); ?>">Date format (see PHP <a href="http://php.net/manual/en/function.date.php">date</a>):</label>
				<input class="widefat" type="text" id="<?php echo $this->get_field_id('date'); ?>" name="<?php echo $this->get_field_name('date'); ?>" value="<?php echo $instance['date']; ?>" />
			</p>
								
			<p>
				<input class="checkbox" type="checkbox" <?php if ($instance['datedisplay']) echo 'checked="checked" '; ?>id="<?php echo $this->get_field_id('datedisplay'); ?>" name="<?php echo $this->get_field_name('datedisplay'); ?>" />
				<label for="<?php echo $this->get_field_id('datedisplay'); ?>">Display date?</label>
				
				<br />
				
				<input class="checkbox" type="checkbox" <?php if ($instance['datebreak']) echo 'checked="checked" '; ?>id="<?php echo $this->get_field_id('datebreak'); ?>" name="<?php echo $this->get_field_name('datebreak'); ?>" />
				<label for="<?php echo $this->get_field_id('datebreak'); ?>">Add linebreak after date?</label>
				
				<br />

				<input class="checkbox" type="checkbox" <?php if ($instance['clickable']) echo 'checked="checked" '; ?>id="<?php echo $this->get_field_id('clickable'); ?>" name="<?php echo $this->get_field_name('clickable'); ?>" />
				<label for="<?php echo $this->get_field_id('clickable'); ?>">Make URLs &amp; usernames clickable?</label>
				
				<br />

				<input class="checkbox" type="checkbox" <?php if ($instance['hideerrors']) echo 'checked="checked" '; ?>id="<?php echo $this->get_field_id('hideerrors'); ?>" name="<?php echo $this->get_field_name('hideerrors'); ?>" />
				<label for="<?php echo $this->get_field_id('hideerrors'); ?>">Hide error message if update fails?</label>
			</p>
			
<?php

		}/* form() */
		
	}/* class friendly_twitter_widget() */	

	/* =========================================================================================== */
	
	
	/*
		Register the widget
	*/
	if (class_exists('friendly_twitter_widget'))
	{
	
		function register_friendly_twitter_widget()
		{
			register_widget('friendly_twitter_widget');
		}
	
		add_action('widgets_init', 'register_friendly_twitter_widget');
	
	}
	
	/* =========================================================================================== */
	
	/* =========================================================================================== */
	
	
	/*
		Random Post Widget
	*/
	
	class friendly_random_posts extends WP_Widget
	{

		function friendly_random_posts()
		{
			
			$widget_ops = array('classname' => 'friendly_random_posts', 'description' => __( 'Friendly Random Posts', 'mercury') );
			$this->WP_Widget('friendly_random_posts', __('Friendly Random Posts', 'mercury'), $widget_ops);
			
		}/* friendly_random_posts() */
		
		/* ========================================================================================= */
	
	
		function widget( $args, $instance )
		{
			
			extract( $args );
			
			$title = apply_filters('widget_title', empty( $instance['title'] ) ? __( 'Random Posts' , 'mercury') : $instance['title']);
			
			echo $before_widget;
			if ( $title )
			{

				$before_title .= '';
				$after_title = ''.$after_title;
				
				echo $before_title.$title.$after_title;
				
			}
			?>
				
			<ul>
				<?php 
				$random = new WP_Query("cat=".$instance['cat']."&showposts=".$instance['showposts']."&orderby=rand"); 
				// the Loop
				if ($random->have_posts()) : 
				while ($random->have_posts()) : $random->the_post(); ?>
	                <li>
					<?php
						if ($instance['content'] != 'excerpt-notitle' && $instance['content'] != 'content-notitle') { ?>
						<h5><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
					<?php
					} 
					if ($instance['content'] == 'excerpt' || $instance['content'] == 'excerpt-notitle')
					{
						the_excerpt();  // this covers Advanced Excerpt as well as the built-in one
					}
					if ($instance['content'] == 'content' || $instance['content'] == 'content-notitle') the_content();
				endwhile; endif;
				?>
			</ul>
				
			<?php
			echo $after_widget;
			
		}/* widget() */
		
		/* ========================================================================================= */
	
	
		function update( $new_instance, $old_instance )
		{
			
			$instance = $old_instance;
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['cat'] = $new_instance['cat'];
			$instance['showposts'] = $new_instance['showposts'];
			$instance['content'] = $new_instance['content'];
			return $instance;
			
		}/* update() */
		
		/* ========================================================================================= */

		function form( $instance )
		{
			
			//Defaults
			$instance = wp_parse_args( (array) $instance, array( 
				'title' => __('Random Posts', 'mercury'),
				'cat' => 1,
				'showposts' => 1,
				'content' => 'title'
			));	
	
		?>  
       
			<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:', 'mercury'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
				name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $instance['title']; ?>" />
			</p>
			
			<p><label for="<?php echo $this->get_field_id('cat'); ?>"><?php _e('Show posts from category:', 'mercury'); ?></label> 
			<?php wp_dropdown_categories(array('name' => $this->get_field_name('cat'), 'hide_empty'=>0, 'hierarchical'=>1, 'selected'=>$instance['cat'])); ?></label>
			</p>
			
			<p><label for="<?php echo $this->get_field_id('showposts'); ?>"><?php _e('Number of posts to show:', 'mercury'); ?></label> 
			<input class="widefat" id="<?php echo $this->get_field_id('showposts'); ?>" name="<?php echo $this->get_field_name('showposts'); ?>" 
				type="text" value="<?php echo $instance['showposts']; ?>" />
			</p>
			
			<p>
			<label for="<?php echo $this->get_field_id('content'); ?>"><?php _e('Display:', 'mercury'); ?></label> 
			<select id="<?php echo $this->get_field_id('content'); ?>" name="<?php echo $this->get_field_name('content'); ?>" class="postform">
				<option value="title"<?php selected( $instance['content'], 'title' ); ?>><?php _e('Title Only', 'mercury'); ?></option>
				<option value="excerpt"<?php selected( $instance['content'], 'excerpt' ); ?>><?php _e('Title and Excerpt', 'mercury'); ?></option>
				<option value="excerpt-notitle"<?php selected( $instance['content'], 'excerpt-notitle' ); ?>><?php _e('Excerpt without Title', 'mercury'); ?></option>
				<option value="content"<?php selected( $instance['content'], 'content' ); ?>><?php _e('Title and Content', 'mercury'); ?></option>
				<option value="content-notitle"<?php selected( $instance['content'], 'content-notitle' ); ?>><?php _e('Content without Title', 'mercury'); ?></option>
			</select>
			</p>


		<?php


		}/* form() */

	}/* class friendly_random_posts() */
	
	/* =========================================================================================== */
	

	if(class_exists('friendly_random_posts'))
	{
		
		function register_friendly_random_posts_widget()
		{
			register_widget('friendly_random_posts');
		}/* register_friendly_random_posts_widget() */
		
		add_action('widgets_init', 'register_friendly_random_posts_widget');
			
	}

	
	/* =========================================================================================== */
	
	/* =========================================================================================== */
	
	
	/*
		Most Popular Posts Widget
	*/
	
	
	global $defaults;

	$defaults = array(
		'title' => 'Most Popular Posts',
		'number' => 5,
		'comment' => ' checked',
		'zero' => ' checked',
		'onlycheck' => ' checked',
		'only' => 1,
		'exclude' => 1,
		'excludecheck' => ' checked',
		'time' => '',
		'duration' => '',
		'parentclass' => '',
		'listclass' => ''
	);

	/* ========================================================================================= */

	class friendly_most_popular_posts extends WP_Widget
	{
	
		function friendly_most_popular_posts()
		{
			
			$widget_ops = array('description' => __( "Displays links to the posts with the most comments.", 'mercury' ) );
			$this->WP_Widget('friendly_most_popular_posts', __('Friendly Popular Posts', 'mercury'), $widget_ops);
		
		}/* friendly_most_popular_posts() */
		
		/* ========================================================================================= */

		function form($instance)
		{
		
			global $defaults;

			// check if options are saved, otherwise use defaults
			if (friendly_mpp_empty_check($instance))
				$instance = $defaults;
			
			$title = esc_attr($instance['title']);
			$number = esc_attr($instance['number']);
			$comment = esc_attr($instance['comment']);
			$zero = esc_attr($instance['zero']);
			$onlycheck = esc_attr($instance['onlycheck']);
			$only = esc_attr($instance['only']);
			$excludecheck = esc_attr($instance['excludecheck']);
			$exclude = esc_attr($instance['exclude']);
			$time = esc_attr($instance['time']);
			$timeunit = esc_attr($instance['duration']);
	
			//create widget configuration panel
		?>
		
			<p>
				<label for="<?php echo $this->get_field_name('title'); ?>"><?php _e('Title: ', 'mercury'); ?> </label>
    			<input type="text" size="30" name="<?php echo $this->get_field_name('title'); ?>" value="<?php echo $title;?>" id="widget-friendly_most_popular_posts" />
  			</p>

			<p>
    			<label for="<?php echo $this->get_field_name('number'); ?>"><?php _e('Number of posts to display: ', 'mercury'); ?></label>
    			<input type="text" name="<?php echo $this->get_field_name('number'); ?>" value="<?php echo $number;?>" size="5" />
  			</p>

			<p>
	 			<input type="checkbox" name="<?php echo $this->get_field_name('comment'); ?>" value="checked" <?php echo $comment;?> />
    			<label for="<?php echo $this->get_field_name('comment'); ?>"><?php _e('Show comment count ', 'mercury'); ?></label>
			</p>

			<p>
				 <input type="checkbox" name="<?php echo $this->get_field_name('zero'); ?>" value="checked" <?php echo $zero;?> />
			    <label for="<?php echo $this->get_field_name('zero'); ?>"><?php _e('Include zero comment posts ', 'mercury'); ?></label>
			</p>

			<p>
				<?php _e('If both of the following options are enabled, the <em>only category</em> option is respected.', 'mercury'); ?>
			</p>

			<p>
				<input type="checkbox" name="<?php echo $this->get_field_name('onlycheck'); ?>" value="checked" <?php echo $onlycheck;?> />
    			<label for="<?php echo $this->get_field_name('onlycheck'); ?>"><?php _e('Show comments from all categories ', 'mercury'); ?></label>
    		</p>

			<p>
				<?php wp_dropdown_categories('hierarchical=1&selected=' . $only . '&orderby=name&show_count=1&name=' . $this->get_field_name('only') . '&hide_empty=0'); ?><br />
				<label for="<?php echo $this->get_field_name('only'); ?>"><?php _e('Only show posts in this category.', 'mercury'); ?></label>
			</p>

			<p>
				<input type="checkbox" name="<?php echo $this->get_field_name('excludecheck'); ?>" value="checked" <?php echo $excludecheck;?> />
			    <label for="<?php echo $this->get_field_name('excludecheck'); ?>"><?php _e('Exclude posts from no categories ', 'mercury'); ?></label>
			</p>
			
			<p>
				<?php wp_dropdown_categories('hierarchical=1&selected=' . $exclude . '&orderby=name&show_count=1&name=' . $this->get_field_name('exclude') . '&hide_empty=0'); ?><br />
				<label for="<?php echo $this->get_field_name('exclude')?>"><?php _e('Exclude posts in this category.', 'mercury'); ?></label>
			</p>

			<p>
				<label for="<?php echo $this->get_field_name('time')?>"><?php _e('Only show posts in the last ', 'mercury'); ?></label>
				<br />
				<select name="<?php echo $this->get_field_name('time')?>">
					<option value="all"><?php _e('All', 'mercury'); ?></option>
					<?php 
					for ($i = 1; $i <= 12; $i++)
					{
						if ($time == $i)
							$selected = ' selected';
						else
							$selected = '';
						echo "<option value=" . $i . $selected . ">" . $i . "</option>\n";
					} ?>
				</select>
				<select name="<?php echo $this->get_field_name('duration')?>">
					<?php 
					$duration = array('all', 'day', 'week', 'month');
					foreach ($duration as $select)
					{
						if ($timeunit == $select)
							$selected = ' selected';
						else
							$selected = '';
						echo "<option value=" . $select . $selected . ">" . $select . "</option>\n";
					}
					?>
				</select>
			</p>

		<?php
	
		}/* form() */
	
		/* ========================================================================================= */


		function update($new_instance, $old_instance)
		{
			
			$instance = $old_instance;
	
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number'] = strip_tags($new_instance['number']);
			$instance['comment'] = strip_tags($new_instance['comment']);
			$instance['zero'] = strip_tags($new_instance['zero']);
			$instance['onlycheck'] = strip_tags($new_instance['onlycheck']);
			$instance['only'] = strip_tags($new_instance['only']);
			$instance['excludecheck'] = strip_tags($new_instance['excludecheck']);
			$instance['exclude'] = strip_tags($new_instance['exclude']);
			$instance['time'] = strip_tags($new_instance['time']);
			$instance['duration'] = strip_tags($new_instance['duration']);
			$instance['nestedlist'] = strip_tags($new_instance['nestedlist']);
	
	        return $instance;
	        
		}/* update() */
		
		/* ========================================================================================= */
	

		function widget($args, $instance)
		{
			
			global $wpdb;
			global $defaults;
			
			extract($args);
			
			if (friendly_mpp_empty_check($instance))
				$instance = $defaults;
	
			//check if zero comments are needed
			if ($instance['zero'] != 'checked')
				$zero = '&& comment_count > 0 ';
	
			//sort out the duration system
			if (($instance['duration'] != 'all') && ($instance['time'] != 'all'))
			{
				//get current time of Wordpress
				$time = current_time('mysql', 1);
				$period = $instance['duration'];
				//new date to compare
				$new_date = date('Y-m-d H:i:s', strtotime($time . "-" . $instance['time'] . " " . $instance['duration']));
				$compare = " AND (post_date_gmt >= '" . $new_date . "')";
			}
	
			$reverse = 'DESC';
	
			//get the post data from the database
			if (($instance['excludecheck'] == 'checked') && ($instance['onlycheck'] == 'checked'))
			{
			
				$query = "SELECT ID, post_title, comment_count, post_date FROM " . $wpdb->posts . " WHERE post_type = 'post' && post_status = 'publish' " . $zero . $compare . " ORDER BY comment_count " . $reverse . " LIMIT " . $instance['number'];
				$posts = $wpdb->get_results($query);
				
			}
			else if(($instance['excludecheck'] != 'checked') && ($instance['onlycheck'] == 'checked'))
			{
				
				$query = "select ID, post_title, comment_count, post_date from " . $wpdb->posts . " where ID in (select object_ID from " . $wpdb->term_relationships . " where " . $wpdb->term_relationships . ".term_taxonomy_id in (select term_taxonomy_id from " . $wpdb->term_taxonomy . " where term_id != " . $instance['exclude'] . " AND taxonomy = 'category')) AND post_type = 'post'" . $compare . " order by comment_count " . $reverse . " limit " . $instance['number'];
				$posts = $wpdb->get_results($query);
				
			}
			else
			{
			
				$query = "select ID, post_title, comment_count, post_date from " . $wpdb->posts . " where ID in (select object_ID from " . $wpdb->term_relationships . " where " . $wpdb->term_relationships . ".term_taxonomy_id = (select term_taxonomy_id from " . $wpdb->term_taxonomy . " where term_id = " . $instance['only'] . " AND taxonomy = 'category')) AND post_type = 'post'" . $compare . " order by comment_count " . $reverse . " limit " . $instance['number'];
				$posts = $wpdb->get_results($query);
			
			}
	
			// start widget output
			echo $before_widget . "\n";
	
			echo $before_title . $instance['title'] . $after_title . "\n";
	
			if ($instance['nestedlist'] == 'checked')
			{
			
				if ($instance['parentclass'] == '')
					echo '<li>';
				else
					echo '<li class="' . $instance['parentclass'] . '">';
	
			}
		

			echo '<ul>';
	
			//display each page as a link
			if (!empty($posts))
			{
			
				foreach ($posts as $links)
				{
				
					if ($instance['comment'] == 'checked')
						$comments = '' . $links->comment_count;
		
					if ($instance['listclass'] != '')
						$li_class = ' class="' . $instance['listclass'] . '"';
	
					echo "\t" . '<li' . $li_class . '><a href="' . get_permalink($links->ID) . '">' . $links->post_title . '</a><span>' . $comments . '</span></li>' . "\n";
		
				}
	
			}
			else 
			{
	
				echo "\n\t" . '<li>';
				_e('No posts to display', 'mercury');
				echo '</li>' . "\n";
				
			}
	
			echo "</ul>";
	
			echo $after_widget . "\n";
			
		}/* widget() */
		
		/* ========================================================================================= */
		
	}/* class friendly_most_popular_posts() */
	
	/* =========================================================================================== */

	function friendly_mpp_empty_check($array)
	{
	
		$i = 0;
		foreach ($array as $elements)
		{
			if (strlen($elements) == 0)
				$i++;
		}	
	
		if ($i == count($array))
			return true;
		else
			return false;
	
	}/* friendly_mpp_empty_check() */

	if(class_exists('friendly_most_popular_posts'))
	{
		
		function register_friendly_popular_posts_widget()
		{
			register_widget('friendly_most_popular_posts');
		}/* register_friendly_popular_posts_widget() */
		
		//add_action('widgets_init', 'register_friendly_popular_posts_widget');
			
	}
	
	/* =========================================================================================== */
	
	/* =========================================================================================== */
	
	
	/*
		Related Posts Widget
	*/
	
	// Register thumbnail sizes.
	if ( function_exists('add_image_size') )
	{
		
		global $data;
		/* On first install this might not exist when we immediately activate theme (and throw a couple of errors) */
		if(!$data || !is_array($data))
		{
			$data = array();
		}

		if(array_key_exists('friendly_related_post_thumb_sizes', $data))
		{
		
			$sizes = $data['friendly_related_post_thumb_sizes'];
			if ( $sizes )
			{
				foreach ( $sizes as $id=>$size )
					add_image_size( 'related_post_thumb_size' . $id, $size[0], $size[1], true );
			}
		
		}
		
	}
	
	/* ========================================================================================= */
	

	class friendly_related_posts extends WP_Widget
	{

		function friendly_related_posts()
		{
	
			$widget_ops = array('classname' => 'friendly-related-posts', 'description' => __('List related posts', 'mercury'));
			$this->WP_Widget('friendly-related-posts', __('Friendly Related Posts', 'mercury'), $widget_ops);
		
		}/* friendly_related_posts */
		
		/* ========================================================================================= */
		


		function widget($args, $instance)
		{
		
			// Only show widget if on a post page.
			if ( !is_single() ) return;
		
			global $post;
			$post_old = $post; // Save the post object.
			
			extract( $args );
			
			if( !$instance["title"] )
				$instance["title"] = "Related Posts";
			
			// Excerpt length filter
			$new_excerpt_length = create_function('$length', "return " . $instance["excerpt_length"] . ";");
			if ( $instance["excerpt_length"] > 0 )
				add_filter('excerpt_length', $new_excerpt_length);
		
			$tags = wp_get_post_tags($post->ID);
		
			if ($tags)
			{
				
				$tag_ids = array();
				foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			
				$args=array(
					'tag__in' => $tag_ids,
					'post__not_in' => array($post->ID),
					'showposts'=> $instance['num'], // Number of related posts that will be shown.
					'caller_get_posts'=>1
					);
				$my_query = new WP_Query($args);
				if( $my_query->have_posts() )
				{
					
					echo $before_widget;
		
					// Widget title
					echo $before_title . $instance["title"] . $after_title;
					
					echo "<ul>\n";
					while ($my_query->have_posts())
					{
						
						$my_query->the_post();
						?>
						<li class="related-post-item">
							
							<?php
								if (
									function_exists('the_post_thumbnail') && 
									current_theme_supports("post-thumbnails") &&
									$instance["thumb"] &&
									has_post_thumbnail()
								) :
							?>
							
							<?php 
							
								$title = get_the_title();
								$permalink = get_permalink();
							
								if(has_post_thumbnail())
								{
									$post_thumbnail_id = get_post_thumbnail_id( $this_post_id );
									$post_thumbnail_array = wp_get_attachment_image_src($post_thumbnail_id, 'large');
									$image = $post_thumbnail_array[0];
								}
								else
								{
									$image = friendly_get_the_image();
								}
							
							?>
								
							<div class="related_post_image"><a class="related_posts_image_link" href="<?php echo $permalink; ?>" title="<?php echo $title; ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/inc/thumb.php?src=<?php echo friendly_change_image_url_on_multisite($image); ?>&h=64&w=64&zc=1" alt="<?php echo $title; ?>" /></a></div>

							<?php endif; ?>
							
							<h4><a class="related-post-title" href="<?php the_permalink() ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h4>
							
							<?php if(array_key_exists('date',$instance)): ?>
							<p class="post-date"><?php the_time("j M Y"); ?></p>
							<?php endif; ?>
							
							<?php if ( $instance['excerpt'] ) : ?>
							<?php the_excerpt(); ?> 
							<?php endif; ?>
							
							<?php if(array_key_exists('comment_num',$instance)): ?>
							<p class="comment-num">(<?php comments_number(); ?>)</p>
							<?php endif; ?>
						</li>
						<?php
					
					}
					
					echo "</ul>\n";
					
					echo $after_widget;
				
				}
			
			}
		
			remove_filter('excerpt_length', $new_excerpt_length);
		
			$post = $post_old; // Restore the post object.
			
		}
		
		/* ========================================================================================= */


		function update($new_instance, $old_instance)
		{
	
			if ( function_exists('the_post_thumbnail') )
			{
				global $data;
				if(array_key_exists('friendly_related_post_thumb_sizes',$data))
					$sizes = $data['friendly_related_post_thumb_sizes'];
				if ( !$sizes ) $sizes = array();
				$sizes[$this->id] = array($new_instance['thumb_w'], $new_instance['thumb_h']);
				update_option(OPTIONS."['friendly_related_post_thumb_sizes']", $sizes);
			}
			
		    return $new_instance;
		    
		}/* update() */

		/* ========================================================================================= */
		
		
		function form($instance)
		{
		
			?>
			<p>
				<label for="<?php echo $this->get_field_id("title"); ?>">
					<?php _e( 'Title', 'mercury' ); ?>:
					<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("num"); ?>">
					<?php _e('Number of posts to show', 'mercury'); ?>:
					<input style="text-align: center;" id="<?php echo $this->get_field_id("num"); ?>" name="<?php echo $this->get_field_name("num"); ?>" type="text" value="<?php echo absint($instance["num"]); ?>" size='3' />
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("excerpt"); ?>">
					<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("excerpt"); ?>" name="<?php echo $this->get_field_name("excerpt"); ?>"<?php checked( (bool) $instance["excerpt"], true ); ?> />
					<?php _e( 'Show post excerpt', 'mercury' ); ?>
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("excerpt_length"); ?>">
					<?php _e( 'Excerpt length (in words):', 'mercury' ); ?>
				</label>
				<input style="text-align: center;" type="text" id="<?php echo $this->get_field_id("excerpt_length"); ?>" name="<?php echo $this->get_field_name("excerpt_length"); ?>" value="<?php echo $instance["excerpt_length"]; ?>" size="3" />
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("comment_num"); ?>">
					<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("comment_num"); ?>" name="<?php echo $this->get_field_name("comment_num"); ?>"<?php checked( (bool) $instance["comment_num"], true ); ?> />
					<?php _e( 'Show number of comments', 'mercury' ); ?>
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("date"); ?>">
					<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("date"); ?>" name="<?php echo $this->get_field_name("date"); ?>"<?php checked( (bool) $instance["date"], true ); ?> />
					<?php _e( 'Show post date', 'mercury' ); ?>
				</label>
			</p>
		
			<?php if ( function_exists('the_post_thumbnail') && current_theme_supports("post-thumbnails") ) : ?>
		
				<p>
					<label for="<?php echo $this->get_field_id("thumb"); ?>">
						<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id("thumb"); ?>" name="<?php echo $this->get_field_name("thumb"); ?>"<?php checked( (bool) $instance["thumb"], true ); ?> />
						<?php _e( 'Show post thumbnail', 'mercury' ); ?>
					</label>
				</p>
		
			<?php endif; ?>

		<?php

		}/* form() */

	}/* class friendly_related_posts() */
	
	
	if(class_exists('friendly_related_posts'))
	{
		
		function register_friendly_related_posts_widget()
		{
			register_widget('friendly_related_posts');
		}/* register_friendly_popular_posts_widget() */
		
		add_action('widgets_init', 'register_friendly_related_posts_widget');
			
	}

	/* =========================================================================================== */
	
	/* =========================================================================================== */
	
	
	/*
		Recent posts with thumbnails widget
	*/
	
	class friendly_recent_posts_with_thumbnails_widget extends WP_Widget
	{

		function friendly_recent_posts_with_thumbnails_widget()
		{
			
			$widget_ops = array('classname' => 'friendly_recent_posts', 'description' => 'Recent Posts with Thumbs');
			$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'friendly-recent-posts-thumbs-widget');
	
			$this->WP_Widget('friendly-recent-posts-thumbs-widget', 'Friendly Recent Posts With Thumbs', $widget_ops, $control_ops);

		}/* friendly_recent_posts_with_thumbnails_widget() */
		
		/* ========================================================================================= */
	

		function widget($args, $instance)
		{
		
			global $post;
			extract( $args );
			
			if( !$instance["title"] )
				$instance["title"] = "Recent Posts";
				
			if( !$instance['number_of_posts'] )
				$instance['number_of_posts'] = "3"; //Set 3 posts to be the default
			
			$q_args = array( 'posts_per_page' => $instance['number_of_posts'], 'post__not_in' => get_option( 'sticky_posts' ) );
			$my_query = new WP_Query( $q_args );
			
			if( $my_query->have_posts() )
			{
					
				echo $before_widget;
				echo $before_title. $instance["title"].$after_title;
				echo "<ul>";
				
				while ($my_query->have_posts()) : $my_query->the_post(); ?>
					<li>
						<a class="recent_post_image" title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark">
							<?php the_post_thumbnail(array(50,50), array ('class' => 'alignleft')); ?>
						</a>
						<h5><a class="recent_post_title" title="<?php the_title(); ?>" href="<?php the_permalink() ?>" rel="bookmark">
							<?php the_title(); ?>
						</a></h5>
					</li>				

				<?php endwhile; wp_reset_query();
				
				echo "</ul>\n";
				
				echo $after_widget;
			
			}
			
		
		}/* widget() */
		
		/* ========================================================================================= */


		function update($new_instance, $old_instance)
		{
		
			$instance = $old_instance;
	
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number_of_posts'] = strip_tags($new_instance['number_of_posts']);
	
	        return $instance;
		
		}/* update() */
		
		/* ========================================================================================= */


		function form($instance)
		{
		
			$defaults = array( 'title' => 'Recent Posts', 'number_of_posts' => '3');
			$instance = wp_parse_args( (array) $instance, $defaults );
		
			?>
			
			<p>
				<label for="<?php echo $this->get_field_id("title"); ?>">
					<?php _e( 'Title', 'mercury' ); ?>:
					<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("number_of_posts"); ?>">
					<?php _e('Number of posts to show', 'mercury'); ?>:
					<input style="text-align: center;" id="<?php echo $this->get_field_id("number_of_posts"); ?>" name="<?php echo $this->get_field_name("number_of_posts"); ?>" type="text" value="<?php echo absint($instance["number_of_posts"]); ?>" size="3" />
				</label>
			</p>
			
			<?php
		
		}/* form() */
		
		/* ========================================================================================= */
		
		
	}/* class friendly_recent_posts_with_thumbnails_widget() */
	
	
	if(class_exists('friendly_recent_posts_with_thumbnails_widget'))
	{
		
		function register_friendly_recent_posts_with_thumbs_widget()
		{
			register_widget('friendly_recent_posts_with_thumbnails_widget');
		}/* register_friendly_recent_posts_with_thumbs_widget() */
		
		add_action('widgets_init', 'register_friendly_recent_posts_with_thumbs_widget');
			
	}/* if(class_exists()) */
	
	/* =========================================================================================== */
	
	/* =========================================================================================== */
	
	
	/*
		Top Commentators Widget
	*/
	
	class friendly_top_commentators extends WP_Widget
	{
	
		function friendly_top_commentators()
		{
		
			$widget_ops = array('classname' => 'friendly_top_commentators', 'description' => 'Top Commentators');
			$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'friendly-top-commentators-widget');
	
			$this->WP_Widget('friendly-top-commentators-widget', 'Friendly Top Commentators', $widget_ops, $control_ops);
		
		}/* friendly_top_commentators() */
		
		/* ========================================================================================= */
		
		
		function widget($args, $instance)
		{
		
			global $wpdb;
			extract( $args );
			$commenters =  $wpdb->get_results("SELECT COUNT(comment_author) AS comment_comments, comment_author, comment_author_url, comment_author_email FROM $wpdb->comments WHERE comment_type != 'pingback' AND comment_author != '' AND comment_approved = '1' GROUP BY comment_author ORDER BY comment_comments DESC, comment_author");
      
      		if(count($commenters) > 0)
      		{
      
      			$commenters = array_slice($commenters,0,$instance['number_of_commentators']);
      			
      			echo $before_widget;
      			echo $before_title. $instance["title"].$after_title;
      			echo "<ul>";
      			
      			// start foreach commenter
				foreach ($commenters as $k)
				{
					
					$url = $wpdb->get_var("SELECT comment_author_url FROM $wpdb->comments WHERE comment_author_email = '".addslashes($k->comment_author_email)."' AND comment_author_url != 'http://' AND comment_approved = 1 ORDER BY comment_date DESC LIMIT 1");
											
					$image = md5(strtolower($k->comment_author_email));
					$image_output = '<img class="comment_gravatar" src="http://www.gravatar.com/avatar.php?gravatar_id='.$image.'&amp;size=32" alt ="'.$k->comment_author.'" title="'.$k->comment_author.'" /> ';
					
					if($url != "" && $image != "")
					{
						echo "<li><a href='".$url."' title='".$k->comment_author."'>";
							echo $image_output;
							echo "<span class='top_author'>".$k->comment_author."</span>";
						echo "</a></li>";
					}
					
				}
				
			}
			
			echo "</ul>";
			echo $after_widget;


		}/* widget() */
		
		/* ========================================================================================= */
		
		
		function update($new_instance, $old_instance)
		{
		
			$instance = $old_instance;
	
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['number_of_commentators'] = strip_tags($new_instance['number_of_commentators']);
	
	        return $instance;
		
		}/* update() */
		
		/* ========================================================================================= */
		
		
		function form($instance)
		{
		
			$defaults = array( 'title' => 'Top Commentators', 'number_of_commentators' => '3');
			$instance = wp_parse_args( (array) $instance, $defaults );
		
			?>
			
			<p>
				<label for="<?php echo $this->get_field_id("title"); ?>">
					<?php _e( 'Title', 'mercury' ); ?>:
					<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("number_of_commentators"); ?>">
					<?php _e('Number of commentators to show', 'mercury'); ?>:
					<input style="text-align: center;" id="<?php echo $this->get_field_id("number_of_commentators"); ?>" name="<?php echo $this->get_field_name("number_of_commentators"); ?>" type="text" value="<?php echo absint($instance["number_of_commentators"]); ?>" size="3" />
				</label>
			</p>
			
			<?php
		
		}/* form() */
	
	}/* class friendly_top_commentators */
	
	if(class_exists('friendly_top_commentators'))
	{
		
		function register_friendly_top_commentators_widget()
		{
			register_widget('friendly_top_commentators');
		}/* register_friendly_recent_posts_with_thumbs_widget() */
		
		add_action('widgets_init', 'register_friendly_top_commentators_widget');
			
	}/* if(class_exists()) */
	
	/* =========================================================================================== */
	
	/* =========================================================================================== */
	
	
	/*
		Portfolio Slider Widget
	*/
	
	class friendly_portfolio_slider extends WP_Widget
	{
	
		function friendly_portfolio_slider()
		{
		
			$widget_ops = array('classname' => 'friendly_portfolio_slider', 'description' => 'The Friendly Themes portfolio slider');
			$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'friendly-portfolio-slider-widget');
	
			$this->WP_Widget('friendly-portfolio-slider-widget', 'Friendly Portfolio Slider', $widget_ops, $control_ops);
		
		}/* friendly_portfolio_slider() */
		
		/* ========================================================================================= */
		
		function widget($args, $instance)
		{
		
			extract($args);
			
			$title = apply_filters('widget_title', $instance['title'] );
			
			$image_1_url =	$instance['image_1_url'];
			$image_2_url =	$instance['image_2_url'];
			$image_3_url =	$instance['image_3_url'];
			$image_4_url =	$instance['image_4_url'];
			
			$project_info_text = $instance['project_info_text'];
			
			$more_link_url = $instance['more_link_url'];
			$more_link_text = $instance['more_link_text'];
			
			
			/* Before widget - Set by theme call */
			echo $before_widget;
			
			/* Echo the title if there is one */
			if ( $title )
				echo "<h5>" . $title . "</h5>";
				
			echo "<div id='portfolio_slider_total_container'>";
			
				echo "<div id='portfolio_slider_mask'>";
					echo "<img src='".get_stylesheet_directory_uri()."/images/white-mask.png' alt='' />";
				echo "</div>";
				
				echo "<div class='portfolio_slider'>";
				
					echo "<ul>";
				
						/* Echo the images - max of 4 */
						if($image_1_url && $image_1_url != "")
						{
						
							echo "<li>";
								echo "<a href='#' title=''>";
									echo "<img src='$image_1_url' alt='' />";
								echo "</a>";
							echo "</li>";
						
						}
						
						if($image_2_url && $image_2_url != "")
						{
						
							echo "<li>";
								echo "<a href='#' title=''>";
									echo "<img src='$image_2_url' alt='' />";
								echo "</a>";
							echo "</li>";
						
						}
						
						if($image_3_url && $image_3_url != "")
						{
						
							echo "<li>";
								echo "<a href='#' title=''>";
									echo "<img src='$image_3_url' alt='' />";
								echo "</a>";
							echo "</li>";
						
						}
						
						if($image_4_url && $image_4_url != "")
						{
						
							echo "<li>";
								echo "<a href='#' title=''>";
									echo "<img src='$image_4_url' alt='' />";
								echo "</a>";
							echo "</li>";
						
						}
						
					echo "</ul>";
					
				echo "</div>";
				
				echo "<div id='portfolio_project_info'>";
				
					echo $project_info_text;
					
					echo "<p class='portfolio_slider_project_more_button'><a href='$more_link_url' title=''>$more_link_text</a></p>";
				
				echo "</div>";
				
				echo $after_widget;
		
		}/* widget() */
		
		/* ========================================================================================= */
		
		function update($new_instance, $old_instance)
		{
		
			$instance = $old_instance;
			
			$instance['title'] = strip_tags( $new_instance['title'] );
			
			$instance['image_1_url'] = $new_instance['image_1_url'];
			$instance['image_2_url'] = $new_instance['image_2_url'];
			$instance['image_3_url'] = $new_instance['image_3_url'];
			$instance['image_4_url'] = $new_instance['image_4_url'];
			
			$instance['project_info_text'] = $new_instance['project_info_text'];
			
			$instance['more_link_url'] = $new_instance['more_link_url'];
			$instance['more_link_text'] = $new_instance['more_link_text'];
			
			return $instance;
		
		}/* update() */
		
		/* ========================================================================================= */
		
		function form($instance)
		{
		
			$defaults = array(
				'title' => 'Our Latest Portfolio Piece',
				'image_1_url' => '',
				'image_2_url' => '',
				'image_3_url' => '',
				'image_4_url' => '',
				'project_info_text' => '<h6>Here is the Project Title</h6><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam mauris lacus, mattis volutpat egestas non, scelerisque quis ligula.</p>',
				'more_link_url' => 'http://www.google.com/',
				'more_link_text' => 'More'
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			?>
			
				<p>
					<label for="<?php echo $this->get_field_id( 'title' ); ?>">Title: </label>
					<input id="<?php echo $this->get_field_id( 'title' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" />
				</p>
				
				
				
				<p>
					<label for="<?php echo $this->get_field_id( 'image_1_url' ); ?>">Image 1 URL: </label>
					<input id="<?php echo $this->get_field_id( 'image_1_url' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'image_1_url' ); ?>" value="<?php echo $instance['image_1_url']; ?>" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'image_2_url' ); ?>">Image 2 URL: </label>
					<input id="<?php echo $this->get_field_id( 'image_2_url' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'image_2_url' ); ?>" value="<?php echo $instance['image_2_url']; ?>" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'image_3_url' ); ?>">Image 3 URL: </label>
					<input id="<?php echo $this->get_field_id( 'image_3_url' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'image_3_url' ); ?>" value="<?php echo $instance['image_3_url']; ?>" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'image_4_url' ); ?>">Image 4 URL: </label>
					<input id="<?php echo $this->get_field_id( 'image_4_url' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'image_4_url' ); ?>" value="<?php echo $instance['image_4_url']; ?>" />
				</p>
				
				
				
				<p>
					<label for="<?php echo $this->get_field_id( 'project_info_text' ); ?>">Project Info: </label>
					<textarea rows="5" id="<?php echo $this->get_field_id( 'project_info_text' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'project_info_text' ); ?>"><?php echo $instance['project_info_text']; ?></textarea>
				</p>
				
				
				<p>
					<label for="<?php echo $this->get_field_id( 'more_link_url' ); ?>">More Link URL: </label>
					<input id="<?php echo $this->get_field_id( 'more_link_url' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'more_link_url' ); ?>" value="<?php echo $instance['more_link_url']; ?>" />
				</p>
				
				<p>
					<label for="<?php echo $this->get_field_id( 'more_link_text' ); ?>">More Link Text: </label>
					<input id="<?php echo $this->get_field_id( 'more_link_text' ); ?>" class="widefat" name="<?php echo $this->get_field_name( 'more_link_text' ); ?>" value="<?php echo $instance['more_link_text']; ?>" />
				</p>
			
			<?php
		
		}/* form() */
	
	}/* class friendly_portfolio_slider */
	
	if(class_exists('friendly_portfolio_slider'))
	{
		
		function register_friendly_portfolio_slider_widget()
		{
			register_widget('friendly_portfolio_slider');
		}/* register_friendly_portfolio_slider_widget() */
		
		add_action('widgets_init', 'register_friendly_portfolio_slider_widget');
			
	}/* if(class_exists()) */
	
	/* =========================================================================================== */
	
	/* =========================================================================================== */
	
	/*
		Social Media Widget
	*/
	
	class friendly_social_media extends WP_Widget
	{
	
		function friendly_social_media()
		{
		
			$widget_ops = array('classname' => 'friendly_social_media', 'description' => 'Social Media');
			$control_ops = array('width' => 300, 'height' => 350, 'id_base' => 'friendly-social-media-widget');
	
			$this->WP_Widget('friendly-social-media-widget', 'Friendly Social Media', $widget_ops, $control_ops);
		
		}/* friendly_social_media() */
		
		/* ========================================================================================= */
		
		
		function widget($args, $instance)
		{
		
			extract($args);
			
			$title = apply_filters('widget_title', $instance['title'] );
			$subtitle = 		$instance['subtitle'];
			
			$icon_set = $instance['icon_set'];
			
			$facebook_url  =	$instance['facebook_url'];
			$twitter_url  =		$instance['twitter_url'];
			$flickr_url  =		$instance['flickr_url'];
			
			/* Before widget - Set by theme call */
			echo $before_widget;
			
			/* Echo the title if there is one */
			if ( $title )
				echo $before_title. $instance["title"].$after_title;
				
			if( $subtitle && $subtitle != "" )
				echo "<h4>" . $subtitle . "</h4>";
				
			echo "<ul id='footer_social_icons'>";
			
				if( $facebook_url )
				{
					echo "<li>";
						echo "<a href='$facebook_url' title='".__('View our page on Facebook', THEMENAME)."' class='tip'>";
							echo "<img src='".get_stylesheet_directory_uri()."/theme_assets/images/social-facebook-$icon_set.png' alt='' />";
						echo "</a>";
					echo "</li>";
				}
				
				if( $twitter_url )
				{
					echo "<li>";
						echo "<a href='$twitter_url' title='".__('Connect with us on Twitter', THEMENAME)."' class='tip'>";
							echo "<img src='".get_stylesheet_directory_uri()."/theme_assets/images/social-twitter-$icon_set.png' alt='' />";
						echo "</a>";
					echo "</li>";
				}
				
				if( $flickr_url )
				{
					echo "<li>";
						echo "<a href='$flickr_url' title='".__('View our photos on Flickr', THEMENAME)."' class='tip'>";
							echo "<img src='".get_stylesheet_directory_uri()."/theme_assets/images/social-flickr-$icon_set.png' alt='' />";
						echo "</a>";
					echo "</li>";
				}
				
				echo "<li>";
					echo "<a href='".get_bloginfo('rss2_url')."' title='".__('Grab our RSS Feed', THEMENAME)."' class='tip'>";
						echo "<img src='".get_stylesheet_directory_uri()."/theme_assets/images/social-rss-$icon_set.png' alt='' />";
					echo "</a>";
				echo "</li>";
			
			echo "</ul>";
			
			echo $after_widget;
		
		}/* widget() */
		
		/* ========================================================================================= */
		
		
		function update($new_instance, $old_instance)
		{
		
			$instance = $old_instance;
	
			$instance['title'] = strip_tags($new_instance['title']);
			$instance['subtitle'] = strip_tags($new_instance['subtitle']);
			
			$instance['facebook_url'] = strip_tags($new_instance['facebook_url']);
			$instance['twitter_url'] = strip_tags($new_instance['twitter_url']);
			$instance['flickr_url'] = strip_tags($new_instance['flickr_url']);
			$instance['icon_set'] = strip_tags($new_instance['icon_set']);
	
	        return $instance;
		
		}/* update() */
		
		/* ========================================================================================= */
		
		
		function form($instance)
		{
		
			$defaults = array(
				'title' => 'Socialise With Us',
				'icon_set' => 'white',
				'subtitle' => 'and stay in touch with our very latest news',
				'facebook_url' => 'http://www.facebook.com/',
				'twitter_url' => 'http://www.twitter.com/friendlythemes',
				'flickr_url' => 'http://www.flickr.com/'
			);
			
			$instance = wp_parse_args( (array) $instance, $defaults );
			
			?>
			
			<p>
				<label for="<?php echo $this->get_field_id("title"); ?>">
					<?php _e( 'Title', THEMENAME ); ?>:
					<input class="widefat" id="<?php echo $this->get_field_id("title"); ?>" name="<?php echo $this->get_field_name("title"); ?>" type="text" value="<?php echo esc_attr($instance["title"]); ?>" />
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("subtitle"); ?>">
					<?php _e( 'Subtitle', THEMENAME ); ?>:
					<input class="widefat" id="<?php echo $this->get_field_id("subtitle"); ?>" name="<?php echo $this->get_field_name("subtitle"); ?>" type="text" value="<?php echo esc_attr($instance["subtitle"]); ?>" />
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("icon_set"); ?>">
					<?php _e( 'Icon Set', THEMENAME ); ?>:
					<select id="<?php echo $this->get_field_id('icon_set'); ?>" name="<?php echo $this->get_field_name('icon_set'); ?>" class="widefat">
						<option value="white"<?php selected( $instance['icon_set'], 'title' ); ?>><?php _e('White', THEMENAME); ?></option>
						<option value="dark"<?php selected( $instance['icon_set'], 'dark' ); ?>><?php _e('Dark', THEMENAME); ?></option>
					</select>
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("facebook_url"); ?>">
					<?php _e( 'Facebook URL', THEMENAME ); ?>:
					<input class="widefat" id="<?php echo $this->get_field_id("facebook_url"); ?>" name="<?php echo $this->get_field_name("facebook_url"); ?>" type="text" value="<?php echo esc_attr($instance["facebook_url"]); ?>" />
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("twitter_url"); ?>">
					<?php _e( 'Twitter URL:', THEMENAME ); ?>:
					<input class="widefat" id="<?php echo $this->get_field_id("twitter_url"); ?>" name="<?php echo $this->get_field_name("twitter_url"); ?>" type="text" value="<?php echo esc_attr($instance["twitter_url"]); ?>" />
				</label>
			</p>
			
			<p>
				<label for="<?php echo $this->get_field_id("flickr_url"); ?>">
					<?php _e( 'Flickr URL', THEMENAME ); ?>:
					<input class="widefat" id="<?php echo $this->get_field_id("flickr_url"); ?>" name="<?php echo $this->get_field_name("flickr_url"); ?>" type="text" value="<?php echo esc_attr($instance["flickr_url"]); ?>" />
				</label>
			</p>
			
			<?php
		
		}/* form() */
	
	}/* class friendly_social_media */
	
	
	if(class_exists('friendly_social_media'))
	{
		
		function register_friendly_social_media_widget()
		{
			register_widget('friendly_social_media');
		}/* register_friendly_social_media_widget() */
		
		add_action('widgets_init', 'register_friendly_social_media_widget');
			
	}/* if(class_exists()) */
	
	/* =========================================================================================== */
	
	/* =========================================================================================== */

?>