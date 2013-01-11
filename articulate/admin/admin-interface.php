<?php

	/*
		Create the Options_Machine object - optionsframework_admin_init
	*/
	
	if(!function_exists('optionsframework_admin_init')) :

		function optionsframework_admin_init()
		{
				
			// Rev up the Options Machine
			global $my_options, $options_machine;
			$options_machine = new Options_Machine($my_options);
				
				
			//if reset is pressed->replace options with defaults
		    if ( isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework' )
		    {
				if (isset($_REQUEST['of_reset']) && 'reset' == $_REQUEST['of_reset'])
				{
					
					$nonce=$_POST['security'];
		
					if (!wp_verify_nonce($nonce, 'of_ajax_nonce') )
					{ 
						header('Location: themes.php?page=optionsframework&reset=error');
						die('Security Check'); 
					}
					else
					{
						$defaults = (array) $options_machine->Defaults;
						update_option(OPTIONS,$options_machine->Defaults);	
						header('Location: themes.php?page=optionsframework&reset=true');
						die($options_machine->Defaults);
					} 
				}
		    }
		
		}/* optionsframework_admin_init() */
	
	endif;
	
	add_action('admin_init','optionsframework_admin_init');

	/* =========================================================================================== */


	/*
		 Options Framework Admin Interface - optionsframework_add_admin
	*/
	
	if(!function_exists('optionsframework_add_admin')) :

		function optionsframework_add_admin()
		{
			if(!defined('THEMENAME'))
			{
				$themedata = get_theme_data(STYLESHEETPATH . '/style.css');
				define('THEMENAME', $themedata['Name']);
			}
			if( function_exists('is_a_theme_update_available') && is_a_theme_update_available() )
			{
				$of_page = add_theme_page(THEMENAME, __('Theme Options',THEMENAME).'<span class="update-plugins count-1"><span class="update-count">1</span></span>', 'edit_theme_options', 'optionsframework','optionsframework_options_page');
			}
			else
			{
				$of_page = add_theme_page(THEMENAME, __('Theme Options',THEMENAME), 'edit_theme_options', 'optionsframework','optionsframework_options_page'); // Default
			}
		
			// Add framework functionaily to the head individually
			add_action("admin_print_scripts-$of_page", 'of_load_only');
			add_action("admin_print_styles-$of_page",'of_style_only');
			
		}/* optionsframework_add_admin() */
	
	endif;
	
	add_action('admin_menu', 'optionsframework_add_admin');

	/* =========================================================================================== */


	/*
		Build the Options Page - optionsframework_options_page
	*/
	
	if(!function_exists('optionsframework_options_page')) :

		function optionsframework_options_page()
		{
		
			global $options_machine;
			/*
			//for debugging
			$data = get_option(OPTIONS);
			print_r($data);
			*/	
		?>
		
			<div class="wrap" id="of_container">
			
				<div id="of-popup-save" class="of-save-popup">
			
					<div class="of-save-save"><?php _e('Options Updated',THEMENAME); ?></div>
			
				</div><!-- #of-popup-save -->
			
				<div id="of-popup-reset" class="of-save-popup">
				
					<div class="of-save-reset"><?php _e('Options Reset',THEMENAME); ?></div>
				
				</div><!-- #of-popup-reset -->
				
				<div id="of-message-sent" class="of-save-popup">
					<div class="of-save-save"><?php _e("Support Message Sent", THEMENAME); ?></div>
				</div><!-- #of-message-sent -->
				
				<div id="of-popup-fail" class="of-save-popup">
				
					<div class="of-save-fail"><?php _e('It has all gone horribly wrong!<small>&nbsp;Try logging out and logging back in again.</small>',THEMENAME); ?></div>
				
				</div><!-- #of-popup-fail -->
			
				<form id="ofform" method="post" action="<?php echo esc_attr( $_SERVER['REQUEST_URI'] ) ?>" enctype="multipart/form-data" >
				
					<div id="header">
				
						<div class="logo">
				
							<h2><?php echo THEMENAME; ?> <?php _e('Theme Options From',THEMENAME); ?> <?php echo THEME_AUTHOR; ?></h2>
				
						</div><!-- .logo -->
				
						<div id="js-warning"><?php _e('Warning- This options panel will not work properly without javascript',THEMENAME); ?>!</div>
				
						<?php if(defined('THEME_AUTHOR') && THEME_AUTHOR === "Friendly Themes") : ?>
							<div class="icon-option"> </div>
						<?php endif; ?>
				
						<div class="clear"></div>
				
					</div><!-- #header -->
				
					<div id="main">
				
						<div id="of-nav">
				
							<ul>
								<?php echo $options_machine->Menu ?>
								
								<?php if( is_a_theme_update_available() ) : ?>
							
									<li id="update_menu">
										<a href="#theme-update" title="There is a theme update available"><?php _e('Theme Update',THEMENAME); ?></a>
									</li>
							
								<?php endif; ?>
								
							</ul>
				
						</div><!-- #of-nav -->
				
						<div id="content">
							
							<?php echo $options_machine->Inputs /* Settings */ ?>
							
							
							<?php if( is_a_theme_update_available() ) : ?>
							
								<?php theme_update_available_markup(); ?>
							
							<?php endif; ?>
							
						</div><!-- #content -->
					
						<div class="clear"></div>
				
					</div><!-- #main -->
				
					<div class="save_bar_top"> 
				
						<img style="display:none" src="<?php echo ADMIN; ?>images/loading-bottom.gif" class="ajax-loading-img ajax-loading-img-bottom" alt="Working..." />
				
						<input type="hidden" id="security" name="security" value="<?php echo wp_create_nonce('of_ajax_nonce'); ?>" />
						<input type="hidden" name="of_reset" value="reset" />
							
						<?php $saved_options = get_option( OPTIONS ); ?>
						<?php if( (!array_key_exists('lock_key',$saved_options)) || ($saved_options['lock_key'] == "") ) : ?>
							
							<button id ="of_save" type="button" class="button-primary"><?php _e('Save All Changes', THEMENAME);?></button>
							<button id ="of_reset" type="submit" class="button submit-button reset-button" ><?php _e('Options Reset', THEMENAME);?></button>
							
						<?php endif; ?>
				
					</div><!-- #save_bar_top --> 
				
				</form>
			
			</div><!-- #wrap -->
		
			<?php  if (!empty($update_message)) echo $update_message; ?>
		
				<div style="clear:both;"></div>
		
		
		<?php
		
		}/* optionsframework_options_page() */
	
	endif;

	/* =========================================================================================== */


	/*
		Load required styles for Options Page - of_style_only
	*/
	
	if(!function_exists('of_style_only')) :

		function of_style_only()
		{
			
			wp_enqueue_style('admin-style', ADMIN . 'admin-style.css');
			wp_enqueue_style('color-picker', ADMIN . 'css/colorpicker.css');
			wp_enqueue_style('date-picker', ADMIN . 'css/datepicker.css');
			wp_enqueue_style('i-button', ADMIN . 'css/jquery.ibutton.min.css');
			
		}/* of_style_only() */
	
	endif;

	/* =========================================================================================== */

	
	/*
		Load required javascripts for Options Page - of_load_only
	*/
	
	if(!function_exists('of_load_only')) :

		function of_load_only()
		{
		
			$data = get_option(OPTIONS);
		
			add_action('admin_head', 'of_admin_head');
			
			wp_enqueue_script('jquery-ui-core');
			wp_register_script('jquery-input-mask', ADMIN .'js/jquery.maskedinput-1.2.2.js', array( 'jquery' ));
			wp_enqueue_script('jquery-input-mask');
			wp_enqueue_script('color-picker', ADMIN .'js/colorpicker.js', array('jquery'));
			wp_enqueue_script('ajaxupload', ADMIN .'js/ajaxupload.js', array('jquery'));
			wp_enqueue_script('datepicker', ADMIN .'js/datepicker.js', array('jquery'));
			wp_enqueue_script('ibutton', ADMIN .'js/jquery.ibutton.min.js', array('jquery'));
			wp_enqueue_script('jqeasing', ADMIN .'js/jquery.easing.1.3.js', array('jquery'));
			
			if( ((array_key_exists('first_run_option_selected',$data)) && ($data['first_run_option_selected'] == "1")) )
			{
				wp_enqueue_script('iphonepassword', ADMIN .'js/jquery.iphonepassword.js', array('jquery'));
			}
		
		}/* of_load_only() */
	
	endif;

	/* =========================================================================================== */


	/*
		The javascript for the admin options page - of_admin_head
	*/
	
	if(!function_exists('of_admin_head')) :

		function of_admin_head()
		{ 
					
			$data = get_option(OPTIONS);
			if(!$data || !is_array($data))
				$data=array();
			
			global $current_user;
      		get_currentuserinfo();
			$user_email_address = $current_user->user_email;
			
		?>
				
			<script type="text/javascript" language="javascript">
		
				jQuery.noConflict();
				jQuery(document).ready(function($){
			
					//delays until AjaxUpload is finished loading
					//fixes bug in Safari and Mac Chrome
					if (typeof AjaxUpload != 'function') { 
							return ++counter < 6 && window.setTimeout(init, counter * 500);
					}
					//hides warning if js is enabled			
					$('#js-warning').hide();
					
					//Tabify Options			
					$('.group').hide();
					$('.group:first').fadeIn();
								
					$('.group .collapsed').each(function(){
						$(this).find('input:checked').parent().parent().parent().nextAll().each( 
							function(){
								if ($(this).hasClass('last')) {
				           			$(this).removeClass('hidden');
				           			return false;
				           		}
								$(this).filter('.hidden').removeClass('hidden');
						});
				    });
				           					
					$('.group .collapsed input:checkbox').click(unhideHidden);
								
					function unhideHidden(){
						if ($(this).attr('checked')) {
							$(this).parent().parent().parent().nextAll().removeClass('hidden');
						} else {
							$(this).parent().parent().parent().nextAll().each( 
								function(){
				           			if ($(this).filter('.last').length) {
				           				$(this).addClass('hidden');
										return false;
				           			}
				           			$(this).addClass('hidden');
				           		});
				           					
						}
					}
				
					//Current Menu Class
					$('#of-nav li:first').addClass('current');
					$('#of-nav li a').click(function(evt){
								
						$('#of-nav li').removeClass('current');
						$(this).parent().addClass('current');
											
						var clicked_group = $(this).attr('href');
							 
						$('.group').hide();
											
						$(clicked_group).fadeIn();
						
						evt.preventDefault();
											
					});
					
					$('.datepickerinput').datepick();
					
					//$(".add_sidebar_button").click(function(){
					$('.add_sidebar_button').live("click",function() {
					
						var number_of_custom_sidebars = $('input.custom-sidebar-name').length;
						var style_dir = "<?php echo get_stylesheet_directory_uri(); ?>";
	
						if(number_of_custom_sidebars > 0){
						
							$('.section-theme_custom_sidebar .option .custom-sidebar-name').first().clone().appendTo(".section-theme_custom_sidebar .controls");
							var new_num = number_of_custom_sidebars + 1;
							$('.section-theme_custom_sidebar .option .custom-sidebar-name').last().val("Custom Sidebar "+new_num);
							$('.section-theme_custom_sidebar .option .custom-sidebar-name').last().after('<img title="theme_custom_sidebars['+number_of_custom_sidebars+']" class="remove_this_sidebar" alt="" src="'+style_dir+'/admin/images/delete_sidebar.png">');
						
						}else{
	
							$('.section-theme_custom_sidebar').append('<input type="text" value="Jibber" id="theme_custom_sidebars[0]" name="theme_custom_sidebars[]" class="of-input custom-sidebar-name"><img title="theme_custom_sidebars[0]" class="remove_this_sidebar" alt="" src="'+style_dir+'/admin/images/delete_sidebar.png">');
						
						}
					
						return false;	
					
					})
					
					$('.remove_this_sidebar').click(function(){
					
						var sidebar_to_remove = $(this).attr("title");
						$(this).prev().fadeOut().remove();
						$(this).fadeOut().remove();
					
					});
					
					$('input#hide_advanced_options').change(function(){
					
						if($('.hasChanged').length == 0){
						
							$(this).closest('.option').addClass('hasChanged');
							$('.hasChanged .explain').append('<p style="color: red; padding: 15px; background: #ffd6d6; border: 1px solid rgb(230,0,0); -moz-border-radius: 5px; -webkit-border-radius: 5px; border-radius: 5px;"><?php _e('You will need to click on "Save All Changes" below and then refresh this page for this change to take effect.',THEMENAME); ?></p>');
						
						}
				
					});
			
			
					// Reset Message Popup
					//var reset = "<?php //echo $_REQUEST['reset'] ?>";
					var reset = "<?php if(array_key_exists('reset', $_REQUEST)){echo $_REQUEST['reset'];} ?>";
								
					if ( reset.length ){
						if ( reset == 'true') {
							var message_popup = $('#of-popup-reset');
						} else {
							var message_popup = $('#of-popup-fail');
					}
						message_popup.fadeIn();
						window.setTimeout(function(){
					    message_popup.fadeOut();                        
						}, 2000);	
					}
					
					//Update Message popup
					$.fn.center = function () {
						this.animate({"top":( $(window).height() - this.height() - 200 ) / 2+$(window).scrollTop() + "px"},100);
						this.css("left", 250 );
						return this;
					}
						
							
					$('#of-popup-save').center();
					$('#of-popup-reset').center();
					$('#of-popup-fail').center();
							
					$(window).scroll(function() { 
						$('#of-popup-save').center();
						$('#of-popup-reset').center();
						$('#of-popup-fail').center();
					});
						
			
					//Masked Inputs (images as radio buttons)
					$('.of-radio-img-img').click(function(){
						$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
						$(this).addClass('of-radio-img-selected');
					});
					$('.of-radio-img-label').hide();
					$('.of-radio-img-img').show();
					$('.of-radio-img-radio').hide();
					
					// COLOR Picker			
					$('.colorSelector').each(function(){
						var Othis = this; //cache a copy of the this variable for use inside nested function
							
						$(this).ColorPicker({
								color: '<?php if(!empty($color)){echo $color;} ?>',
								onShow: function (colpkr) {
									$(colpkr).fadeIn(500);
									return false;
								},
								onHide: function (colpkr) {
									$(colpkr).fadeOut(500);
									return false;
								},
								onChange: function (hsb, hex, rgb) {
									$(Othis).children('div').css('backgroundColor', '#' + hex);
									$(Othis).next('input').attr('value','#' + hex);
									
								}
						});
							  
					}); //end color picker
			
					//AJAX Upload
					$('.image_upload_button').each(function(){
							
						var clickedObject = $(this);
						var clickedID = $(this).attr('id');	
								
						var nonce = $('#security').val();
								
						new AjaxUpload(clickedID, {
							action: ajaxurl,
							name: clickedID, // File upload name
							data: { // Additional data to send
								action: 'of_ajax_post_action',
								type: 'upload',
								security: nonce,
								data: clickedID },
							autoSubmit: true, // Submit file after selection
							responseType: false,
							onChange: function(file, extension){},
							onSubmit: function(file, extension){
								clickedObject.text('Uploading'); // change button text, when user selects file	
								this.disable(); // If you want to allow uploading only 1 file at time, you can disable upload button
								interval = window.setInterval(function(){
									var text = clickedObject.text();
									if (text.length < 13){	clickedObject.text(text + '.'); }
									else { clickedObject.text('Uploading'); } 
									}, 200);
							},
							onComplete: function(file, response) {
								window.clearInterval(interval);
								clickedObject.text('Upload Image');	
								this.enable(); // enable upload button
									
						
								// If nonce fails
								if(response==-1){
									var fail_popup = $('#of-popup-fail');
									fail_popup.fadeIn();
									window.setTimeout(function(){
									fail_popup.fadeOut();                        
									}, 2000);
								}				
										
								// If there was an error
								else if(response.search('Upload Error') > -1){
									var buildReturn = '<span class="upload-error">' + response + '</span>';
									$(".upload-error").remove();
									clickedObject.parent().after(buildReturn);
									
									}
								else{
									var buildReturn = '<img class="hide of-option-image" id="image_'+clickedID+'" src="'+response+'" alt="" />';
					
									$(".upload-error").remove();
									$("#image_" + clickedID).remove();	
									clickedObject.parent().after(buildReturn);
									$('img#image_'+clickedID).fadeIn();
									clickedObject.next('span').fadeIn();
									clickedObject.parent().prev('input').val(response);
								}
							}
						});
						
					});
					
					//Select everything when the theme options export is in focus
					$('#theme_export_options').click(function(){
					
						$(this).select();
					
					});
					
					//AJAX Remove (clear option value)
					$('.image_reset_button').click(function(){
					
						var clickedObject = $(this);
						var clickedID = $(this).attr('id');
						var theID = $(this).attr('title');	
								
						var nonce = $('#security').val();
					
						var data = {
							action: 'of_ajax_post_action',
							type: 'image_reset',
							security: nonce,
							data: theID
						};
									
						$.post(ajaxurl, data, function(response) {
										
							//check nonce
							if(response==-1){ //failed
											
								var fail_popup = $('#of-popup-fail');
								fail_popup.fadeIn();
								window.setTimeout(function(){
									fail_popup.fadeOut();                        
								}, 2000);
							}
										
							else {
										
								var image_to_remove = $('#image_' + theID);
								var button_to_hide = $('#reset_' + theID);
								image_to_remove.fadeOut(500,function(){ $(this).remove(); });
								button_to_hide.fadeOut();
								clickedObject.parent().prev('input').val('');
							}
										
										
						});
									
					});
					
					$( '#unlock_screen_submit' ).live("click", function(){
					
						var entered_unlock_code = $( '#unlock_screen_entered_value' ).val();
						
						var nonce = $('#security').val();
						$('.ajax-loading-img').fadeIn();
						
						var data = {
							<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework'){ ?>
							type: 'unlock_screen',
							<?php } ?>
				
							action: 'of_ajax_post_action',
							security: nonce,
							data: entered_unlock_code
						};
						
						$.post(ajaxurl, data, function(response) {
							var success = $('#of-popup-save');
							var fail = $('#of-popup-fail'); 
										
							if (response==1) {
								success.fadeIn();
								location.reload(true);
							} else { 
								fail.fadeIn();
							}
										
							window.setTimeout(function(){
								success.fadeOut(); 
								fail.fadeOut();				
							}, 2000);
						});

						return false;
					
					});
					
					//save everything else
					$('#of_save').live("click",function() {
							
						//Empty the theme options export
						$('#theme_export_options, #hidden_options').attr("value","");
						
						
						var nonce = $('#security').val();
									
						$('.ajax-loading-img').fadeIn();
														
						var serializedReturn = $('#ofform :input[name][name!="security"][name!="of_reset"]').serialize();
														
						//alert(serializedReturn);
										
						var data = {
							<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework'){ ?>
							type: 'save',
							<?php } ?>
				
							action: 'of_ajax_post_action',
							security: nonce,
							data: serializedReturn
						};
									
						$.post(ajaxurl, data, function(response) {
							var success = $('#of-popup-save');
							var fail = $('#of-popup-fail');
							var loading = $('.ajax-loading-img');
							loading.fadeOut();  
										
							if (response==1) {
								success.fadeIn();
							} else if(response==23){
								location.reload(true);
							} else { 
								fail.fadeIn();
							}
										
							window.setTimeout(function(){
								success.fadeOut(); 
								fail.fadeOut();				
							}, 2000);
						});
							
						return false; 
									
					});   
							
					//confirm reset			
					$('#of_reset').click(function() {
						var answer = confirm("<?php _e('Click OK to reset. All settings will be lost!', THEMENAME);?>")
						if (answer){ 	return true; } else { return false; }
					});
					
					if($('textarea#theme_export_options').val() == ""){
						
						//If the user hasn't "generated" the options, don't let them e-mail an empty set
						$('button.email_options_export').attr("disabled","disabled");
						
					}
					
					//Email options
					$('.email_options_export').live("click",function(){
					
						var options_export_value = $('#theme_export_options').val();
						var nonce = $('#security').val();
						
						var data = {
							<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework'){ ?>
							type: 'email',
							<?php } ?>
				
							action: 'of_ajax_post_action',
							security: nonce,
							data: options_export_value
						};
						
						$.post(ajaxurl, data, function(response) {
							var success = $('#of-popup-save');
							var fail = $('#of-popup-fail'); 
										
							if (response==1) {
								success.fadeIn();
							} else { 
								fail.fadeIn();
							}
										
							window.setTimeout(function(){
								success.fadeOut(); 
								fail.fadeOut();				
							}, 2000);
						});
						
					
						return false;
					
					});
					
					//Generate options
					$('.generate_options').live("click",function(){
					
						var hidden_options_val = $('#hidden_options').attr("value");
						$('#theme_export_options').attr("value",hidden_options_val);
						$('button.email_options_export').removeAttr("disabled");
						
						return false;	
					
					});
					
					//Import options
					if($('textarea#theme_import_options').val() == ""){
						$('button.import_options').attr("disabled","disabled");	
					}
					
					$('#theme_import_options').live("blur",function(){
						if($('textarea#theme_import_options').val() != ""){
							$('button.import_options').removeAttr("disabled");
						}else{
							$('button.import_options').attr("disabled","disabled");	
						}
					});
					
					//$('.import_options')
					$('.import_options').live("click",function() {
							
						//Empty the theme options export
						$('#theme_export_options, #hidden_options').attr("value","");
						
						
						var nonce = $('#security').val();
									
						$('.ajax-loading-img').fadeIn();
														
						var serializedReturn = $('#theme_import_options').val();
														
						//alert(serializedReturn);
										
						var data = {
							<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework'){ ?>
							type: 'save',
							<?php } ?>
				
							action: 'of_ajax_post_action',
							security: nonce,
							data: serializedReturn
						};
									
						$.post(ajaxurl, data, function(response) {
							var success = $('#of-popup-save');
							var fail = $('#of-popup-fail');
							var loading = $('.ajax-loading-img');
							var supportsent = $('#of-message-sent');
							loading.fadeOut();  
										
							if (response==1) {
								success.fadeIn();
								location.reload(true);
							} else if(response==23){
								location.reload(true);
							} else if(response==24){
								supportsent.fadeIn();
							} else { 
								fail.fadeIn();
							}
										
							window.setTimeout(function(){
								success.fadeOut(); 
								fail.fadeOut();				
							}, 2000);
						});
							
						return false; 
									
					});
					
					//Utilise the ibuttons script to turn checkboxes into iPhone still switchers
					$(":checkbox").iButton();
					
					//Make password fields like an iPhones
					if( $('input:password').length != 0 ){
						$('input:password').password123();
					}
					
					//Help section - hide FAQ answers
					$('.faq_answer').hide();
					
					//Show answer on click of heading
					$('#of_container #content .section-help-question h3.heading').live("click",function(){
					
						var next_answer_container = $(this).next().find('.explain');
					
						if($(this).hasClass('showing')){
							next_answer_container.slideUp();
							$(this).removeClass('showing');
						}else{
							next_answer_container.slideDown();
							$(this).addClass('showing');
						}
					
					});
					
					//Send e-mail text has been clicked, show message box
					$('.send_support_email').live("click", function(){
						
						var message_box = "<textarea id='message_to_send' rows='5' style='width: 100%; padding: 5px;'>Dear <?php echo THEME_AUTHOR; ?>…\r\n\ \r\n \r\n \r\n From <?php echo $user_email_address; ?></textarea>";
						var note = "<small class='email_note'>NOTE: We automatically send the theme name, version number, operating system and browser.</small>";
						var send_support_button = "<button class='send_support button-primary' value='Send Support E-Mail'>Send Support E-mail</button>";
						
						$(this).parent().append("<br /><br />" + message_box + "<br />" + note + "<br />" + send_support_button);
					
					});
					
					
					//Send e-mail button has been clicked, send e-mail
					$('.send_support').live("click", function(){
					
						var theme_name = "<?php echo THEMENAME; ?>";
						var theme_version = "<?php echo THEMEVERSION; ?>";
						var body_classes = $('body').attr('class');
						var typed_message = $('#message_to_send').val();
						
						var message_to_send = "THEME: " + theme_name + "\r\n" + "VERSION: " + theme_version + "\r\n \r\n" + "Body Classes: " + body_classes + "\r\n \r\n" + typed_message;
						
						var nonce = $('#security').val();
						
						var data = {
							<?php if(isset($_REQUEST['page']) && $_REQUEST['page'] == 'optionsframework'){ ?>
							type: 'supportemail',
							<?php } ?>
				
							action: 'of_ajax_post_action',
							security: nonce,
							data: message_to_send
						};
						
						$.post(ajaxurl, data, function(response) {
							var success = $('#of-message-sent');
							var fail = $('#of-popup-fail'); 
										
							if (response==24) {
								success.fadeIn();
								$('#message_to_send').fadeOut();
								$('.email_note').fadeOut();
								$('.send_support').fadeOut();
							} else { 
								fail.fadeIn();
							}
										
							window.setTimeout(function(){
								success.fadeOut(); 
								fail.fadeOut();				
							}, 2000);
						});
						
					
						return false;
					
					});
					
				
				}); //end doc ready
			
			</script>
		
		<?php 
		
		}/* of_admin_head() */
	
	endif;

	/* =========================================================================================== */


	/*
		Ajax Save Action - of_ajax_callback
	*/
	
	if(!function_exists('of_ajax_callback')) :

		function of_ajax_callback()
		{
			
			global $options_machine;
		
			$nonce=$_POST['security'];
			
			if (! wp_verify_nonce($nonce, 'of_ajax_nonce') ) die('-1'); 
					
			//get options array from db
			$all = get_option(OPTIONS);
				
			$save_type = $_POST['type'];
			
			//Uploads
			if($save_type == 'upload')
			{
				
				$clickedID = $_POST['data']; // Acts as the name
				$filename = $_FILES[$clickedID];
		       	$filename['name'] = preg_replace('/[^a-zA-Z0-9._\-]/', '', $filename['name']); 
				
				$override['test_form'] = false;
				$override['action'] = 'wp_handle_upload';    
				$uploaded_file = wp_handle_upload($filename,$override);
				 
					$upload_tracking[] = $clickedID;
						
					//update $options array w/ image URL			  
					$upload_image = $all; //preserve current data
					
					$upload_image[$clickedID] = $uploaded_file['url'];
					
					update_option(OPTIONS, $upload_image ) ;
				
						
				 if(!empty($uploaded_file['error'])) {echo 'Upload Error: ' . $uploaded_file['error']; }	
				 else { echo $uploaded_file['url']; } // Is the Response
				 
			}
			elseif($save_type == 'image_reset')
			{
					
					$id = $_POST['data']; // Acts as the name
					
					$delete_image = $all; //preserve rest of data
					$delete_image[$id] = ''; //update array key with empty value	 
					update_option(OPTIONS, $delete_image ) ;
			
			}	
			elseif ($save_type == 'save')
			{
				
				parse_str($_POST['data'], $data);
				unset($data['security']);
				unset($data['of_save']);
		   
				update_option(OPTIONS, $data);
				
				//If we're on the install page, we want to refresh when they have saved
				$saved_options = get_option(OPTIONS);
				if(array_key_exists('first_run_option_selected',$saved_options))
				{
					if(!$saved_options['first_run_option_selected'])
					{
						die('23'); 
					}
					else
					{
						die('1');
					}
				}
				else
				{
					die('23');
				}
				
				
			}
			elseif ($save_type == 'reset')
			{
				
				update_option(OPTIONS,$options_machine->Defaults);
		        die(1); //options reset
		        
			}
			elseif ($save_type == 'email')
			{
			
				global $current_user;
				get_currentuserinfo();
			
				$to_address = $current_user->user_email;
				$subject = __('Your Friendly Themes Options backup',THEMENAME);
				$message = __("Here is your theme options backup \n \n",THEMENAME).$_POST['data'];
				
				wp_mail($to_address,$subject,$message);
				die('1');
			
			}
			elseif ($save_type == 'supportemail')
			{
			
				if(THEME_AUTHOR == 'iamfriendly')
				{
					$to_address = "richard@iamfriendly.com";
				}
				else
				{
					$to_address = "support@friendlythem.es";
				}
				
				$theme_name = THEMENAME;
				$subject = __("SUPPORT: $theme_name", THEMENAME);
				$message = $_POST['data'];
				
				wp_mail($to_address,$subject,$message);
				die('24');
			
			}
			elseif ($save_type == 'unlock_screen')
			{
			
				$saved_options = get_option(OPTIONS);
				if( $_POST['data'] == $saved_options['lock_key'] )
				{
				
					$saved_options['unlock_screen_entered_value'] = "";
					$saved_options['unlock_key'] = "";
					$saved_options['lock_key'] = "";
					
					update_option( OPTIONS, $saved_options );
					
					die( '1' );
				
				}
				else
				{
					die( '0' );
				}
			
			}
		
			die();
		
		}/* of_ajax_callback() */
	
	endif;

	add_action('wp_ajax_of_ajax_post_action', 'of_ajax_callback');
	
	/* =========================================================================================== */


	/*
		Class that Generates The Options Within the Panel - optionsframework_machine
	*/
	
	if(!class_exists('Options_Machine')) :

		class Options_Machine
		{
		
			function __construct($options)
			{
				
				$return = $this->optionsframework_machine($options);
				
				$this->Inputs = $return[0];
				$this->Menu = $return[1];
				$this->Defaults = $return[2];
				
			}
		
			/* ================================================================================ */
			
			/*
				Generates The Options Within the Panel - optionsframework_machine
			*/
		
			public static function optionsframework_machine($options)
			{
			    
			    $data = get_option(OPTIONS);
			    if( empty($data) )
					$data = array();
				
				$defaults = array();   
			    $counter = 0;
				$menu = '';
				$output = '';
				foreach ($options as $value)
				{
				   
					$counter++;
					$val = '';
					
					//create array of defaults		
					if ($value['type'] == 'multicheck')
					{
						if (is_array($value['std']))
						{
							foreach($value['std'] as $i=>$key)
							{
								$defaults[$value['id']][$key] = true;
							}
						}
						else
						{
							$defaults[$value['id']][$value['std']] = true;
						}
					}
					else
					{
						
						if(array_key_exists('id',$value))
						{
							$defaults[$value['id']] = $value['std'];
						}
	
					}
					
					//Start Heading
					if ( $value['type'] != "heading" )
					{
						$class = ''; if(isset( $value['class'] )) { $class = $value['class']; }
						
						
						$output .= '<div id="section-for-'. $value['id'] .'" class="section section-'.$value['type'].' '. $class .'">'."\n";
						$output .= '<h3 class="heading">'. $value['name'] .'</h3>'."\n";
						$output .= '<div class="option">'."\n" . '<div class="controls">'."\n";
					
					} 
					 //End Heading
					                                 
					switch ( $value['type'] )
					{
					
						case 'text':
						
							if(array_key_exists($value['id'],$data))
							{
								if($data[$value['id']] == "")
								{
									//if the value is empty
									if($value['std'] != "")
									{
										//if the default (std) is empty
										$data[$value['id']] = $value['std'];
									}
									
								}
								
								$output .= '<input class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $data[$value['id']] .'" />';
							}
							else
							{
								$output .= '<input class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="" />';
							}
							
						break;
						
						case 'select':
							$output .= '<select class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'">';
							if(array_key_exists($value['id'],$data))
							{
								foreach ($value['options'] as $option)
								{			
									$output .= '<option value="'.$option.'" ' . selected($data[$value['id']], $option, false) . ' />'.$option.'</option>';	 
							 	} 
							}
							else
							{
								foreach ($value['options'] as $option)
								{			
									$output .= '<option value="'.$option.'" />'.$option.'</option>';	 
							 	} 
							}
							
							 $output .= '</select>';
						break;
						
						case 'select2':
							$output .= '<select class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'">';
							foreach ($value['options'] as $option=>$name) {
								$output .= '<option value="'.$option.'" ' . selected($data[$value['id']], $option, false) . ' />'.$name.'</option>';
							 } 
							 $output .= '</select>';		
						break;
						
						case 'textarea':	
							$cols = '8';
							$ta_value = '';
							
							if(isset($value['options']))
							{
								$ta_options = $value['options'];
								if(isset($ta_options['cols']))
								{
									$cols = $ta_options['cols'];
								} 
							}
							
							if(array_key_exists($value['id'],$data))
							{
								$ta_value = stripslashes($data[$value['id']]);			
								$output .= '<textarea class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8">'.$ta_value.'</textarea>';	
							}
							else
							{
								$output .= '<textarea class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8"></textarea>';
							}
								
						
						break;
						
						case "radio":
							
							foreach($value['options'] as $option=>$name)
							{
								
								if(array_key_exists($value['id'],$data))
								{
									$output .= '<input class="of-input of-radio" name="'.$value['id'].'" type="radio" value="'.$option.'" ' . checked($data[$value['id']], $option, false) . ' />'.$name.'<br/>';
								}
								else
								{
									$output .= '<input class="of-input of-radio" name="'.$value['id'].'" type="radio" value="'.$option.'"  />'.$name.'<br/>';	
								}
											
							}	 
						
						break;
						
						case 'checkbox': 	
							
							if(array_key_exists($value['id'],$data))
							{
								$output .= '<input type="checkbox" class="checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="1" checked="yes" />';	
							}
							else
							{
								$output .= '<input type="checkbox" class="checkbox of-input" name="'.$value['id'].'" id="'. $value['id'] .'" value="1" />';	
							}		
						
						break;
				
						case 'multicheck': 			
							$multi_stored = $data[$value['id']];
										
							foreach ($value['options'] as $key => $option)
							{										 
								$of_key_string = $value['id'] . '_' . $key;
								$output .= '<input type="checkbox" class="checkbox of-input" name="'.$value['id'].'['.$key.']'.'" id="'. $of_key_string .'" value="1" '. checked($multi_stored[$key], 1, false) .' /><label for="'. $of_key_string .'">'. $option .'</label><br />';								
							}
									 
						break;
						
						case 'upload':			
							$output .= Options_Machine::optionsframework_uploader_function($value['id'],$value['std'],null);			
						
						break;
						
						case 'upload_min':			
							$output .= Options_Machine::optionsframework_uploader_function($value['id'],$value['std'],'min');			
						
						break;
						
						case 'color':
						
							if(array_key_exists($value['id'], $data))
							{
								$output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div style="background-color: '.$data[$value['id']].'"></div></div>';
								$output .= '<input class="of-color" name="'.$value['id'].'" id="'. $value['id'] .'" type="text" value="'. $data[$value['id']] .'" />';
							}
							else
							{
								$output .= '<div id="' . $value['id'] . '_picker" class="colorSelector"><div></div></div>';
								$output .= '<input class="of-color" name="'.$value['id'].'" id="'. $value['id'] .'" type="text" value="" />';
							}
							
						
						break;   	
						
						case 'typography':								
							$typography_stored = $data[$value['id']];		
							/* Font Size */ 
							$output .= '<select class="of-typography of-typography-size" name="'.$value['id'].'[size]" id="'. $value['id'].'_size">';
								
							for ($i = 9; $i < 71; $i++)
							{ 
								$test = $i.'px';
								$output .= '<option value="'. $i .'px" ' . selected($typography_stored['size'], $test, false) . '>'. $i .'px</option>'; 
							}
					
							$output .= '</select>';
					
							/* Font Face */
							$output .= '<select class="of-typography of-typography-face" name="'.$value['id'].'[face]" id="'. $value['id'].'_face">';
							
							$faces = array('arial'=>'Arial',
											'verdana'=>'Verdana, Geneva',
											'trebuchet'=>'Trebuchet',
											'georgia' =>'Georgia',
											'times'=>'Times New Roman',
											'tahoma'=>'Tahoma, Geneva',
											'palatino'=>'Palatino',
											'helvetica'=>'Helvetica*' );			
							
							foreach ($faces as $i=>$face)
							{
								$output .= '<option value="'. $i .'" ' . selected($typography_stored['face'], $i, false) . '>'. $face .'</option>';
							}			
											
							$output .= '</select>';	
							
							/* Font Weight */	
							$output .= '<select class="of-typography of-typography-style" name="'.$value['id'].'[style]" id="'. $value['id'].'_style">';
							$styles = array('normal'=>'Normal',
											'italic'=>'Italic',
											'bold'=>'Bold',
											'bold italic'=>'Bold Italic');
											
							foreach ($styles as $i=>$style)
							{
							
								$output .= '<option value="'. $i .'" ' . selected($typography_stored['style'], $i, false) . '>'. $style .'</option>';		
							
							}
							
							$output .= '</select>';
							
							/* Font Color */			
							$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div style="background-color: '.$typography_stored['color'].'"></div></div>';
							$output .= '<input class="of-color of-typography of-typography-color" name="'.$value['id'].'[color]" id="'. $value['id'] .'_color" type="text" value="'. $typography_stored['color'] .'" />';
						break;  
						case 'border':
							$default = $value['std'];
							$border_stored = array('width' => $data[$value['id'] . '_width'] ,
													'style' => $data[$value['id'] . '_style'],
													'color' => $data[$value['id'] . '_color'],
													);
								
							/* Border Width */
							$border_stored = $data[$value['id']];
							
							$output .= '<select class="of-border of-border-width" name="'.$value['id'].'[width]" id="'. $value['id'].'_width">';
							
							for ($i = 0; $i < 21; $i++)
							{ 
								$output .= '<option value="'. $i .'" ' . selected($border_stored['width'], $i, false) . '>'. $i .'</option>';		
							}
							
							$output .= '</select>';
							
							/* Border Style */
							$output .= '<select class="of-border of-border-style" name="'.$value['id'].'[style]" id="'. $value['id'].'_style">';
							
							$styles = array('none'=>'None',
											'solid'=>'Solid',
											'dashed'=>'Dashed',
											'dotted'=>'Dotted');
											
							foreach ($styles as $i=>$style)
							{
							
								$output .= '<option value="'. $i .'" ' . selected($border_stored['style'], $i, false) . '>'. $style .'</option>';		
							}
							
							$output .= '</select>';
							
							/* Border Color */		
							$output .= '<div id="' . $value['id'] . '_color_picker" class="colorSelector"><div style="background-color: '.$border_stored['color'].'"></div></div>';
							$output .= '<input class="of-color of-border of-border-color" name="'.$value['id'].'[color]" id="'. $value['id'] .'_color" type="text" value="'. $border_stored['color'] .'" />';
						
						break;   
						
						case 'images':
							
							$i = 0;
							if(array_key_exists($value['id'],$data))
								$select_value = $data[$value['id']];
				  
							foreach ($value['options'] as $key => $option) 
							{ 
								$i++;
				
								$checked = '';
								$selected = '';
								if(NULL!=checked($data[$value['id']], $key, false))
								{
									$checked = checked($data[$value['id']], $key, false);
									$selected = 'of-radio-img-selected';  
								} 	
								$output .= '<span>';
								$output .= '<input type="radio" id="of-radio-img-' . $value['id'] . $i . '" class="checkbox of-radio-img-radio" value="'.$key.'" name="'.$value['id'].'" '.$checked.' />';
								$output .= '<div class="of-radio-img-label">'. $key .'</div>';
								$output .= '<img src="'.$option.'" alt="" class="of-radio-img-img '. $selected .'" onClick="document.getElementById(\'of-radio-img-'. $value['id'] . $i.'\').checked = true;" />';
								$output .= '</span>';				
							}
									
						break;
						 	
						case "info":
							$default = $value['std'];
							$output .= $default;
							
						break; 
						                                  	
						case 'heading':
							
							if($counter >= 2)
							{
							   $output .= '</div>'."\n";
							}
							$jquery_click_hook = ereg_replace("[^A-Za-z0-9]", "", strtolower($value['name']) );
							$jquery_click_hook = "of-option-" . $jquery_click_hook;
							$menu .= '<li id="tab-'.$jquery_click_hook.'"><a title="'.  $value['name'] .'" href="#'.  $jquery_click_hook  .'">'.  $value['name'] .'</a></li>';
							$output .= '<div class="group" id="'. $jquery_click_hook  .'"><h2>'.$value['name'].'</h2>'."\n";
						break;
						
						case 'message':
						
							$output .= "";
						
						break;
						
						case 'date':
						
							$output .= '<input class="of-input datepickerinput" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $data[$value['id']] .'" />';
						
						break;
						
						case 'theme_custom_sidebar':
							
							if(array_key_exists($value['id'],$data))
							{
								$results = $data[$value['id']];
							
								if(is_array($results))
								{
									$i = 0;
									while($i < count($results))
									{
										$output .= '<input class="of-input custom-sidebar-name" name="'.$value['id'].'[]" id="'. $value['id'] .'['.$i.']" type="text" value="'. $results[$i] .'" />';
										$output .= '<img src="'.get_bloginfo('stylesheet_directory').'/admin/images/delete_sidebar.png" alt="" class="remove_this_sidebar" title="'. $value['id'] .'['.$i.']" />';
										
										$i++;
									}
								}
								else
								{
									$output .= '<input class="of-input custom-sidebar-name" name="'.$value['id'].'[]" id="'. $value['id'] .'[0]" type="text" value="Custom Sidebar" />';
									$output .= '<img src="'.get_bloginfo('stylesheet_directory').'/admin/images/delete_sidebar.png" alt="" class="remove_this_sidebar" title="'. $value['id'] .'[0]" />';
								}
								
		
								$output .= '<button class="add_sidebar_button button-primary" value="Add Sidebar">'.__("Add Sidebar",THEMENAME).'</button>';
							}
							else
							{
							
								$output .= '<input class="of-input custom-sidebar-name" name="'.$value['id'].'[]" id="'. $value['id'] .'[0]" type="text" value="Custom Sidebar" />';
								$output .= '<img src="'.get_bloginfo('stylesheet_directory').'/admin/images/delete_sidebar.png" alt="" class="remove_this_sidebar" title="'. $value['id'] .'[0]" />';
								
								$output .= '<button class="add_sidebar_button button-primary" value="Add Sidebar">'.__("Add Sidebar",THEMENAME).'</button>';
							}
							
							
						break;  
						
						case 'theme_export_options':
						
							$export_options = http_build_query(get_option(OPTIONS));
							$cols = '8';
							
							$output .= "<input type='hidden' value='".$export_options."' id='hidden_options' />";
							
							$output .= '<textarea class="of-input" readonly="readonly" name="'.$value['id'].'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8"></textarea>';
							$output .= '<button class="generate_options button-primary" value="Generate Options">'.__("Generate Options",THEMENAME).'</button>';
							$output .= '<button class="email_options_export button-primary" value="Email Options">'.__("E-mail me these options",THEMENAME).'</button>';
	
						
						break;
						
						case 'unlock_screen':
						
						$output .= "<input type='text' value='' id='unlock_screen_entered_value' class='of-input' name='unlock_screen_entered_value' />";
						$output .= '<button id="unlock_screen_submit" class="unlock_screen_submit button-primary" value="Unlock">'.__("Unlock",THEMENAME).'</button>';
						
						break;
						
						case 'theme_import_options':
							$cols = '8';
							$unencoded_import = '';
		
							$output .= '<textarea class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'" cols="'. $cols .'" rows="8"></textarea>';
							$output .= '<button class="import_options button-primary" value="Import Options">'.__("Import Options",THEMENAME).'</button>';
							
								
						
						break; 
						
						case 'help' :
						
							include('theme-help.php');
						
						break;
						
						case 'password':
						
							if(array_key_exists($value['id'],$data))
							{
								if($data[$value['id']] == "")
								{
									//if the value is empty
									if($value['std'] != "")
									{
										//if the default (std) is empty
										$data[$value['id']] = $value['std'];
									}
									
								}
								
								$output .= '<input class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="'. $data[$value['id']] .'" />';
							}
							else
							{
								$output .= '<input class="of-input" name="'.$value['id'].'" id="'. $value['id'] .'" type="'. $value['type'] .'" value="" />';
							}
							
						break;
						
						case 'help-question' :
						
							$output .= '<h3 class="faq_question faq_'. $value['id'] .'">'. $value['name'] .'</h3>';
							$output .= '<div class="faq_answer answer_'. $value['id'] .'">';
							$output .= $value['desc'];
							$output .= '</div>';
						
						break;                
					
					} 
					
					// if TYPE is an array, formatted into smaller inputs... ie smaller values
					if ( is_array($value['type']))
					{
						
						foreach($value['type'] as $array)
						{
						
							$id = $array['id']; 
							$std = $array['std'];
							$saved_std = get_option($id);
							if($saved_std != $std){$std = $saved_std;} 
							$meta = $array['meta'];
								
							if($array['type'] == 'text')
							{ // Only text at this point
									 
								$output .= '<input class="input-text-small of-input" name="'. $id .'" id="'. $id .'" type="text" value="'. $std .'" />';  
								$output .= '<span class="meta-two">'.$meta.'</span>';
							}
							
						}
					
					}
					
					if ( $value['type'] != 'heading' )
					{ 
						
						if ( $value['type'] != 'checkbox' ) 
						{ 
							$output .= '<br/>';
						}
						
						$style_addition = "";
						if ( $value['type'] == 'help-question' )
						{
							$style_addition = ' style="display: none;"';
						}
						
						if(!isset($value['desc'])){ $explain_value = ''; } else{ $explain_value = $value['desc']; } 
						$output .= '</div><div class="explain" '.$style_addition.'>'. $explain_value .'</div>'."\n";
						$output .= '<div class="clear"> </div></div></div>'."\n";
					}
				   
				}/* end foreach */
				
			    $output .= '</div>';
			    return array($output,$menu,$defaults);	
			    
			}/* public static function optionsframework_machine($options) */
			
			/* ================================================================================ */
		
		
			/*
				OptionsFramework Uploader - optionsframework_uploader_function
			*/
			
			public static function optionsframework_uploader_function($id,$std,$mod)
			{
			
			    $data =get_option(OPTIONS);
				
				$uploader = '';
				if(array_key_exists($id, $data))
				{
					$upload = $data[$id];
				}
				else
				{
					$upload = "";
				}
			    	
				
			    if ( $upload != "") { $val = $upload; } else {$val = $std;}
			    
				$uploader .= '<input class="of-input" name="'. $id .'" id="'. $id .'_upload" type="hidden" value="'. $val .'" />';
				
				
				$uploader .= '<div class="upload_button_div"><span class="button image_upload_button" id="'.$id.'">'.__("Upload Image",THEMENAME).'</span>';
				
				if(!empty($upload)) {$hide = '';} else { $hide = 'hide';}
				
				$uploader .= '<span class="button image_reset_button '. $hide.'" id="reset_'. $id .'" title="' . $id . '">'.__("Remove",THEMENAME).'</span>';
				$uploader .='</div>' . "\n";
			    $uploader .= '<div class="clear"></div>' . "\n";
				if(!empty($upload))
				{
			    	$uploader .= '<a class="of-uploaded-image" href="'. $upload . '">';
			    	$uploader .= '<img class="of-option-image" id="image_'.$id.'" src="'.$upload.'" alt="" />';
			    	$uploader .= '</a>';
				}
				$uploader .= '<div class="clear"></div>' . "\n"; 
			
				return $uploader;
				
			}/* public static function optionsframework_uploader_function($id,$std,$mod) */
			
			/* ================================================================================ */
		
		} /* class Options_Machine */
	
	endif;
	
	/* ==================================================================================== */
	
	if(!function_exists('friendly_array_to_object')) :
	
		function friendly_array_to_object($array = array())
		{
			
			if (!empty($array))
			{
				$data = false;
				foreach ($array as $akey => $aval)
				{
					$data -> {$akey} = $aval;
				}
				return $data;
			}
			return false;
			
		}/* friendly_array_to_object() */
	
	endif;