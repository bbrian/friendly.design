<?php

/*
// TEMP: Enable update check on every request. Normally you don't need this! This is for testing only! */
//set_site_transient('update_themes', null);

add_filter('pre_set_site_transient_update_themes', 'check_for_update');

if(!function_exists('check_for_update')) :

	function check_for_update($checked_data)
	{
		
		global $wp_version;
		
		$data = get_option(OPTIONS);
		$api_key = (array_key_exists('friendly_api_key',$data)) ? $data['friendly_api_key'] : false;
		
		
		if (empty($checked_data->checked))
			return $checked_data;
	
		
		$api_url = 'http://friendlythem.es/api/api.php';
		$theme_base = basename(dirname(dirname(__FILE__)));
		
		$themedata = get_theme_data(STYLESHEETPATH . '/style.css');
		$theme_version = $themedata['Version'];
		$theme_name = $themedata['Name'];
		
		$request = array(
			'slug' => $theme_name,
			'version' => $theme_version
		);
		
		//var_dump($request);
		
		// Start checking for an update
		$send_for_check = array(
			'body' => array(
				'action' => 'theme_update', //theme_update
				'request' => serialize($request),
				'api-key' => md5($api_key)
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
		
		//var_dump($send_for_check);
	
		$raw_response = wp_remote_post($api_url, $send_for_check);
		
		//var_dump($raw_response);
		
		if (!is_wp_error($raw_response) && ($raw_response['response']['code'] == 200))
			$response = unserialize($raw_response['body']);
			
		// Feed the update data into WP updater
		if (!empty($response)) 
		{
			$checked_data->response[$theme_name] = $response;
		}
		
		return $checked_data;
		
	}/* check_for_update() */

endif;


if (is_admin())
	$current = get_transient('update_themes');

?>