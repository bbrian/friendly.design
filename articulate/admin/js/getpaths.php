<?php

	$real_path = get_stylesheet_directory_uri() ;
	$build_tags = "<script type='text/javascript'>";
	$build_tags .= "var real_path = '".$real_path."';";
	$build_tags .= "</script>";

	echo $build_tags;

?>