<?php

	$wp_load_location_array = array();
	$wp_load_location_array[] = "../../../../../../../wp-load.php";
	$wp_load_location_array[] = "../../../../../../wp-load.php";
	$wp_load_location_array[] = "../../../../../wp-load.php";
	$wp_load_location_array[] = "../../../../wp-load.php";
	$wp_load_location_array[] = "../../../wp-load.php";
	$wp_load_location_array[] = "../../wp-load.php";
	$wp_load_location_array[] = "../wp-load.php";
	
	$wp_load_file_found = false;
	
	foreach($wp_load_location_array as $wp_load_location)
	{
		if(file_exists($wp_load_location))
		{
    		require_once($wp_load_location);
    		$wp_load_file_found = true;
		}
	}
	
	//Uncomment the following 3 lines line if you need to manually set the location of your wp-load.php file
	//$wp_load_location = "PATH/TO/YOUR/WP-LOAD.PHP";
	//require_once($wp_load_location);
	//$wp_load_file_found = true;
	
	if(!$wp_load_file_found)
	{
		//Buggerations - Can't find the wp-load.php file. If this happens, comment out lines 3 - 30 of this file. Then, 
		//you'll need to add: require_once('LOCATION TO YOUR WP-LOAD.PHP FILE')
		wp_die('<h3>Unable to find your wp-load.php file</h3><p>It looks like you have a cunning WordPress setup and, unfortunately, I can not find your wp-load.php file.</p><p>To fix this, please edit the "add_shortcode.php" file which you will find in this theme\'s "/inc/js" folder. Uncomment lines 24, 25 and 26 and edit lines 24 with the location of you wp-load.php file.</p><p>Finally, save the file, then try again. Then, by magic, the world will be a better place. And this shortcode manager will work.</p>');
	}
	

?>

<style type="text/css">
	html
	{
		min-height: 571px;
	}
	
	body
	{
		margin: 0; padding: 15px; background-color: #F1F1F1;color: #999;font: 11px "Lucida Grande", "Helvetica Neue", Helvetica, Arial, sans-serif; line-height: 1.5;
	}
	
	a.cancel-button
	{
		-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;text-decoration: none;display: inline-block;padding: 4px 15px;border: 1px solid rgb(213,213,213);border-bottom-color: rgb(230,226,226);color: #aeaeae;text-shadow: 0 1px 0 white;background: rgb(232,232,232);background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, rgb(243,243,243)),color-stop(1, rgb(230,230,230)));background: -moz-linear-gradient(center top,rgb(243,243,243) 20%,rgb(230,230,230) 100%);-webkit-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5), inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7);-moz-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5),inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7);box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5),inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7);-webkit-background-clip: padding-box;
	}
	
	a.cancel-button:hover
	{
		border: 1px solid rgb(173,173,173);
	}
	
	input.button-primary, a.group_select
	{
		display: inline-block; padding: 4px 15px;border: 1px solid #4081af;border-bottom-color: #20559a;color: white;text-align: center;text-shadow: 0 -1px 0 hsla(0,0%,0%,.3);text-decoration: none;-webkit-border-radius: 15px;-moz-border-radius: 15px;border-radius: 15px;background: rgb(35,127,215);background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, rgb(82,168,232)),color-stop(1, rgb(46,118,207)));background: -moz-linear-gradient(center top,rgb(82,168,232) 20%,rgb(46,118,207) 100%);-webkit-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.3), inset 0 0 2px hsla(0,100%,100%,.3), 0 1px 2px hsla(0, 0%, 0%, .29);-moz-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.3), inset 0 0 2px hsla(0,100%,100%,.3), 0 1px 2px hsla(0, 0%, 0%, .29);box-shadow: inset 0 1px 0 hsla(0,100%,100%,.3), inset 0 0 2px hsla(0,100%,100%,.3), 0 1px 2px hsla(0, 0%, 0%, .29);-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;
	}
	
	input.button-primary:hover, a.group_select:hover
	{
	    background: rgb(0,115,210);
	    background: -webkit-gradient(
	        linear,
	        left top,
	        left bottom,
	        color-stop(.2, rgb(62,158,229)),
	        color-stop(1, rgb(22,102,202))
	    );
	    background: -moz-linear-gradient(
	        center top,
	        rgb(62,158,229) 20%,
	        rgb(22,102,202) 100%
	    );
	    
	    -webkit-background-clip: padding-box;
	}
	
	input.button-primary:active, a.group_select:active
	{
		border-color: #20559a;
    
	    -webkit-box-shadow: inset 0 0 7px hsla(0,0%,0%,.3),
	                        0 1px 0 hsla(0, 100%, 100%, 1);
	    -moz-box-shadow: inset 0 0 7px hsla(0,0%,0%,.3),
	                    0 1px 0 hsla(0, 100%, 100%, 1);
	    box-shadow: inset 0 0 7px hsla(0,0%,0%,.3),
	                0 1px 0 hsla(0, 100%, 100%, 1);
	        
	    -webkit-background-clip: padding-box;
	}
	
	a.disabled
	{
		-webkit-border-radius: 5px;-moz-border-radius: 5px;border-radius: 5px;text-decoration: none;display: inline-block;padding: 4px 15px;border: 1px solid rgb(213,213,213) !important;border-bottom-color: rgb(230,226,226) !important;color: #aeaeae !important;text-shadow: 0 1px 0 white !important;background: rgb(232,232,232) !important;background: -webkit-gradient(linear,left top,left bottom,color-stop(.2, rgb(243,243,243)),color-stop(1, rgb(230,230,230))) !important;background: -moz-linear-gradient(center top,rgb(243,243,243) 20%,rgb(230,230,230) 100%) !important;-webkit-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5), inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7) !important;-moz-box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5),inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7) !important;box-shadow: inset 0 1px 0 hsla(0,100%,100%,.5),inset 0 0 2px hsla(0,100%,100%,.1),0 1px 0 hsla(0, 100%, 100%, .7) !important;-webkit-background-clip: padding-box !important;
	}
	
	div.wrap
	{
		overflow: hidden;
		height: 610px;
	}
	
	ul
	{
		list-style-type: none;
		list-style-position: inside;
		margin: 0;
		padding: 0;
	}
	
	ul li
	{
		float: left;
		margin-right: 3%;
	}
	
	div.as-results ul li
	{
		float: none;
	}
	
	#vertical_tabs, #horizontal_tabs, #accordion, #friendly_slider
	{
		position: relative;
	}
	
	#vert_tabs_details_list,
	#horiz_tabs_details_list,
	#accordion_slide_details, 
	#vert_tabs_details_list,
	#friendly_slider_slide_details
	{
		overflow: hidden;
		margin-top: 15px;
	}
	
	#friendly_slider_slide_details li
	{
		margin-bottom: 10px;
		padding-bottom: 10px;
		border-bottom: 1px solid rgb(230,230,230);
	}
	
	#friendly_slider_slide_details li:first-child
	{
		padding-top: 5px;
		border-top: 1px solid rgb(230,230,230);
	}
	
	#friendly_slider_slide_details li:last-child
	{
		margin-bottom: 20px;
	}
	
	#tab3 ul li
	{
		overflow: hidden;
		margin-bottom: 20px;
	}
	
		.chosen_shortcode_options select
		{
			width: 100px !important;
		}
		
		.chosen_shortcode_options label
		{
			display: block;
			float: left;
			width: 150px;
		}
	
		input.vert_tab_title,
		.vert_tab_subtitle,
		.vert_tab_content,
		#vert_tabs_content_height,
		input.horiz_tab_title,
		.horiz_tab_subtitle,
		.horiz_tab_content,
		#horiz_tabs_content_height,
		.accordion_slide_content,
		#slider_container_width,
		.friendly_slider_content,
		.friendly_slider_link,
		{
			border: 1px solid #DFDFDF;
			-webkit-border-radius: 4px;
			-moz-border-radius: 4px;
			border-radius: 4px;
			color: #666;
			font-size: 12px;
			margin: 4px 0;
			padding: 3px;
			line-height: 15px;
			width: 250px;
			display: block;
		}
		
		#delete-tab-button
		{
			float: right;
			padding: 1px 4px !important;
		}
		
		#add_vert_tab,
		#add_horiz_tab,
		#add_accordion_slide,
		#add_friendly_slide
		{
			position: absolute;
			top: 0;
			right: 0;
		}
	
	/* Tabs Styling */
	ul.tabs {
		margin: 0;
		padding: 0;
		float: left;
		list-style: none;
		height: 32px;
		border-bottom: 1px solid #999;
		border-left: 1px solid #999;
		width: 640px;
	}
	ul.tabs li {
		float: left;
		margin: 0;
		padding: 0;
		height: 31px;
		line-height: 31px;
		border: 1px solid #999;
		border-left: none;
		margin-bottom: -1px;
		background: #e0e0e0;
		overflow: hidden;
		position: relative;
		width: auto;
	}
	ul.tabs li a {
		text-decoration: none;
		color: #000;
		display: block;
		font-size: 1.2em;
		padding: 0 10px;
		border: 1px solid #fff;
		outline: none;
	}
	ul.tabs li a:hover {
		background: #ccc;
	}	
	html ul.tabs li.active, html ul.tabs li.active a:hover  {
		background: #fff;
		border-bottom: 1px solid #fff;
	}
	
	li.selected_items
	{
		float: right !important;
		right: 1px;
		border-left: 1px solid #999 !important;
		border-right: 1px solid #999 !important;
	}
	
	li.selected_items a
	{
		padding-right: 40px !important;
	}
	
	li.selected_items span
	{
		 -moz-border-radius: 5px 5px 5px 5px;
		 -webkit-border-radius: 5px 5px 5px 5px;
		 border-radius: 5px 5px 5px 5px;
	    background: none repeat scroll 0 0 #222;
	    color: white;
	    display: block;
	    font-size: 9px;
	    height: 16px;
	    line-height: 16px;
	    padding: 1px 3px;
	    position: absolute;
	    right: 10px;
	    text-align: center;
	    text-shadow: 0 1px 0 #555555;
	    top: 7px;
	    width: 16px;
	}
	
	.tab_container
	{
		border: 1px solid #999;
		border-top: none;
		clear: both;
		float: left; 
		width: 578px;
		height: 539px;
		background: #fff;
		-moz-border-radius-bottomright: 5px;
		-khtml-border-radius-bottomright: 5px;
		-webkit-border-bottom-right-radius: 5px;
		-moz-border-radius-bottomleft: 5px;
		-khtml-border-radius-bottomleft: 5px;
		-webkit-border-bottom-left-radius: 5px;
		overflow: auto;
	}
	.tab_content
	{
		padding: 0 20px;
		overflow: hidden;
	}
	
	.tab_content .list_of_shortcodes
	{
		width: 28%;
		margin-right: 2%;
		padding: 2%;
		float: left;
		margin-top: 25px;
	}
	
		.tab_content .list_of_shortcodes ol
		{
			margin: 0;
			padding: 0;
			list-style-type: none;
		}
		
			.tab_content .list_of_shortcodes ol li a
			{
				text-decoration: none;
				color: rgb(120,120,120);
				display: block;
				margin-bottom: 10px;
				
			}
			
	p.note
	{
		padding: 10px 0;
		border-top: 1px solid rgb(230,230,230);
		border-bottom: 1px solid rgb(230,230,230);
		margin-top: 40px;
	}
	
	p.main_note
	{
		padding:15px;
		margin: 30px 0;
		border: 1px solid rgb(255,255,255);
		background: rgb(250,250,250);
	}
	
	.tab_content .chosen_shortcode_options
	{
		width: 60%;
		float: left;
		padding: 2%;
		min-height: 460px;
		background: rgb(245,245,245);
		border: 1px solid rgb(200,200,200);
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
		margin-top: 25px;
		color: rgb(40,40,40);
	}
	
	
	#inner_wrap
	{
		overflow: hidden;
	}
	
	#insert_and_cancel
	{
		padding: 10px 0 0;
	}
	
	/* Column Icons */
	.column_radio
	{
		display: none;
	}
	
	.active_shortcode_options p span img
	{
		padding: 4px;
		background: white;
		margin-right: 10px;
		opacity: 0.7;
		-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=70)";
		filter: alpha(opacity = 70);
		zoom: 1;
		-moz-border-radius: 5px;
		-webkit-border-radius: 5px;
		border-radius: 5px;
	}
	
	.active_shortcode_options p span:nth-child(3n) img
	{
		margin-right: 0;
	}
	
	.active_shortcode_options p span img.selected_column
	{
		background: rgb(200,200,200);
	}
	
	.active_shortcode_options p span img:hover
	{
		opacity: 1;
		-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";
		filter: alpha(opacity = 100);
		cursor: pointer;
	}
	
	h3
	{
		font: italic normal normal 18px/24px Georgia,"Times New Roman","Bitstream Charter",Times,serif;
		margin: 0 0 10px 0;
		padding: 0;
		text-shadow: rgba(255, 255, 255, 1) 0 1px 0;
		color: #464646;
	}
	
	input[type="text"]
	{
		border: 1px solid #DFDFDF;
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
		color: #666;
		font-size: 12px;
		margin: 4px 0;
		padding: 3px;
		line-height: 15px;
		width: 175px;
		display: block;
	}
	
	hr
	{
		margin: 15px 0;
		border: 1px dotted #C8C8C8;
		color: white;
		line-height: 1;
	}
	
	/* Column Icons */
	
</style>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>

<script type="text/javascript">
	
	function fg_create_shortcode(){
			
			var chosen_shortcode_type = jQuery("a.chosen_type").attr("title");
			
			if(chosen_shortcode_type == "separators"){
			
				//Separator options
				var separator_style_choice = jQuery("#separator_style option:selected").attr("value");
				var separator_size_choice = jQuery("#separator_size option:selected").attr("value");
				
				if(separator_style_choice == "default"){
					
					self.parent.send_to_editor('<hr />');
					
				}
				
				if(separator_style_choice == "fancy"){
				
					self.parent.send_to_editor('<p class="shortcode-divider divider-fancy divider-fancy-'+separator_size_choice+'">&nbsp; Divider</p>');
				
				}
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "columns_2"){
			
				//We're on the columns tab, and 2 columns have been selected
				//var two_column_choice = jQuery("#columns_2 input:checked").attr("id");
				self.parent.send_to_editor('<div class="column_container"><div class="one_half"><p>First Column Content</p></div><div class="one_half last"><p>Second Column Content</p></div></div>');
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "columns_3"){
			
				//We're on the columns tab and 3 columns have been selected
				var three_column_choice = jQuery("#columns_3 input:checked").attr("id");
				
				if(three_column_choice == "three_even_columns"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_third"><p>First Column</p></div><div class="one_third"><p>Second Column</p></div><div class="one_third last"><p>Third Column</p></div></div>');
				
				}
				
				if(three_column_choice == "three_cols_double_single"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="two_third"><p>First Column</p></div><div class="one_third last"><p>Second Column</p></div></div>');
				
				}
				
				if(three_column_choice == "three_cols_single_double"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_third"><p>First Column</p></div><div class="two_third last"><p>Second Column</p></div></div>');
				
				}
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "columns_4"){
			
				//We're on the columns tab and 4 columns have been selected
				var four_column_choice = jQuery("#columns_4 input:checked").attr("id");
				
				if(four_column_choice == "four_even_columns"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_quarter"><p>Col 1</p></div><div class="one_quarter"><p>Col 2</p></div><div class="one_quarter"><p>Col 3</p></div><div class="one_quarter last"><p>Col 4</p></div></div>');
				
				}
				
				if(four_column_choice == "four_cols_single_single_double"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_quarter"><p>Col 1</p></div><div class="one_quarter"><p>Col 2</p></div><div class="one_half last"><p>Col 3</p></div></div>');
				
				}
				
				if(four_column_choice == "four_cols_single_double_single"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_quarter"><p>Col 1</p></div><div class="one_half"><p>Col 2</p></div><div class="one_quarter last"><p>Col 3</p></div></div>');
				
				}
				
				if(four_column_choice == "four_cols_double_single_single"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_half"><p>Col 1</p></div><div class="one_quarter"><p>Col 2</p></div><div class="one_quarter last"><p>Col 3</p></div></div>');
				
				}
				
				if(four_column_choice == "four_cols_single_triple"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_quarter"><p>Col 1</p></div><div class="three_quarter last"><p>Col 2</p></div></div>');
				
				}
				
				if(four_column_choice == "four_cols_triple_single"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="three_quarter"><p>Col 1</p></div><div class="one_quarter last"><p>Col 2</p></div></div>');
				
				}
			
			}
		
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "columns_5"){
			
				//We're on the columns tab and 5 columns have been selected
				var five_column_choice = jQuery("#columns_5 input:checked").attr("id");
				
				if(five_column_choice == "five_even_columns"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_fifth">1</div><div class="one_fifth">2</div><div class="one_fifth">3</div><div class="one_fifth">4</div><div class="one_fifth last">5</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_single_single_single_double"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_fifth">1</div><div class="one_fifth">2</div><div class="one_fifth">3</div><div class="two_fifth last">4</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_single_single_double_single"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_fifth">1</div><div class="one_fifth">2</div><div class="two_fifth">3</div><div class="one_fifth last">4</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_single_double_single_single"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_fifth">1</div><div class="two_fifth">2</div><div class="one_fifth">3</div><div class="one_fifth last">4</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_double_single_single_single"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="two_fifth">1</div><div class="one_fifth">2</div><div class="one_fifth">3</div><div class="one_fifth last">4</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_double_single_double"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="two_fifth">1</div><div class="one_fifth">2</div><div class="two_fifth last">3</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_double_double_single"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="two_fifth">1</div><div class="two_fifth">2</div><div class="one_fifth last">3</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_single_double_double"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_fifth">1</div><div class="two_fifth">2</div><div class="two_fifth last">3</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_single_single_triple"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_fifth">1</div><div class="one_fifth">2</div><div class="three_fifth last">3</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_single_triple_single"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_fifth">1</div><div class="three_fifth">2</div><div class="one_fifth last">3</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_triple_single_single"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="three_fifth">1</div><div class="one_fifth">2</div><div class="one_fifth last">3</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_triple_double"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="three_fifth">1</div><div class="two_fifth last">2</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_double_triple"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="two_fifth">1</div><div class="three_fifth last">2</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_quadruple_single"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="four_fifth">1</div><div class="one_fifth last">2</div></div>');
				
				}
				
				if(five_column_choice == "five_cols_single_quadruple"){
				
					self.parent.send_to_editor('<div class="column_container"><div class="one_fifth">1</div><div class="four_fifth last">2</div></div>');
				
				}
			
			}
		
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "dropcaps"){
			
				//Dropcaps have been selected
				var dropcap_size_choice = jQuery("#dropcap_size option:selected").attr("value");
				var selected_content = self.parent.tinyMCE.activeEditor.selection.getContent();
				//self.parent.send_to_editor("");
				//console.log(self.parent.tinyMCE.activeEditor.selection.getContent());
				if(dropcap_size_choice == "default"){
					self.parent.send_to_editor("<span class='dropcap drop_2_lines'>"+ selected_content +"</span>");
				}
				
				if(dropcap_size_choice == "three"){
					self.parent.send_to_editor("<span class='dropcap drop_3_lines'>"+ selected_content +"</span>");
				}
				
				if(dropcap_size_choice == "four"){
					self.parent.send_to_editor("<span class='dropcap drop_4_lines'>"+ selected_content +"</span>");
				}
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "highlights"){
			
				//Highglights selected
				var highglight_type = jQuery("#highlight_style option:selected").attr("value");
				var selected_content = self.parent.tinyMCE.activeEditor.selection.getContent();
				
				if(highglight_type == "black"){
					self.parent.send_to_editor("<span class='highlight black_bg'>"+ selected_content +"</span>");
				}
				
				if(highglight_type == "light_brown"){
					self.parent.send_to_editor("<span class='highlight light_brown_bg'>"+ selected_content +"</span>");
				}
				
				if(highglight_type == "white"){
					self.parent.send_to_editor("<span class='highlight white_bg'>"+ selected_content +"</span>");
				}
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "pullquotes"){
			
				//Pullquotes
				var pullquote_style = jQuery("#pullquote_style option:selected").attr("value");
				var pullquote_position = jQuery("#pullquote_position option:selected").attr("value");
				var pullquote_size = jQuery("#pullquote_size option:selected").attr("value");
				var selected_content = self.parent.tinyMCE.activeEditor.selection.getContent();
				
				var pullquote_classes = "pullquote pullquote_" + pullquote_style + " pullquote_" + pullquote_position + " pullquote_" + pullquote_size;
				
				self.parent.send_to_editor("<span class='"+pullquote_classes+"'>"+ selected_content +"</span>");
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "buttons"){
			
				//Pullquotes
				var button_size = jQuery("#button_size option:selected").attr("value");
				var button_style = jQuery("#button_style option:selected").attr("value");
				var button_text = jQuery("#button_text").attr("value");
				var button_link = jQuery("#button_link").attr("value");
				
				self.parent.send_to_editor("<a href='"+button_link+"' title='"+button_text+"' class='friendlybutton button_"+button_style+" button_"+button_size+"'>"+ button_text +"</a>");
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "other_typography"){
			
				//Snazzy
				var snazzy_headline_text = jQuery("#snazzy_headline_text").attr("value");
				
				self.parent.send_to_editor("<h2 class='snazzy_heading'>"+snazzy_headline_text+"</h2>");
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "vertical_tabs"){

				//There's 3 elements per tab - Title, Sub Title and Content as well as height
				var number_of_tabs = jQuery('#vert_tabs_details_list li').length;
				var height_of_tabs_container = jQuery('#vert_tabs_content_height').attr('value');
				
				var tab_titles = "";
				var tab_subtitles = "";
				var tab_content = "";

				
				if(number_of_tabs > 0){
				
					for(i=1;i<=number_of_tabs;i++){
						
						var tab_titles_pre = jQuery('#vert_tabs_details_list li#vert-tab-'+i+' .vert_tab_title').attr('value');
						var tab_subtitles_pre = jQuery('#vert_tabs_details_list li#vert-tab-'+i+' .vert_tab_subtitle').attr('value');
						tab_titles += '<li><a href="#v_content_'+i+'" id="v_tab_'+i+'" class="tab">'+tab_titles_pre+'<span>'+tab_subtitles_pre+'</span></a></li> ';
						
						var tab_content_pre = jQuery('#vert_tabs_details_list li#vert-tab-'+i+' .vert_tab_content').val();
						tab_content += '<div id="v_content_'+i+'" class="tab_view">'+tab_content_pre+'</div>';

				
					}
				
					self.parent.send_to_editor('<div id="tabs_vertical" class="friendly_themes_tabs tabs-size-'+height_of_tabs_container+' tabs-vertical"><div id="v_tabs_container"><a href="#prev" class="prev"></a><a href="#next" class="next"></a><div class="slide_container"><ul class="tabs">'+tab_titles+'</ul></div></div><div id="v_content"> <div class="view_container">'+tab_content+'</div></div></div>');

				
				}
				
			
			}
			
			if(chosen_shortcode_type == "horizontal_tabs"){
			
				//2 elements per tab, as well as the width
				var number_of_tabs = jQuery('#horiz_tabs_details_list li').length;
				var width_of_tabs_container = jQuery('#horiz_tabs_content_height').attr('value');
				
				var tab_titles = "";
				var tab_content = "";
				
				if(number_of_tabs > 0){
				
					for(i=1;i<=number_of_tabs;i++){
						
						var tab_titles_pre = jQuery('#horiz_tabs_details_list li#horiz-tab-'+i+' .horiz_tab_title').attr('value');
						tab_titles += '<li><a href="#content_'+i+'" id="tab_'+i+'" class="tab">'+tab_titles_pre+'</a></li> ';
						
						var tab_content_pre = jQuery('#horiz_tabs_details_list li#horiz-tab-'+i+' .horiz_tab_content').val();
						tab_content += '<div id="content_'+i+'" class="tab_view">'+tab_content_pre+'</div>';

				
					}
				
					self.parent.send_to_editor('<div id="tabs_horizontal" class="friendly_themes_tabs tabs-size-'+width_of_tabs_container+' tabs-horizontal"><a href="#prev" class="prev"></a><div id="tabs_container"><ul class="tabs">'+tab_titles+'</ul></div><a href="#next" class="next"></a><div id="content"><div class="view_container">'+tab_content+'</div></div></div>');

				
				}
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "accordion"){
			
				var number_of_sliders = jQuery('#accordion_slide_details li').length;
				
				var this_slide = "";
				var slide_container_width = jQuery('#slider_container_width').attr("value");
				var slide_container_height = jQuery('#slider_container_height').attr("value");
				var slide_autoplay = jQuery('#slider_autoplay option:selected').attr("value");
				
				if(number_of_sliders > 0){
				
					for(i=1;i<=number_of_sliders;i++){
					
						var slide_titles_pre = jQuery('li#accordion-slide-'+i+' .accordion_slab_title').attr('value');
						
						var slide_content_pre = jQuery('li#accordion-slide-'+i+' .accordion_slide_content').val();
						
						this_slide += '<li><h2><span>'+slide_titles_pre+'</span></h2><div><div class="slider_inner">'+slide_content_pre+'</div></div></li>';
					
					}
					
					self.parent.send_to_editor('<div class="accordion friendly_accordion width-'+slide_container_width+' height-'+slide_container_height+' autoplay-'+slide_autoplay+'"><ol>'+this_slide+'</ol></div>');
				
				}
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "map"){
			
				var map_destination_address = jQuery('#map_destination_address').attr("value");
				var map_size = jQuery('#map_size option:selected').attr("value");
			
				self.parent.send_to_editor('[map destination="'+map_destination_address+'" size="'+map_size+'"]');
				
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "twitter_updates"){
			
				var twitter_username = jQuery("#twitter_update_screenname").attr("value");
				var twitter_num_updates = jQuery("#twitter_update_amount").attr("value");
				
				self.parent.send_to_editor('[twitter_status screenname="'+twitter_username+'" count="'+twitter_num_updates+'"]');
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */
			
			if(chosen_shortcode_type == "empty_line"){
			
				var empty_line_text = jQuery("#empty_line_text").attr("value");
				
				self.parent.send_to_editor('<p class="empty_line">'+empty_line_text+'</p>');
			
			}
			
			/* ---------------------------------------------------------------------------------------- */
			/* ---------------------------------------------------------------------------------------- */

		
	}/* fg_create_shortcode() */
	
	jQuery(document).ready(function() {
 
		//Default Action
		jQuery(".tab_content").hide(); //Hide all content
		jQuery("ul.tabs li:first").addClass("active").show(); //Activate first tab
		jQuery(".tab_content:first").show(); //Show first tab content
		
		//On Click Event
		jQuery("ul.tabs li").click(function() {
			jQuery("ul.tabs li").removeClass("active"); //Remove any "active" class
			jQuery(this).addClass("active"); //Add "active" class to selected tab
			jQuery(".tab_content").hide(); //Hide all tab content
			var activeTab = jQuery(this).find("a").attr("href"); //Find the rel attribute value to identify the active tab + content
			jQuery(activeTab).fadeIn(); //Fade in the active content
			return false;
		});
		
		/* End tabs behaviour */
		
		/* Shortcode Options */
		jQuery(".chosen_shortcode_options div").hide();
		
		jQuery("a.shortcode_choice").click(function(){
		
			jQuery("a.shortcode_choice").removeClass("chosen_type");
			jQuery(this).addClass("chosen_type");
		
			jQuery(".chosen_shortcode_options div").removeClass("active_shortcode_options").hide();
			var tab_name = jQuery(this).attr("href");
			jQuery(tab_name).show().addClass("active_shortcode_options");
		
		});
		
		/* Layout column icons */
		jQuery(".of-radio-img-img").click(function(){
		
			jQuery(".column_radio").attr("checked","");
			jQuery(".selected_column").removeClass("selected_column");
			var this_title = jQuery(this).attr("title");

			jQuery("input#"+this_title).attr("checked","checked");
			jQuery(this).addClass("selected_column");
		
		});
		
		
		jQuery('#add_vert_tab').click(function(){
				
			//We're adding another vertical tab. First count the number we have already
			var number_of_tabs = jQuery('#vert_tabs_details_list li').length;
			var one_more = number_of_tabs+1;
			
			//Add the markup for another tab
			jQuery('#vert_tabs_details_list').append("<li id='vert-tab-"+ one_more +"' class='vert_tab_info'><input class='vert_tab_title' id='vert-title-"+ one_more +"' type='text' value='Title "+one_more+"' /><input class='vert_tab_subtitle' id='vert-subtitle-"+ one_more +"' type='text' value='Subtitle "+one_more+"' /><textarea id='vert-content-"+ one_more +"' class='vert_tab_content'>Place your content for tab "+ one_more +" here</textarea><a class='cancel-button delete-tab-button' id='remove_tab_vert-"+ one_more +"' onclick='fg_remove_this_tab(this)'>x</a></li>");
			
		});
		
		jQuery('#add_horiz_tab').click(function(){
				
			//We're adding another vertical tab. First count the number we have already
			var number_of_tabs = jQuery('#horiz_tabs_details_list li').length;
			var one_more = number_of_tabs+1;
			
			//Add the markup for another tab
			jQuery('#horiz_tabs_details_list').append("<li id='horiz-tab-"+ one_more +"' class='horiz_tab_info'><input class='horiz_tab_title' id='horiz-title-"+ one_more +"' type='text' value='Title "+one_more+"' /><textarea id='horiz-content-"+ one_more +"' class='horiz_tab_content'>Place your content for tab "+ one_more +" here</textarea><a class='cancel-button delete-tab-button' id='remove_tab_horiz-"+ one_more +"' onclick='fg_remove_this_tab(this)'>x</a></li>");
			
		});
		
		jQuery('#add_accordion_slide').click(function(){
		
			//We're adding a slide for an accordion
			var number_of_sliders = jQuery('#accordion_slide_details li').length;
			var one_more = number_of_sliders+1;
			
			jQuery('#accordion_slide_details').append("<li id='accordion-slide-"+one_more+"' class='accordion_slide_info'><input class='accordion_slab_title' id='accordion-slide-title-"+ one_more +"' type='text' value='Title "+one_more+"' /><textarea id='accordion-slide-content-"+ one_more +"' class='accordion_slide_content'>Place your content for slide "+ one_more +" here</textarea><a class='cancel-button delete-slide-button' id='remove_slide-"+ one_more +"' onclick='fg_remove_this_tab(this)'>x</a></li>");
		
		});
		
		jQuery('#add_friendly_slide').click(function(){
		
			//We're adding a slide for an accordion
			var number_of_sliders = jQuery('#friendly_slider_slide_details li').length;
			var one_more = number_of_sliders+1;
			
			jQuery('#friendly_slider_slide_details').append("<li id='friendly-slider-slide-"+one_more+"' class='friendly_slider_slide_info'><label for='friendly-slider-slide-content-"+ one_more +"'>Image URL:</label><input type='text' id='friendly-slider-slide-content-"+ one_more +"' class='friendly_slider_content' value='http://dummyimage.com/672x360/888/fff&amp;text=+SLIDE-#-"+one_more+"' /><label for='friendly-slider-link-"+ one_more +"'>Link URL:</label><input class='friendly_slider_link' id='friendly-slider-link-"+ one_more +"' type='text' value='http://www.google.com/' /><a class='cancel-button delete-slide-button' id='remove_slide-"+ one_more +"' onclick='fg_remove_this_tab(this)'>x</a></li>");
		
		});
	 
	});
	
	function fg_remove_this_tab(which){
	
		jQuery(which).parent().fadeOut('slow', function(){
			jQuery(which).parent().remove();
		});
	
	}
	

</script>


<div id="select_form">
    
    <div class="wrap">
    
    	<div id="inner_wrap">
    	
    		<ul class="tabs"> 
		        <li><a href="#tab1"><?php _e("Typography", THEMENAME); ?></a></li> 
		        <li><a href="#tab2"><?php _e("Columns", THEMENAME); ?></a></li> 
		        <li><a href="#tab3"><?php _e("Tabs", THEMENAME); ?></a></li> 
		        <li><a href="#tab5"><?php _e("Widgets", THEMENAME); ?></a></li>
		        <li><a href="#tab6"><?php _e("Other", THEMENAME); ?></a></li>
		    </ul> 
		    
		    
		    <div class="tab_container">
		    
		    	
		    	<div class="tab_content" id="tab1">
		    		
		    		<div class="list_of_shortcodes">
		    		
		    			<ol>
		    				<li>
		    					<a class="shortcode_choice" href="#separators" title="separators">Dividers</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#dropcaps" title="dropcaps">Dropcaps</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#highlights" title="highlights">Highlights</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#pullquotes" title="pullquotes">Pull Quotes</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#buttons" title="buttons">Buttons</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#other_typography" title="other_typography">Other</a>
		    				</li>
		    			</ol>
		    		
		    		</div><!-- .list_of_shortcodes -->
		    		
		    		<div class="chosen_shortcode_options">
		    		
		    			<div id="separators">
		    			
		    				<h3>Style</h3>
		    				<select id="separator_style">
		    					<option value="fancy">Fancy</option>
		    					<option value="default">Default (Horizontal Rule)</option>
		    				</select>
		    				
		    				<h3>Size</h3>
		    				<select id="separator_size">
		    					<option value="full">Full Width</option>
		    					<option value="half">Half Width</option>
		    				</select>
		    			
		    			</div><!-- #separators -->
		    			
		    			<div id="dropcaps">
		    			
		    				<h3>Size</h3>
		    				<select id="dropcap_size">
		    					<option value="default">2 Lines High</option>
		    					<option value="three">3 Lines High</option>
		    					<option value="four">4 Lines High</option>
		    				</select>
		    				
		    				<p class="main_note">Hint: You need to have already selected a character to use as a drop cap to be able to use this feature. So, if you haven't, close this window (press cancel in the bottom right), highlight the first character from the sentence you wish to dropcap, and return to this window to select your options.</p>
		    			
		    			</div><!-- #separators -->
		    			
		    			<div id="highlights">
		    			
		    				<h3>Highlight Style</h3>
		    				<select id="highlight_style">
		    					<option value="black">High Contrast</option>
		    					<option value="light_brown">Light Brown</option>
		    					<option value="white">White</option>
		    				</select>
		    			
		    			</div><!-- #highlights -->
		    			
		    			<div id="pullquotes">
		    			
		    				<h3>Pullquote Style</h3>
		    				<select id="pullquote_style">
		    					<option value="default">Standard</option>
		    					<option value="high_contrast">High Contrast</option>
		    					<option value="white">White</option>
		    				</select>
		    				
		    				<h3>Pullquote Position</h3>
		    				<select id="pullquote_position">
		    					<option value="left">Left</option>
		    					<option value="right">Right</option>
		    				</select>
		    				
		    				<h3>Pullquote Size</h3>
		    				<select id="pullquote_size">
		    					<option value="one_quarter">One Quarter</option>
		    					<option value="half">Half Width</option>
		    					<option value="three_quarters">Three Quarters</option>
		    					<option value="full">Full Width</option>
		    				</select>
		    				
		    				<p class="main_note">Hint: You need to have already selected some content to use as a pull quote to be able to use this feature. So, if you haven't, close this window (press cancel in the bottom right), highlight the content you wish to use, and return to this window to select your options.</p>
		    			
		    			</div><!-- #pullquotes -->
		    			
		    			<div id="buttons">
		    			
		    				<h3>Button Size</h3>
		    				<select id="button_size">
		    					<option value="small">Small</option>
		    					<option value="medium">Medium</option>
		    					<option value="large">Large</option>
		    				</select>
		    				
		    				<hr />
		    				
		    				<h3>Button Style</h3>
		    				<select id="button_style">
		    					<option value="apple_style">Apple Style</option>
		    					<option value="simple">Simple</option>
		    					<option value="dark">Dark</option>
		    					<option value="contrast">Contrast</option>
		    				</select>
		    				
		    				<hr />
		    				
		    				<h3>Button Text</h3>
		    				<input type="text" value="Button Text" id="button_text" />
		    				
		    				<hr />
		    				
		    				<h3>Button Link</h3>
		    				<input type="text" value="http://www.google.com/" id="button_link" />
		    			
		    			</div><!-- #buttons -->
		    			
		    			<div id="other_typography">
		    			
		    				<h3>Snazzy Headlines</h3>
		    				<input type="text" value="Snazzy Headline" id="snazzy_headline_text" />
		    			
		    			</div><!-- #other_typography -->
		    		
		    		</div><!-- .chosen_shortcode_options -->
		    		
		    	</div><!-- .tab_content -->
		    	
		    	
		    	<div class="tab_content" id="tab2">
		    		
		    		<div class="list_of_shortcodes">
		    		
		    			<ol>
		    				<li>
		    					<a class="shortcode_choice" href="#columns_2" title="columns_2">2 Columns</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#columns_3" title="columns_3">3 Columns</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#columns_4" title="columns_4">4 Columns</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#columns_5" title="columns_5">5 Columns</a>
		    				</li>
		    			</ol>
		    		
		    		</div><!-- .list_of_shortcodes -->
		    		
		    		<div class="chosen_shortcode_options">
		    		
		    			<div id="columns_2">
		    			
		    				<h3>2 Column Layout</h3>
		    				<p>
		    					Selecting the checkbox below and pressing 'insert shortcode' below will provide you with 2 columns in the editor.
		    				</p>
		    				<p>
		    					<span>
		    						<input type="radio" name="layout" value="2_columns_selected" class="column_radio" id="2_columns_selected" />
		    					
		    						<img title="2_columns_selected" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/two-cols-11.png" />
		    					</span>
		    				</p>
		    			
		    			</div><!-- #columns_2 -->
		    			
		    			<div id="columns_3">
		    			
		    				<h3>3 Column Layouts</h3>
		    				<p>
		    					Please choose from one of the three-column layouts by clicking on an image below and then pressing 'Insert Shortcode'.
		    				</p>
		    				<p>&nbsp;</p>

		    				<p>
		    					<span>
		    						<input type="radio" name="layout" value="three_even_columns" class="column_radio" id="three_even_columns" />
		    					
		    						<img title="three_even_columns" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/three-cols-111.png" />
		    					</span>

		    					<span>
		    						<input type="radio" name="layout" value="three_cols_double_single" class="column_radio" id="three_cols_double_single" />
		    					
		    						<img title="three_cols_double_single" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/three-cols-21.png" />
		    					</span>

		    					<span>
		    						<input type="radio" name="layout" value="three_cols_single_double" class="column_radio" id="three_cols_single_double" />
		    					
		    						<img title="three_cols_single_double" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/three-cols-12.png" />
		    					</span>
		    				</p>
		    			
		    			</div><!-- #columns_3 -->
		    			
		    			<div id="columns_4">
		    			
		    				<h3>4 Column Layout</h3>
		    				
		    				<p>
		    					<span>
		    						<input type="radio" name="layout" value="four_even_columns" class="column_radio" id="four_even_columns" />
		    					
		    						<img title="four_even_columns" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/four-cols-1111.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="four_cols_single_single_double" class="column_radio" id="four_cols_single_single_double" />
		    					
		    						<img title="four_cols_single_single_double" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/four-cols-112.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="four_cols_single_double_single" class="column_radio" id="four_cols_single_double_single" />
		    					
		    						<img title="four_cols_single_double_single" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/four-cols-121.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="four_cols_double_single_single" class="column_radio" id="four_cols_double_single_single" />
		    					
		    						<img title="four_cols_double_single_single" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/four-cols-211.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="four_cols_single_triple" class="column_radio" id="four_cols_single_triple" />
		    					
		    						<img title="four_cols_single_triple" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/four-cols-13.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="four_cols_triple_single" class="column_radio" id="four_cols_triple_single" />
		    					
		    						<img title="four_cols_triple_single" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/four-cols-31.png" />
		    					</span>
		    				</p>
		    			
		    			</div><!-- #columns_4 -->
		    			
		    			<div id="columns_5">
		    			
		    				<h3>5 Column Layout</h3>
		    				<p>
		    					<span>
		    						<input type="radio" name="layout" value="five_even_columns" class="column_radio" id="five_even_columns" />
		    					
		    						<img title="five_even_columns" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-11111.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_single_single_single_double" class="column_radio" id="five_cols_single_single_single_double" />
		    					
		    						<img title="five_cols_single_single_single_double" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-1112.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_single_single_double_single" class="column_radio" id="five_cols_single_single_double_single" />
		    					
		    						<img title="five_cols_single_single_double_single" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-1121.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_single_double_single_single" class="column_radio" id="five_cols_single_double_single_single" />
		    					
		    						<img title="five_cols_single_double_single_single" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-1211.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_double_single_single_single" class="column_radio" id="five_cols_double_single_single_single" />
		    					
		    						<img title="five_cols_double_single_single_single" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-2111.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_double_single_double" class="column_radio" id="five_cols_double_single_double" />
		    					
		    						<img title="five_cols_double_single_double" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-212.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_double_double_single" class="column_radio" id="five_cols_double_double_single" />
		    					
		    						<img title="five_cols_double_double_single" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-221.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_single_double_double" class="column_radio" id="five_cols_single_double_double" />
		    					
		    						<img title="five_cols_single_double_double" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-122.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_single_single_triple" class="column_radio" id="five_cols_single_single_triple" />
		    					
		    						<img title="five_cols_single_single_triple" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-113.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_single_triple_single" class="column_radio" id="five_cols_single_triple_single" />
		    					
		    						<img title="five_cols_single_triple_single" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-131.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_triple_single_single" class="column_radio" id="five_cols_triple_single_single" />
		    					
		    						<img title="five_cols_triple_single_single" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-311.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_triple_double" class="column_radio" id="five_cols_triple_double" />
		    					
		    						<img title="five_cols_triple_double" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-32.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_double_triple" class="column_radio" id="five_cols_double_triple" />
		    					
		    						<img title="five_cols_double_triple" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-23.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_quadruple_single" class="column_radio" id="five_cols_quadruple_single" />
		    					
		    						<img title="five_cols_quadruple_single" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-41.png" />
		    					</span>
		    					<span>
		    						<input type="radio" name="layout" value="five_cols_single_quadruple" class="column_radio" id="five_cols_single_quadruple" />
		    					
		    						<img title="five_cols_single_quadruple" class="of-radio-img-img" alt="" src="<?php echo get_stylesheet_directory_uri(); ?>/admin/images/five-cols-14.png" />
		    					</span>
		    				</p>
		    			
		    			</div><!-- #columns_5 -->
		    		
		    		</div><!-- .chosen_shortcode_options -->

		    	</div><!-- .tab_content -->
		    	
		    	
		    	<div class="tab_content" id="tab3">
		    		
		    		<div class="list_of_shortcodes">
		    		
		    			<ol>
		    				<li>
		    					<a class="shortcode_choice" href="#vertical_tabs" title="vertical_tabs">Vertical</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#horizontal_tabs" title="horizontal_tabs">Horizontal</a>
		    				</li>
		    			</ol>
		    			
		    			<p class="note"><span>Note: </span> In your WordPress editor, we're unable to show you <em>precisely</em> how this will look on your site - we have to select default sizes. However, your chosen height/width will be used on your public facing site</em></p>
		    		
		    		</div><!-- .list_of_shortcodes -->
		    		
		    		<div class="chosen_shortcode_options">
		    		
		    			<div id="vertical_tabs">
		    			
		    				<h3>Vertical Tabs</h3>
		    				
		    					<ul id="vert_tabs_details_list" class="tabs_details_list">
		    					
		    					</ul><!-- #vert_tabs_details_list -->
		    					
		    					<p>
		    						<label for="vert_tabs_content_height"><?php _e("Height of Container: (px)", THEMENAME); ?>&nbsp;</label><input type="text" value="300" id="vert_tabs_content_height" />
		    					</p>
		    				
		    					<input type="button" id="add_vert_tab" class="button-primary" value="+ <?php _e("Add Tab", THEMENAME); ?>" />		    				
		    			
		    			</div><!-- #vertical -->
		    			
		    			<div id="horizontal_tabs">
		    			
		    				<h3>Horizontal Tabs</h3>
		    				
		    				<ul id="horiz_tabs_details_list" class="tabs_details_list">
		    					
							</ul><!-- #vert_tabs_details_list -->
		    					
	    					<p>
	    						<label for="horiz_tabs_content_height"><?php _e("Width of Container: (px)", THEMENAME); ?>&nbsp;</label><input type="text" value="620" id="horiz_tabs_content_height" />
	    					</p>
	    				
	    					<input type="button" id="add_horiz_tab" class="button-primary" value="+ <?php _e("Add Tab", THEMENAME); ?>" />
		    			
		    			</div><!-- #horizontal -->
		    		
		    		</div><!-- .chosen_shortcode_options -->
		    		
		    	</div><!-- .tab_content -->
		    	
		    	
		    	<div class="tab_content" id="tab5">
		    		
		    		<div class="list_of_shortcodes">
		    			
		    			<p class="note"><span>Note: </span> Coming Soon - the ability to add some of your widgets into your posts/pages as content. This will be a free upgrade when we release this feature.</em></p>
		    		
		    		</div><!-- .list_of_shortcodes -->
		    		
		    		<div class="chosen_shortcode_options">
		    		
		    		</div><!-- .chosen_shortcode_options -->
		    		
		    	</div><!-- .tab_content -->
		    	
		    	<div class="tab_content" id="tab6">
		    		
		    		<div class="list_of_shortcodes">
		    		
		    			<ol>
		    				<li>
		    					<a class="shortcode_choice" href="#accordion" title="accordion">Accordion</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#map" title="map">Map with Directions</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#twitter_updates" title="twitter_updates">Latest twitter updates</a>
		    				</li>
		    				<li>
		    					<a class="shortcode_choice" href="#empty_line" title="empty_line">Empty Line</a>
		    				</li>
		    			</ol>
		    			
		    			<p class="note"><span>Note: </span> Some of these items will only insert the shortcode rather than content. Because of the editor that WordPress uses, in some cases, it is impossible to load dynamic content such as a live twitter feed or map. We're trying really hard to work around this and, of course, if we manage it, it will be a free upgrade.</em></p>
		    		
		    		</div><!-- .list_of_shortcodes -->
		    		
		    		<div class="chosen_shortcode_options">
		    		
		    			<div id="accordion">
		    			
		    				<h3>Accordion</h3>
		    			
			    			<ul id="accordion_slide_details">
			    			
			    			</ul>
			    			
			    			<p>
		    					<label for="slider_container_width"><?php _e("Width of Container: (px)", THEMENAME); ?>&nbsp;</label><input type="text" value="672" id="slider_container_width" />
		    				</p>
		    				
		    				<p>
		    					<label for="slider_container_height"><?php _e("Height of Container: (px)", THEMENAME); ?>&nbsp;</label><input type="text" value="320" id="slider_container_height" />
		    				</p>
		    				
		    				<p>
		    					<label for="slider_autoplay"><?php _e("Slider Autoplay", THEMENAME); ?>&nbsp;</label>
		    					<select id="slider_autoplay">
			    					<option value="false">False</option>
			    					<option value="true">True</option>
			    				</select>
		    				</p>
			    			
			    			<input type="button" id="add_accordion_slide" class="button-primary" value="+ <?php _e("Add Slide", THEMENAME); ?>" />
		    			
		    			</div><!-- #accordion -->
		    			
		    			<div id="map">
		    			
		    				<h3>Map</h3>
		    				<p>
		    					<?php _e("Please enter the address you would like people to be directed towards. i.e. your address or your business address.", THEMENAME); ?>
		    				</p>
		    				<p>
		    					<label for="map_destination_address"><?php _e("Destination: ", THEMENAME); ?>&nbsp;</label><input type="text" value="1 Infinite Loop, Cupertino, CA, United States" id="map_destination_address" />
		    				</p>
		    				<p>
		    					<label for="map_size"><?php _e("Size", THEMENAME); ?>&nbsp;</label>
		    					<select id="map_size">
			    					<option value="small">Small</option>
			    					<option value="large">Large</option>
			    				</select>
		    				</p>
		    			
		    			</div><!-- #map -->
		    			
		    			<div id="twitter_updates">
		    			
		    				<h3>Latest Twitter Updates</h3>
		    				<p>
		    					<label for="twitter_update_screenname"><?php _e("Twitter Username: ", THEMENAME); ?>&nbsp;</label><input type="text" value="friendlythemes" id="twitter_update_screenname" />
		    				</p>
		    				<p>
		    					<label for="twitter_update_amount"><?php _e("Number Of Updates: ", THEMENAME); ?>&nbsp;</label><input type="text" value="3" id="twitter_update_amount" />
		    				</p>
		    			
		    			</div><!-- #twitter_updates -->
		    			
		    			<div id="empty_line">
		    			
		    				<h3>Empty Line</h3>
		    				<p>
		    					<?php _e("An empty line is often useful when you wish to line things up in a multi-column layout, but WordPress' WYSIWYG editor sometimes deletes them. The text you enter below will be a placeholder text and wont be shown, but is often seen by screenreaders.", THEMENAME); ?>
		    				</p>
		    				<p>
		    					<label for="empty_line_text"><?php _e("Placeholder Text: ", THEMENAME); ?>&nbsp;</label><input type="text" value="empty line" id="empty_line_text" />
		    				</p>
		    			
		    			</div><!-- #empty_line -->
		    		
		    		</div><!-- .chosen_shortcode_options -->
		    		
		    	</div><!-- .tab_content -->
		    
		    </div><!-- .tab_container -->
    	
    	</div><!-- #inner_wrap  -->
    	
	    <div id="insert_and_cancel">
                
            <div style="float: left;">
            	<input type="button" class="button-primary" value="<?php _e("Insert Shortcode", THEMENAME); ?>" onclick="fg_create_shortcode();"  />
            </div>
            
            <div style="float: right;">
            	<a class="cancel-button" href="#" onclick="self.parent.tb_remove(); return false;"><?php _e("Cancel", THEMENAME); ?></a>
            </div>
            
        </div>
    
        
    </div><!-- .wrap -->
    
</div><!-- #select_form -->