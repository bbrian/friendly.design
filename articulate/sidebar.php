<?php friendly_globalise_options(); global $style_dir, $use_friendly_breadcrumbs, $data, $post;  ?>

<?php if(!empty($post)){ $sidebar_choice = get_post_meta( $post->ID, 'sidebar_name', true ); }else{ $sidebar_choice = ''; } ?>

<?php if($sidebar_choice != "No-Sidebar") : ?>

	<?php if($sidebar_choice) : ?>
	
		<div id="sidebar-<?php echo friendly_name_to_usable_string($sidebar_choice); ?>" class="sidebar custom-sidebar sidebar-<?php echo friendly_name_to_usable_string($sidebar_choice); ?>">
		
			<?php dynamic_sidebar( "$sidebar_choice" ); ?>
		
		</div><!-- #sidebar-<?php echo $sidebar_choice; ?> -->
		
	<?php else : ?>
	
		<div id="sidebar-primary" class="sidebar">

			<?php if ( is_active_sidebar( 'primary' ) ) : ?>
		
				<?php dynamic_sidebar( 'primary' ); ?>
		
			<?php endif; ?>
		
		</div><!-- #sidebar-primary -->
	
	<?php endif; ?>
	
<?php endif; ?>