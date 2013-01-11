<?php get_header(); ?>

	<div id="outside_wrap">

		<section id="content" class="boxed with_sidebar">

			<div class="inner">
			
				<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				
					<?php the_content(); ?>
				
				<?php endwhile; endif; ?>
			
			</div>
			
			<aside class="sidebar sidebar_right">
				<?php get_sidebar(); ?>
			</aside>
			
		</section>
		
	</div>

<?php get_footer(); ?>