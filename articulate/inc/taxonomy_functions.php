<?php

/*
	Function to list the portfolio 'types' as data-ids for the filtering
*/

if(!function_exists('friendly_list_types_of_this_item')) :

	function friendly_list_types_of_this_item($post_id)
	{
	
		$types_array = wp_get_object_terms( $post_id, 'work' );
		
		if( (is_array($types_array)) && (count($types_array) > 0) )
		{
			
			//There's at least 1 'type'
			echo "data-type='";
			foreach($types_array as $type_object)
			{
			
				$type_name = $type_object->slug;
				echo $type_name." ";
			
			}
			echo "' ";
			
			echo "class='lifted project ";
			foreach($types_array as $type_object)
			{
			
				$type_name = $type_object->slug;
				echo $type_name." ";
			
			}
			echo "'";
			
			echo "data-id='post-".$post_id."'";
			
		}

	}/* friendly_list_types_of_this_item() */

endif;

?>