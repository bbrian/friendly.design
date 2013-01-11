<?php

/*
	Register the portfolio Taxonomies
*/

if(!function_exists('friendly_custom_taxonomies')) :

	function friendly_custom_taxonomies()
	{
		
		/* This may be created in the install_postdata.php file */
		if(!taxonomy_exists('work'))
		{
			register_taxonomy( 'work', 'portfolio', array( 'hierarchical' => false, 'label' => 'Work', 'query_var' => true, 'rewrite' => true ) );
		}
		
		if(!taxonomy_exists('client'))
		{
			register_taxonomy( 'client', 'portfolio', array( 'hierarchical' => false, 'label' => 'Client', 'query_var' => true, 'rewrite' => true ) );
		}
	
	}/* friendly_custom_taxonomies() */

endif;

add_action( 'init', 'friendly_custom_taxonomies', 0 );


/* ==================================================================================== */

?>