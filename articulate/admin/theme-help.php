<?php

	global $my_options;
	if(!defined('THEMENAME'))
	{
		$themedata = get_theme_data(STYLESHEETPATH . '/style.css');
		define('THEMENAME', $themedata['Name']);	
	}

	$my_options[] = array(
		"name" => __("Why can't I see the Sidebar Control box on my pages/posts?",THEMENAME),
		"desc" => __("WordPress may have 'hidden' this control box. To enable it, click on 'Screen Options' in the top right hand corner when you edit a post or page and some options will slide down - enable the sidebar management box by ticking the appropriate option.",THEMENAME),
		"id" => "faq_q_1",
		"std" => "",
		"type" => "help-question"
	);
	
	$my_options[] = array(
		"name" => __("When will you update this theme?",THEMENAME),
		"desc" => __("We are aiming to be one of the most active theme authors on the marketplace and as such will be updating our themes with new features, improved help files, new fonts and bugfixes on a very regular basis. You'll be notified automatically when we launch a new version - a new menu item will appear called 'update' with information about what's in the new version.",THEMENAME),
		"id" => "faq_q_2",
		"std" => "",
		"type" => "help-question"
	);
		
	$my_options[] = array(
		"name" => __("How do I disabled the bar at the very top of the page?",THEMENAME),
		"desc" => __("The WordPress admin bar is useful to some and unhelpful to others. If you don't wish to have it, then simply visit your profile page by going to Users > Your Profile and then unchecking the boxes next to the two admin bar options.",THEMENAME),
		"id" => "faq_q_3",
		"std" => "",
		"type" => "help-question"
	);
	
	$my_options[] = array(
		"name" => __("How long will it take for you to respond to my e-mail/support question?",THEMENAME),
		"desc" => __("We will literally be with you as soon as we possibly can. We normally get back to people within 24 hours, even if it's to tell them how long we'll be. Normally, it takes us about 2 days to have your question answered, but it might take a few more if we're inundated with questions or if your query is particularly tricky. Be rest assured - we <strong>will get back to you</strong>",THEMENAME),
		"id" => "faq_q_4",
		"std" => "",
		"type" => "help-question"
	);
	
	$my_options[] = array(
		"name" => __("How do I set up the e-mail signup form like you have in my footer and holding page?",THEMENAME),
		"desc" => __("We use the mailchimp plugin. Mailchimp is amazing - quite simply the best e-mail subscription and management service we've ever used. You can create the most amazing campaigns with incredible ease and get incredible statistics about how many people read your e-mails and what they do with them. You'll find the plugin in the 'plugins' folder of the zip file you downloaded. Go ahead and install that and visit 'Settings > Mailchimp Setup' to set yourself up. Once you've done that go to 'Appearance > Widgets' and drag the MailChimp widget into your 'Footer Row 1' or 'Holding Page Widget Area and you're set!",THEMENAME),
		"id" => "faq_q_5",
		"std" => "",
		"type" => "help-question"
	);
	
	$my_options[] = array(
		"name" => __("How do I get the 'live search' to work?",THEMENAME),
		"desc" => __("We're currently using a plugin for this called 'Dave's WordPress Live Search' - you'll find that in your plugins folder of the zip file you downloaded. Go ahead and install that, activate it, then visit 'Settings > Live Search' to set up your options. We prefer waiting for 2 characters and showing a maximum of 5 results as well as displaying an excerpt and thumbnail if available. You'll also need to press 'Theme-specific' for the 'Styles' option - we've already coded everything you'll need for that, so you don't have to.",THEMENAME),
		"id" => "faq_q_6",
		"std" => "",
		"type" => "help-question"
	);
	
	$my_options[] = array(
		"name" => __("I'm having trouble with my images not showing or resizing properly",THEMENAME),
		"desc" => __("We try and be as clever as possible with regards to your images, however, in certain circumstances, we might come up short. The resizing script will automatically try and create a 'cache' folder which will be in your theme's 'inc' directory. If it can't create it (because of your server set up), please create it and make sure it has global write privileges - that's 'chmod 0777'. It's also possible the 'inc/' directory will need to have the same privileges. If that still doesn't solve your problems, then get in touch with us : support@friendlythem.es",THEMENAME),
		"id" => "faq_q_7",
		"std" => "",
		"type" => "help-question"
	);
	
	$my_options[] = array(
		"name" => __("I need to update but I am on a slow connection and don't want to download the whole package!",THEMENAME),
		"desc" => __("Our themes come with a large help package as well as lots of PSDs which means they end up being quite big - too big for some people. The last thing we want is for people to be stuck on an earlier version of the theme just because they can't download the latest version. Into all of our themes we've built in a way that for *some* people we're able to allow them to update their theme through the WordPress updater. <strong>Please</strong> do not request this from us if you're on a good connection. If, however, you really feel like you can't update, then send us an e-mail and we'll tell you what to do to enable this functionality.",THEMENAME),
		"id" => "faq_q_8",
		"std" => "",
		"type" => "help-question"
	);

?>