jQuery(document).ready(function($) {
 
    
    $('#add_home_page_feature_row').click(function(){
    
    	var number_of_rows_atm =  $('#home_page_feature_row_container div').length;
    	var new_number = number_of_rows_atm + 1
    	
    	var fields = "<label style='display: inline-block; width: 80px;color: #666; font-style: italic;'>Image URL: </label><input style='margin-bottom: 10px;' id='upload_image_"+new_number+"' type='text' size='100' name='upload_image[]' class='upload_image_input' value='' /><br />";
    	var fields_2 = "<label style='display: inline-block; width: 80px;color: #666; font-style: italic;'>Link: </label><input style='margin-bottom: 10px;' id='upload_image_"+new_number+"_link' type='text' size='100' name='upload_image_link[]' class='upload_image_input_link' value='' /><br />";
    	var fields_3 = "<label style='display: inline-block; width: 80px;color: #666; font-style: italic;'>Add image: </label><input class='upload_image_button button' name='upload_image_"+new_number+"' id='upload_image_button_"+new_number+"' type='button' value='Upload Image' /><a class='add_advanced' style='margin-left: 14px; text-decoration: none;' href='javascript:void(0);' title='Advanced'>Advanced &darr;</a>";
    	var fields_4 = "<a class='remove_home_page_feature_row submitdelete deletion' name='remove_row_"+new_number+"' id='remove_home_page_feature_row_"+new_number+"' style='margin-left:305px; color: red; cursor: pointer; text-decoration: underline;'>- Remove</a><p class='advanced_container' style='display: none;'><label style='display: inline-block; width: 80px; color: #666; font-style: italic;'>Advanced</label><textarea name='upload_advanced[]' class='widefat' rows='5' cols='66' style='margin: 10px 0;'></textarea>If you enter <strong>anything</strong> into the 'Advanced' box above, it will completely overwrite the image/link you have for this slide. The advanced box is for people who wish to have specific html on a slide.</p>";
    	
    	$('#home_page_feature_row_container').append('<div style="margin-bottom: 25px; padding: 20px; background: white; border: 1px solid rgb(200,200,200);" class="home_page_feature_content">'+fields+fields_2+fields_3+fields_4+'</div>');
    	
    	$('.home_page_feature_content').delegate(".upload_image_button","click", function(){
	    	formfield = jQuery(this).attr('name');
			post_id = jQuery('#post_ID').val();
			tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true&amp;post_id='+post_id);
	
			return false;
	    });
	    
	    $('.home_page_feature_content').delegate(".remove_home_page_feature_row","click", function(){
	
			//clear the form fields and remove the rows
			var this_row = jQuery(this).parent();
			
			this_row.fadeOut('slow',function(){
				this_row.remove();
			});
					
		});
		
		 $('.home_page_feature_content').delegate(".add_advanced","click", function(){
			
			$(this).next().next().css("display","block");
					
		});
    
    });
    
    $('.home_page_feature_content').delegate(".upload_image_button","click", function(){
    	formfield = jQuery(this).attr('name');
		post_id = jQuery('#post_ID').val();
		tb_show('', 'media-upload.php?type=image&amp;TB_iframe=true&amp;post_id='+post_id);

		return false;
    });
	
	window.send_to_editor = function(html) {
		imgurl = jQuery('img',html).attr('src');
	
		jQuery('#'+formfield).val(imgurl);
		tb_remove();
	}
	
	
	 $('.home_page_feature_content').delegate(".remove_home_page_feature_row","click", function(){
	
		//clear the form fields and remove the rows
		var this_row = jQuery(this).parent();
		
		this_row.fadeOut('slow',function(){
			this_row.remove();
		});
				
	});
	
	$('.home_page_feature_content').delegate(".add_advanced","click", function(){
	
		var advanced_box = $(this).next().next();
		if($(advanced_box).is(":visible")){
			advanced_box.fadeOut();
			$(this).html("Advanced &darr;");
		}else{
			advanced_box.fadeIn();
			$(this).html("Advanced &uarr;");
		}
				
	});
    
});