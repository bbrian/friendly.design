<?php

	if (!function_exists('of_options'))
	{
	
		function of_options()
		{
			
			/*
				A few things that might need to be changed per theme
			*/
			$theme_name = THEMENAME;
			
			$install_options_radio = array(
				"demo" => __("1) Just like the demo",THEMENAME),
				"minimum" => __("2) Bare minimum of options",THEMENAME),
				"none" => __("3) I'll find my own way, thanks",THEMENAME),
			);
			$number_of_install_options = count($install_options_radio);
			
			$wp_xml_file_location = "http://dl.dropbox.com/u/455309/test_data.xml";
			
			$opening_message = "Firstly, thank you. Thanks so much for buying this theme. We've tried to make $theme_name as easy as possible to use and we thought that you might like a helping hand to get started. Before you do anything, as always, you should make a <a href='http://codex.wordpress.org/WordPress_Backups' title='Information about backing up WordPress' target='_blank'>backup of your existing site</a> (if you have one). Once you've done that, we've got $number_of_install_options options for you:";
			
			//$install_help_video_url = "http://player.vimeo.com/video/31740376";
			$install_help_video_url = "http://player.vimeo.com/video/33412079";
			
			$install_help_message = "<p><strong>Option 1</strong> will create a set of posts, pages and portfolio items just like on our <a href='http://$theme_name.friendlythem.es/' title='The $theme_name Theme Demo Site'>demo site</a>. We'll also set your theme options just as they are on our demo site, too. Basically - you'll have an almost exact replica of the demo. <strong style='color: rgb(221,92,23);'>This may take quite a while (30 seconds is not unusual). Please be patient and do not press refresh.</strong> Some people find this option useful if they want to learn by example.</p><p style='padding: 15px; background: rgb(255,251,204); border: 1px solid rgb(230,219,85);'>Important! <br /><br />This option might not work on some hosting environments that have a relatively short timeout. This is because we are importing quite a lot of data from several different sources (including pictures, video, music etc.). If you are unsure, please select option 2 and then use the in-built WordPress import feature (Tools > Import) and use the file you can download from $wp_xml_file_location. <br /><br />If you do decide to choose option 1, please let the script finish running - do not press 'stop' or 'refresh' in your browser - it may take several minutes to finish.</p><p><strong>Option 2</strong> is for someone in a bit of a rush. It will create only a few (absolutely necessary) items for you to work from. This option may be best if you have a fresh install of WordPress and just want to get on with things.</p><p><strong>Option 3</strong> is for someone who already has all of their content in place and just wishes to get on with it. We wont create any new pages, posts, portfolio items or even whizzbangs. Neither will we set any options - that's all up to you.</p><p>&nbsp;</p><p>That just leaves us to say another thank you. We really hope you love this theme as much as we do - we're both really proud of it.</p><p>Andy &amp; Rich</p><p><hr /></p><p style='margin: 0 auto; text-align: centre;'><iframe src=\"$install_help_video_url?title=0&amp;byline=0&amp;portrait=0\" width=\"697\" height=\"400\" frameborder=\"0\" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe></p>";
			
			$help_message = "We're sorry to hear you're having some slight problems with our theme and you're hunting for help. Firstly, thanks for doing exactly that - chances are, we've got you covered, already - and we've tried to make it as easy as possible for you to find the answer to your problem without having to ask us. However, if you're still stuck after looking here, try the extensive help document that came with your theme. If <em>that</em> doesn't help you, then allow Andy and I to apologise. We're here for you though - have a look through the comments section of the site where you bought this theme from. If your answer isn't in there, then you'll want to <a href='javascript:void(0)' class='send_support_email'>send us an e-mail</a>";
			
			$enable_maintenance_options = true;
			$enable_holding_page_options = true;
			
			/* ============================================================================== */
			
			/*
				You shouldn't need to edit below here
			*/
			
			/* ============================================================================== */
			
			//Access the WordPress Categories via an Array
			$of_categories = array();  
			$of_categories_obj = get_categories('hide_empty=0');
			
			foreach ($of_categories_obj as $of_cat)
			{
				$of_categories[$of_cat->cat_ID] = $of_cat->cat_name;
			}
			
			$categories_tmp = array_unshift($of_categories, __("Select a category: ",THEMENAME));    
			   
			//Access the WordPress Pages via an Array
			$of_pages = array();
			$of_pages_obj = get_pages('sort_column=post_parent,menu_order');    
			
			foreach ($of_pages_obj as $of_page)
			{
			    $of_pages[$of_page->ID] = $of_page->post_name;
			}
			
			$of_pages_tmp = array_unshift($of_pages, __("Select a page:",THEMENAME));       
			 
			
			
			$remove_meta_options = array(
				"wp_generator" => "wp_generator",
				"rsd_link" => "rsd_link",
				"wlwmanifest_link" => "wlwmanifest_link",
				"wp_shortlink_wp_head" => "wp_shortlink_wp_head",
				"index_rel_link" => "index_rel_link",
				"start_post_rel_link" => "start_post_rel_link", 
				"adjacent_posts_rel_link_wp_head" => "adjacent_posts_rel_link_wp_head"
			); 
		
		
			$uploads_arr = wp_upload_dir();
			$all_uploads_path = $uploads_arr['path'];
			$all_uploads = get_option('of_uploads');
			
			$slider_style_transitions = array(
				"Slide",
				"Fade",
				"Explode",
				"Slice",
				"Blinds"
			);
			
			$true_false_dropdown = array(
				"False",
				"True"
			);
		
			/* ============================================================================== */
			
		
			/*
				The Options Array
			*/
		
		
			global $my_options;
			$my_options = array();
			$saved_options = get_option(OPTIONS);
			if( !is_array($saved_options) )
				$saved_options = array();
			
			if( (array_key_exists('first_run_option_selected',$saved_options)) && ($saved_options['first_run_option_selected'] == "1") ) :
		
				if( function_exists('friendly_create_demo_menu_items') )
					friendly_create_demo_menu_items();
		
				if( (array_key_exists('lock_key',$saved_options)) && ($saved_options['lock_key'] != "") )
				{
				
					/* There's a lock pin entered. Only show the unlock screen */
					$my_options[] = array(
						"name" => __("Unlock Options",THEMENAME),
						"type" => "heading"
					);
					
					$my_options[] = array(
						"name" => __("Your theme options panel is locked",THEMENAME),
						"desc" => __("Enter the unlock code, press 'save all changes' <strong>and then refresh this page</strong> to see the theme options panel",THEMENAME),
						"id" => "unlock_key",
						"std" => "",
						"type" => "unlock_screen"
					);    
				
				}
				else
				{
				
					/* No lock PIN entered, show the menu */
					$my_options[] = array(
						"name" => __("General Settings",THEMENAME),
						"type" => "heading"
					);
									
					$my_options[] = array(
						"name" => __("Custom Logo",THEMENAME),
						"desc" => __("Upload a logo for your theme.",THEMENAME),
						"id" => "logo",
						"std" => "",
						"type" => "upload"
					);
					
					$my_options[] = array(
						"name" => __("Custom Favicon",THEMENAME),
						"desc" => __("Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",THEMENAME),
						"id" => "custom_favicon",
						"std" => "",
						"type" => "upload"
					);
					
					$my_options[] = array(
						"name" => __("Custom iPhone/iPad Icon",THEMENAME),
						"desc" => __("Upload a 129x129 Png/Gif image that will represent your website's iPhone/iPad icon - we will resize for the appropriate device.",THEMENAME),
						"id" => "idevice_icon",
						"std" => "",
						"type" => "upload"
					); 
									
					$url =  ADMIN . 'images/';
					
					$my_options[] = array(
						"name" => __("Show breadcrumbs?",THEMENAME),
						"desc" => __("Breadcrumbs give your visitors an extra method to navigate your site. Especially useful if you have several hierarchical pages on your site (i.e. more than 2 levels)",THEMENAME),
						"id" => "use_friendly_breadcrumbs",
						"std" => false,
						"type" => "checkbox"
					); 
				                                               
					$my_options[] = array(
						"name" => __("Google Analytics Code",THEMENAME),
						"desc" => __("Paste your google analytics number in here - it should look something like UA-2222222-2",THEMENAME),
						"id" => "google_analytics",
						"std" => "",
						"type" => "text"
					);        
					
					$my_options[] = array(
						"name" => __("Hide Advanced Theme Options",THEMENAME),
						"desc" => __("This theme comes with an awful lot of options - this helps make it one of the most flexible and useful on the planet. However, sometimes, too much choice can be a bad thing. If you just want to get on with things and make only a couple of modifications, simply check this box and only the absolutely necessary options will be shown.",THEMENAME),
						"id" => "hide_advanced_options",
						"std" => false,
						"type" => "checkbox"
					);
					
					/*$my_options[] = array(
						"name" => __("Theme Install Option Set",THEMENAME),
						"desc" => __("It's highly unlikely you'll need to touch this. But if you uncheck this box and save then you will see the 'install' options that you first saw when you purchased this theme.",THEMENAME),
						"id" => "first_run_option_selected",
						"std" => false,
						"type" => "checkbox"
					);*/
				                    
				    /* ============================================================================== */
					
					if( (!array_key_exists('hide_advanced_options', $saved_options)) ) :
					
					/* ============================================================================== */
					
					/*
						If the Holding Page is activated, place it above the Home Page
					*/
					
					if( (array_key_exists('activate_holding_page',$saved_options)) && ($saved_options['activate_holding_page'] == 1) && ( $enable_holding_page_options === true ) )
					{
					
						$my_options[] = array(
							"name" => __("Holding Page (Active)",THEMENAME),
							"type" => "heading"
						);
						
						$my_options[] = array(
							"name" => __("Your holding page is activated!",THEMENAME),
							"desc" => __("OK, your holding page has now been activated. Below, you can edit certain aspects, including the countdown date, the text and the twitter account from which to show tweets.",THEMENAME),
							"id" => "holding_page_activation_message",
							"std" => "",
							"type" => "message"
						);
						
						$my_options[] = array(
							"name" => __("Holding Page: Title",THEMENAME),
							"desc" => __("The text for the first line on the holding page.",THEMENAME),
							"id" => "holding_page_title",
							"std" => __("Oh! Hello, you are a little early!",THEMENAME),
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Holding Page: Subtitle",THEMENAME),
							"desc" => __("The text for the second line on the holding page.",THEMENAME),
							"id" => "holding_page_subtitle",
							"std" => "",
							"type" => "textarea"
						);
						
						$my_options[] = array(
							"name" => __("Holding Page: Text above countdown timer",THEMENAME),
							"desc" => __("The text shown just above the countdown timer",THEMENAME),
							"id" => "holding_page_above_countdown_timer",
							"std" => __("If the wind is with us, we will be ready in: ",THEMENAME),
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Holding Page: Countdown Date",THEMENAME),
							"desc" => __("What date would you like to countdown to?",THEMENAME),
							"id" => "holding_page_countdown_date",
							"std" => "",
							"type" => "date"
						);
						
						$my_options[] = array(
							"name" => __("Holding Page: Countdown time",THEMENAME),
							"desc" => __("What time on the above date would you like to countdown to? (24 hour clock, i.e.: 9AM would be 09:00 and 4:35PM would be 16:35",THEMENAME),
							"id" => "holding_page_countdown_time",
							"std" => "09:00",
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Holding Page: Twitter Account Username",THEMENAME),
							"desc" => __("The username of the twitter account you wish to show tweets from on the holding page. (No need for the '@' symbol)",THEMENAME),
							"id" => "holding_page_twitter_username",
							"std" => "",
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Holding Page: Image 1",THEMENAME),
							"desc" => __("Upload an image for the holding page (up to 3)",THEMENAME),
							"id" => "holding_image_1",
							"std" => "",
							"type" => "upload"
						);
						
						$my_options[] = array(
							"name" => __("Holding Page: Image 2",THEMENAME),
							"desc" => __("Upload an image for the holding page (up to 3)",THEMENAME),
							"id" => "holding_image_2",
							"std" => "",
							"type" => "upload"
						);
						
						$my_options[] = array(
							"name" => __("Holding Page: Image 3",THEMENAME),
							"desc" => __("Upload an image for the holding page (up to 3)",THEMENAME),
							"id" => "holding_image_3",
							"std" => "",
							"type" => "upload"
						);
					
					} //End holding page
	
					
					/* ============================================================================== */
					
					/*
						Home Page Options
					*/
					
					$my_options[] = array(
						"name" => __("Home Page",THEMENAME),
						"type" => "heading"
					);
					
					//If the user has already updated their settings->reading page with a page for the home page, use that page
					if( (get_option('page_on_front'))) :
					
						$home_page_page = get_option('page_on_front');
						$page = get_post($home_page_page);
						$page_title = $page->post_title;
						$my_options[] = array(
							"name" => __("Correct page selected for home page?",THEMENAME),
							"desc" => __("Currently, you have WordPress set up to use the $page_title page as your home page. If this is incorrect. please visit the 'Reading' page under your Settings menu.",THEMENAME),
							"id" => "front_page_static_page",
							"std" => "",
							"type" => "message"
						); 
						
						
					else :
					
						//Show message to tell the user they haven't set a home 'page' so will be showing latest posts
						$my_options[] = array(
							"name" => __("Front page showing latest posts",THEMENAME),
							"desc" => __("You currently have WordPress set up to show your latest posts on the home page (the WordPress default). If you wish to have a specific page as your home page please visit your 'Reading' page under Settings.",THEMENAME),
							"id" => "front_page_latest_posts",
							"std" => "",
							"type" => "message"
						); 
						
					
					endif;		//end if( (get_option('page_on_front'))) :		
					
						
					/* ============================================================================== */
									
						$my_options[] = array(
							"name" => __("Typography",THEMENAME),
							"type" => "heading"
						);
						
						$my_options[] = array(
							"name" => __("Step 1: Custom Font Loading Code",THEMENAME),
							"desc" => __("We've tried to give you as much flexibility as possible when it comes to choosing custom fonts. The easiest way for you to include a custom font in your theme is to pop over to <a href='http://www.google.com/webfonts' title=''>Google Web Fonts</a> and find the font(s) you want to use. Press the 'Use this font' button and you'll be given some code to copy and paste (it'll start with <pre>link href=...</pre>) - put that into this box.",THEMENAME),
							"id" => "custom_font_loading",
							"std" => "",
							"type" => "textarea"
						);
						
						$my_options[] = array(
							"name" => __("Step 2: Custom Font Selector Code",THEMENAME),
							"desc" => __("Now that you've loaded your fonts, you need to apply them to elements on your website. Place the CSS you want in here and we'll do the rest. Example h1{ font-family: Lobster Two', arial, serif; }",THEMENAME),
							"id" => "custom_font_css",
							"std" => "",
							"type" => "textarea"
						);
						
						
					/* ============================================================================== */
						
						$my_options[] = array(
							"name" => __("Colours",THEMENAME),
							"type" => "heading"
						);
						
						$my_options[] = array(
							"name" =>  __("Main Text Colour",THEMENAME),
							"desc" => __("Pick a text colour for the main body of your text",THEMENAME),
							"id" => "main_text_colour",
							"std" => "#000",
							"type" => "color"
						); 
						
						$my_options[] = array(
							"name" => __("Custom CSS",THEMENAME),
							"desc" => __("Quickly add some CSS to your theme by adding it to this block.",THEMENAME),
							"id" => "custom_css",
							"std" => "",
							"type" => "textarea"
						);
						
						
					/* ============================================================================== */
								
						$my_options[] = array(
							"name" => "SEO",
							"type" => "heading"
						);
						
						if('1' != get_option('blog_public'))
						{
						
							//The user currently has search engines blocked. Remind them.
							$privacy_options_url = site_url()."/wp-admin/options-privacy.php";
							
							$my_options[] = array(
								"name" => __("Just a reminder: Search engines are blocked",THEMENAME),
								"desc" => __("We've noticed that your current <a href=\"$privacy_options_url\" title=\"\">privacy settings</a> mean that search engines are blocked from crawling your site. This basically means that you wont appear in the index of any search engine. If your site is for public consumption, you probably don't want this.",THEMENAME),
								"id" => "using_an_seo_plugin_message",
								"std" => "",
								"type" => "message"
							);
						
						}
						
						if( (defined('FRIENDLY_THEMES_SITE_USES_AN_SEO_PLUGIN')) && (FRIENDLY_THEMES_SITE_USES_AN_SEO_PLUGIN == 'NO') )
						{
							
							//The user has an SEO plugin activated - let them know that we've spotted it
							$seo_plugin = FRIENDLY_THEMES_SITE_USES_AN_SEO_PLUGIN;
							$my_options[] = array(
								"name" => __("Ah! You're using an SEO Plugin",THEMENAME),
								"desc" => __("So then, it looks like you're SEO savvy! We can see that you're using the $seo_plugin plugin. Nice work. We just wanted to let you know that we've noticed and our theme wont affect your settings in any way. If that plugin stops working or you just want to use fewer plugins, then we've got a whole host of SEO Features baked-in to this theme. They're below, for your perusal.",THEMENAME),
								"id" => "using_an_seo_plugin_message",
								"std" => "",
								"type" => "message"
							);
							
						}
						else
						{
							
							//The user DOES NOT HAVE an SEO plugin activated - let them know that we've spotted it
							$my_options[] = array(
								"name" => __("We can't spot an active SEO plugin",THEMENAME),
								"desc" => __("We've had a quick look into your active plugins list and can't spot an SEO plugin. But that's OK! This theme has a whole bunch of SEO goodness baked right into it. You'll find those options below. However, if you intend to use an SEO plugin, then this theme wont interfere. Everything will keep humming along nicely. If you are unsure as what is best for your site, we've found that Yoast's <a href='http://wordpress.org/extend/plugins/wordpress-seo/' title='WordPress SEO By Yoast plugin'>WordPress SEO Plugin</a> gives fantastic results.",THEMENAME),
								"std" => "",
								"type" => "message",
								"id" => "no_active_seo_plugin_message"
							);
							
						}
						
						$my_options[] = array(
							"name" => __("Home Page Description",THEMENAME),
							"desc" => __("<p>The description on your home page is <a href='http://www.seoconsult.com/seoblog/meta-tags-and-seo/the-importance-of-meta-description-tags.html' title='An article by SEO Consult on meta descriptions.'>vital</a> for SEO. Generally 25 to 30 words using no more than 155 characters. It should always be part of your SEO Strategy to ensure that the description is <a href='http://www.seoconsultants.com/articles/1007/meta-description' title='An article by SEO Consultants Directory'>relevant</a> to the content on the page.</p><p>There are also useful <a href='http://www.w3.org/TR/REC-html40/struct/global.html#h-7.4.4' title='w3.org docs'>guidelines</a> relating to the <em>meta</em> element</p>",THEMENAME),
							"id" => "home_page_description_metatag",
							"std" => "",
							"type" => "textarea"
						);
						
						$my_options[] = array(
							"name" => __("Home Page Title",THEMENAME),
							"desc" => __("As with the description, the title is important, too. Set one here if you like, otherwise we'll use the name of your site.",THEMENAME),
							"id" => "home_page_title",
							"std" => "",
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Add Portfolio Items to site search results?",THEMENAME),
							"desc" => __("By default, WordPress doesn't include custom post types in the default search results. Would you like to enable this?",THEMENAME),
							"id" => "add_cpt_to_search_results",
							"std" => false,
							"type" => "checkbox"
						);
						
						$my_options[] = array(
							"name" => __("Add Portfolio Items to RSS Feed?",THEMENAME),
							"desc" => __("Would you like your latest portfolio items to appear in your site's RSS Feed? IF so, enable this option.",THEMENAME),
							"id" => "add_cpt_to_rss_feed",
							"std" => false,
							"type" => "checkbox"
						);
						
						
					/* ============================================================================== */
					
						$my_options[] = array(
							"name" => __("Contact Form",THEMENAME),
							"type" => "heading"
						);
						
						global $current_user;
	      				get_currentuserinfo();
	      				$user_email = $current_user->user_email;
						
						$my_options[] = array(
							"name" => __("E-Mail address to send messages to",THEMENAME),
							"desc" => __("Which e-mail address should the contact form send mail to?",THEMENAME),
							"id" => "contact_form_email_address",
							"std" => $user_email,
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Message on success",THEMENAME),
							"desc" => __("When a user successfully fills out the contact form, what message would you like to be displayed?",THEMENAME),
							"id" => "contact_form_success_message",
							"std" => "Awesome! Thanks for that,",
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Message on failure",THEMENAME),
							"desc" => __("When a user incorrectly fills out the contact form, what message would you like to be displayed?",THEMENAME),
							"id" => "contact_form_failure_message",
							"std" => "Oh No! It has all gone horribly wrong. Please try again.",
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Send button text",THEMENAME),
							"desc" => __("What would you like the text to be of the button the user presses to submit the form?",THEMENAME),
							"id" => "contact_form_button_text",
							"std" => "Send It!",
							"type" => "text"
						);
	
						
					/* ============================================================================== */
									
						$my_options[] = array(
							"name" => __("Advanced Options",THEMENAME),
							"type" => "heading"
						);
						
						if( $enable_holding_page_options === true ) :
						
							$my_options[] = array(
								"name" => __("Activate Holding Page?",THEMENAME),
								"desc" => __("This theme has a built-in holding page meaning that if you want to put up a little teaser of your site before you launch, you can still get a consistent appearance. By ticking this box and saving your changes, you will get a new menu item called 'holding page'.",THEMENAME),
								"id" => "activate_holding_page",
								"std" => false,
								"type" => "checkbox"
							);
						
						endif;
						
						$my_options[] = array(
							"name" => __("Show dummy content?",THEMENAME),
							"desc" => __("We have set up this theme so that you are able to see what the site can look like when it has content in place. Would you like to show this dummy content when there is a 'blank' gap (i.e. a widget area where you have put no widgets). Select 'yes' to show this content when necessary or 'no' to leave those areas empty.",THEMENAME),
							"id" => "show_dummy_content",
							"std" => 1,
							"type" => "checkbox"
						);
											
						/*$my_options[] = array(
							"name" => __("Add thumbnails in Manage Posts &amp; Pages List",THEMENAME),
							"desc" => __("Would you like to add an extra column in the posts and pages list edit screen which shows a thumbnail from that post?.",THEMENAME),
							"id" => "show_thumbnail_posts_pages_screen",
							"std" => false,
							"type" => "checkbox"
						);*/
						
						$my_options[] = array(
							"name" => __("Experimental: Show Sliders/Accordions in WYSIWYG Editor",THEMENAME),
							"desc" => __("With our awesome shortcode editor, you can insert sliders and accordions right into the WordPress 'visual' editor, however, on some browsers and in certain situations, this simply isn't possible. At the moment, this only works (semi-) reliably in the latest versions of Google Chrome and intermittently in Firefox 5. The main reason for this not working 'reliably' is down to the way your browser, and in part, your internet connection works. The visual editor is basically an iFrame on top of a textarea, and some browsers don't like having javascript 'injected' into iframes. We've given it our best shot, but at the moment, some browsers just aren't up to speed. It's awesome when it works though.",THEMENAME),
							"id" => "make_visual_editor_a_true_wysiwyg_editor",
							"std" => false,
							"type" => "checkbox"
						);
						
						$my_options[] = array(
							"name" => __("Set maximum number of revisions",THEMENAME),
							"desc" => __("By default, WordPress keeps an infinite number of revisions of your posts - i.e. when you make a change, it keeps a record of it. If you make lots of edits to pages, your database can get pretty large (and hence slow). If you put a number here, WordPress will limit the number of revisions it stores. (This will be overwritten if you already have it set in your wp-config.php file)",THEMENAME),
							"id" => "number_of_revisions_for_posts",
							"std" => "",
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Rename Portfolio Slug",THEMENAME),
							"desc" => __("By default, the slug for the portfolio section is <em>portfolio</em>. If you wish to use a different slug, please type it in here and save. You will then need to visit settings > permalinks to flush. This should then work.",THEMENAME),
							"id" => "portfolio_slug",
							"std" => "portfolio",
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Rename Portfolio Title",THEMENAME),
							"desc" => __("The title for the portfolio is used on the portfolio home page. By default it is 'Portfolio'. If you would like to use something different, type that in here and save.",THEMENAME),
							"id" => "portfolio_title",
							"std" => "Portfolio",
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Rename Services Slug",THEMENAME),
							"desc" => __("By default, the slug for the services section is <em>services</em>. If you wish to use a different slug, please type it in here and save. You will then need to visit settings > permalinks to flush. This should then work.",THEMENAME),
							"id" => "services_slug",
							"std" => "services",
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("Rename Services Title",THEMENAME),
							"desc" => __("The title for services is used on the services home page. By default it is 'Services'. If you would like to use something different, type that in here and save.",THEMENAME),
							"id" => "services_title",
							"std" => "Services",
							"type" => "text"
						);
						
						$my_options[] = array(
							"name" => __("What is your API Key?",THEMENAME),
							"desc" => __("If you have a Friendly API Key, please enter it here. <small>This is <strong>not</strong> your 'purchase code' that you received when you bought this theme. We will have sent you an API key separately.</small>",THEMENAME),
							"id" => "friendly_api_key",
							"std" => "",
							"type" => "password"
						);
						
						$my_options[] = array(
							"name" => __("Theme Install Option Set",THEMENAME),
							"desc" => __("It's highly unlikely you'll need to touch this. But if you change this to 'no' you will see the 'install' screen you first saw when you first activated this theme.",THEMENAME),
							"id" => "first_run_option_selected",
							"std" => false,
							"type" => "checkbox"
						);
						
					/* ============================================================================== */
						
						$my_options[] = array(
							"name" => __("Admin Settings",THEMENAME),
							"type" => "heading"
						);
						
						$my_options[] = array(
							"name" => __("Custom Login Logo",THEMENAME),
							"desc" => __("If you want to use a custom image on the 'login' page, upload an image that is 326px wide by 67px tall. We can't resize this one so you'll need to make sure it is the right size.",THEMENAME),
							"id" => "custom_login_logo",
							"std" => "",
							"type" => "upload"
						);
						
						$my_options[] = array(
							"name" => __("Remove 'Reset Password' link from log in page?",THEMENAME),
							"desc" => __("Would you like to remove the link to reset passwords on the log in page",THEMENAME),
							"id" => "remove_password_reset",
							"std" => false,
							"type" => "checkbox"
						);
						
						$my_options[] = array(
							"name" => __("Remove 'comments' column from the Edit Pages screen?",THEMENAME),
							"desc" => __("If you don't allow comments on your pages, then you probably don't want the comments column on that page.",THEMENAME),
							"id" => "remove_comments_col_from_pages",
							"std" => false,
							"type" => "checkbox"
						);
						
						$my_options[] = array(
							"name" => "Lock Admin Panel",
							"desc" => "If you put a password or a PIN into this box, your admin panel will be locked. This means that when you refresh the options panel you will only be greeted by a box to enter the password/PIN and nothing else. This is great for when you have set up your site for a client and want to make sure they can't 'adjust' your hard work.",
							"id" => "lock_key",
							"std" => "",
							"type" => "text"
						);
	
						
					/* ============================================================================== */
					
					endif; //End if hide advanced
					
					/* ============================================================================== */
					
					$my_options[] = array(
						"name" => __("Sidebars",THEMENAME),
						"type" => "heading"
					);
					
					$my_options[] = array(
						"name" => __("Custom Sidebars <small><span style='color: rgb(170,170,170); font-size: 10px;'>Complete Sidebar Control</span></small>",THEMENAME),
						"desc" => __("Add as many custom sidebars as you like. Click the 'Add Sidebar' button above and then give the sidebar a name (fill in the box that appears) and then press 'Save All Changes' below. This sidebar will then be available to you on your widgets page.",THEMENAME),
						"id" => "theme_custom_sidebars",
						"std" => "",
						"type" => "theme_custom_sidebar"
					);
					
					/* ============================================================================== */
					if( $enable_maintenance_options === true ) :
							
						$my_options[] = array(
							"name" => __("Maintenance",THEMENAME),
							"type" => "heading"
						);
						
						$my_options[] = array(
							"name" => __("Enable the maintenance page",THEMENAME),
							"desc" => __("Enabling this option means all traffic to the site is redirected to the maintenance page. You must also select which page the user is redirected to - it will default to a page with a slug of 'maintenance' if you do not select one.",THEMENAME),
							"id" => "enable_maintenance_page",
							"std" => false,
							"type" => "checkbox"
						);
						
						$my_options[] = array(
							"name" => __("Select Maintenance Page",THEMENAME),
							"desc" => __("Please select which page you wish visitors to be redirected to when you activate the maintenance option above.",THEMENAME),
							"id" => "maintenance_page",
							"std" => __("Select Maintenance Page:",THEMENAME),
							"type" => "select",
							"options" => $of_pages
						);
					
					endif;
					
					/* ============================================================================== */
					
					$my_options[] = array(
						"name" => __("Import/Export",THEMENAME),
						"type" => "heading"
					);
					
					$my_options[] = array(
						"name" => __("Theme Options Export",THEMENAME),
						"desc" => __("This is an export of all of the theme options that you currently have saved.",THEMENAME),
						"id" => "theme_export_options",
						"std" => "",
						"type" => "theme_export_options"
					);
					
					$my_options[] = array(
						"name" => __("Theme Options Import",THEMENAME),
						"desc" => __("If you have an export of your options from another theme or from another instance of this theme then paste it into this box and press 'Save All Changes' below. This will then restore your theme with the options you have saved.",THEMENAME),
						"id" => "theme_import_options",
						"std" => "",
						"type" => "theme_import_options"
					);
					
					/* ============================================================================== */
									
						$my_options[] = array(
							"name" => __("Help",THEMENAME),
							"type" => "heading"
						);
						
						$my_options[] = array(
								"name" => __("Having problems?",THEMENAME),
								"desc" => __($help_message,THEMENAME),
								"std" => "",
								"type" => "message",
								"id" => "having_problems_message"
							);
						
						include('theme-help.php');
					
					/* ============================================================================== */
				
				}
				
			else :
			
				//This is the first time the Theme Options Panel has been accessed. Allow the user to install defaults
				$my_options[] = array(
					"name" => __("Install/First Run",THEMENAME),
					"type" => "heading"
				);
				
				$my_options[] = array(
					
					"name" => __("Hello, Hi, Hey There, Welcome!",THEMENAME),
					"desc" => __($opening_message,THEMENAME),
					"id" => "first_run_opening_message",
					"std" => "",
					"type" => "message"
				);
				
				$my_options[] = array(
					"name" => __("Install options",THEMENAME),
					"desc" => __("Please select an option then press <strong>'Save All Changes'</strong> below.",THEMENAME),
					"id" => "install_options_radio",
					"std" => "none",
					"type" => "radio",
					"options" => $install_options_radio
				);
				
				$my_options[] = array(
					"name" => __("What Do These Do?",THEMENAME),
					"desc" => __($install_help_message,THEMENAME),
					"id" => "first_run_explain_options_message",
					"std" => "",
					"type" => "message"
				);
				
			endif;
		
		}/* of_options() */
		
	}/* if (!function_exists('of_options')) */
	
	add_action('init','of_options');
	
	/* =========================================================================================== */

	/* $my_options[] = array(
						"name" => "Dev: Example Options",
						"type" => "heading"
					);
									
					$my_options[] = array(
						"name" => "Theme Stylesheet",
						"desc" => "Select your themes alternative color scheme.",
						"id" => "my_alt_style",
						"std" => "default.css",
						"type" => "select",
						"options" => $alt_stylesheets
					); 
									
					$my_options[] = array(
						"name" => "Custom Logo",
						"desc" => "Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)",
						"id" => "my_logo_add",
						"std" => "",
						"type" => "upload"
					);
					
					$my_options[] = array(
						"name" => "Remove elements from the &lt;head&gt; of your theme",
						"desc" => "WordPress automatically adds several items to the head of your theme. Not all of these are necessary and you may disable them by checking the relevant checkbox.",
						"id" => "remove_wp_meta",
						"std" => array("wp_generator"),
					  	"type" => "multicheck",
						"options" => $remove_meta_options
					);
									
					$my_options[] = array(
						"name" => "Remove the WordPress Admin Bar",
						"desc" => "Check this box to remove the admin bar from the top of the page.",
						"id" => "remove_admin_bar",
						"std" => false,
						"type" => "checkbox"
					);
				
					$my_options[] = array(
						"name" => "Theme Stylesheet",
						"desc" => "Select your themes alternative color scheme.",
						"id" => "alt_stylesheet",
						"std" => "default.css",
						"type" => "select",
						"options" => $alt_stylesheets
					); 
									
					$my_options[] = array(
						"name" =>  "Body Background Color",
						"desc" => "Pick a background color for the theme (default: #fff).",
						"id" => "body_background",
						"std" => "",
						"type" => "color"
					); 
				
					$my_options[] = array(
						"name" =>  "Footer Background Color",
						"desc" => "Pick a background color for the footer (default: #fff).",
						"id" => "footer_background",
						"std" => "",
						"type" => "color"
					);
									
					$my_options[] = array(
						"name" => "Body Font",
						"desc" => "Specify the body font properties",
						"id" => "body_font",
						"std" => array(
							'size' => '12px',
							'face' => 'arial',
							'style' => 'normal',
							'color' => '#000000'
						),
						"type" => "typography"
					);  
									
					$my_options[] = array(
						"name" => "Custom CSS",
						"desc" => "Quickly add some CSS to your theme by adding it to this block.",
						"id" => "custom_css",
						"std" => "",
						"type" => "textarea"
					);
									
					$my_options[] = array(
						"name" => "Border",
						"desc" => "This is a border specific option.",
						"id" => "border",
						"std" => array(
							'width' => '2',
							'style' => 'dotted',
							'color' => '#444444'
						),
						"type" => "border"
					);             
				                  
					$my_options[] = array(
						"name" => "Upload Basic",
						"desc" => "An image uploader without text input.",
						"id" => "uploader",
						"std" => "",
						"type" => "upload_min"
					);     
				                                
					$my_options[] = array(
						"name" => "Input Text",
						"desc" => "A text input field.",
						"id" => "test_text",
						"std" => "Default Value",
						"type" => "text"
					); 
									
					$url =  ADMIN . 'images/';
					
					$my_options[] = array(
						"name" => "Image Select",
						"desc" => "Use radio buttons as images.",
						"id" => "images",
						"std" => "",
						"type" => "images",
						"options" => array(
							'warning.css' => $url . 'warning.png',
							'accept.css' => $url . 'accept.png',
							'wrench.css' => $url . 'wrench.png'
						)
					);
					
					$my_options[] = array(
						"name" => "Remove elements from the &lt;head&gt; of your theme",
						"desc" => "WordPress automatically adds several items to the head of your theme. Not all of these are necessary and you may disable them by checking the relevant checkbox.",
						"id" => "remove_wp_meta",
						"std" => array("wp_generator"),
					  	"type" => "multicheck",
						"options" => $remove_meta_options
					);
					
					$my_options[] = array(
					"name" => "Hello, Hi, Hey There, Welcome!",
					"desc" => "Firstly, thank you. Thanks so much for buying this theme from Friendly Themes. We've tried to make ".THEMENAME." as easy to use as possible and we thought that you might like a helping hand to get started. We've got 3 options for you:",
					"id" => "first_run_opening_message",
					"std" => "",
					"type" => "message"
				);
					
					*/

?>