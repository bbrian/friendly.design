<!DOCTYPE html> 

<!--[if lt IE 7 ]> <html <?php language_attributes(); ?> class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html <?php language_attributes(); ?> class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html <?php language_attributes(); ?> class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html <?php language_attributes(); ?> class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html <?php language_attributes(); ?> class="no-js"> <!--<![endif]-->

<?php friendly_globalise_options(); global $style_dir, $use_friendly_breadcrumbs, $sidebar_choice, $data; ?>

<head> 

	<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->

	<?php friendly_header_meta_info_for_seo(); ?>

	<meta charset="<?php bloginfo('charset'); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	
	<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
	
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	
	<!--[if !IE 6]><!-->
		<link rel="stylesheet" type="text/css" media="screen, projection" href="<?php echo $style_dir; ?>/style.css" /> 
	<!--<![endif]-->
	
	<!--[if gte IE 7]>
		<link rel="stylesheet" href="<?php echo $style_dir; ?>/ie7.css" type="text/css" media="screen, projection" />
	<![endif]--> 
	
	<!--[if lte IE 6]>
		<link rel="stylesheet" href="http://universal-ie6-css.googlecode.com/files/ie6.1.0.css" media="screen, projection">
	<![endif]-->
	
	<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
	
	<?php friendly_touch_and_fav_icons(); ?>
	
	<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
	
	<?php friendly_add_jquery(); ?>
	
	<?php wp_head(); ?>
	
	<script>window.jQuery || document.write('<script src="<?php echo $style_dir; ?>/theme_assets/js/jquery.js">\x3C/script>')</script>
	
	<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
	
	<script src="<?php echo $style_dir; ?>/theme_assets/js/modernizr.min.js"></script>

	<!--[if lte IE 8]>
		<script src="<?php echo $style_dir; ?>/theme_assets/js/respond.min.js"></script>
		<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->
	<link rel="stylesheet/less" type="text/css" href="<?php echo $style_dir; ?>/style.css">
	
	<?php if ( is_singular() ) wp_enqueue_script( "comment-reply" ); ?>
	
	<!-- |||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||||| -->
	


</head>

<body <?php body_class(); ?>>

	<div id="wrap">
	
	<?php get_template_part( "content/content", "lead_feature" ); ?>
	
	<?php get_template_part( "section", "menu" ); ?>