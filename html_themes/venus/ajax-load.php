<?php

	//This file loads content via ajax. It takes a hook from when a user clicks on a certain icon or button and is passed info
	//from the script that sits in your footer. This file also handles demo content, too.

?>

<?php

	$post_id = ( array_key_exists('id', $_POST) ) ? $_POST['id'] : "";
	$type = $_POST['type']; ( array_key_exists('type', $_POST) ) ? $_POST['type'] : "";
	$offset = $_POST['offset']; ( array_key_exists('offset', $_POST) ) ? $_POST['offset'] : "";
	$max_num = $_POST['max_number_to_load']; ( array_key_exists('max_number_to_load', $_POST) ) ? $_POST['max_number_to_load'] : "";
	$query_var = $_POST['sent_query_var']; ( array_key_exists('sent_query_var', $_POST) ) ? $_POST['sent_query_var'] : "";
	
?>	

<?php //==================================================================================== ?>

<?php if($type == "portfolio_home_dummy_data") : ?>

	<div class="slider-wrapper theme-default">
	
	    <!-- <div class="ribbon"></div>  -->
	    <div class="port_home_slider">
	        
	        <img src="theme_assets/images/1400x500.gif" alt="" />
	        <img src="theme_assets/images/1400x500-222.gif" alt="" />
	
	    </div><!-- .port_home_slider -->
	    
	    <div class="portfolio_home_details">
	    
	    	<h3><a href="#" title="">Project Title 5</a></h3>
	    	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
	    	
	    	<p class="more_link_block"><a href="#" title="">View full item</a></p>
	    
	    </div><!-- .portfolio_home_details -->
	    
	</div><!-- .slider-wrapper -->
	
	
	<div class="slider-wrapper theme-default">

	    <!-- <div class="ribbon"></div>  -->
	    <div class="port_home_slider">
	        
	        <img src="theme_assets/images/1400x500.gif" alt="" />
	        <img src="theme_assets/images/1400x500-222.gif" alt="" />
	
	    </div><!-- .port_home_slider -->
	    
	    <div class="portfolio_home_details">
	    
	    	<h3><a href="#" title="">Project Title 6</a></h3>
	    	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
	    	
	    	<p class="more_link_block"><a href="#" title="">View full item</a></p>
	    
	    </div><!-- .portfolio_home_details -->
	    
	</div><!-- .slider-wrapper -->
	
	
	<div class="slider-wrapper theme-default">

	    <!-- <div class="ribbon"></div>  -->
	    <div class="port_home_slider">
	        
	        <img src="theme_assets/images/1400x500.gif" alt="" />
	        <img src="theme_assets/images/1400x500-222.gif" alt="" />
	
	    </div><!-- .port_home_slider -->
	    
	    <div class="portfolio_home_details">
	    
	    	<h3><a href="#" title="">Project Title 7</a></h3>
	    	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
	    	
	    	<p class="more_link_block"><a href="#" title="">View full item</a></p>
	    
	    </div><!-- .portfolio_home_details -->
	    
	</div><!-- .slider-wrapper -->
	
	
	<div class="slider-wrapper theme-default">

	    <!-- <div class="ribbon"></div>  -->
	    <div class="port_home_slider">
	        
	        <img src="theme_assets/images/1400x500.gif" alt="" />
	        <img src="theme_assets/images/1400x500-222.gif" alt="" />
	
	    </div><!-- .port_home_slider -->
	    
	    <div class="portfolio_home_details">
	    
	    	<h3><a href="#" title="">Project Title 8</a></h3>
	    	<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
	    	
	    	<p class="more_link_block"><a href="#" title="">View full item</a></p>
	    
	    </div><!-- .portfolio_home_details -->
	    
	</div><!-- .slider-wrapper -->

<?php endif; ?>

<?php //==================================================================================== ?>

<?php if( $type == "dummy_data" ) : ?>

	<article>
				
		<div class="mosaic-block fade">
			<a href="#" title="" class="mosaic-overlay">&nbsp;</a>
			<div class="mosaic-backdrop">
				<a href="/portfolio/" title=""><img src="theme_assets/images/project7.jpg" alt="" /></a>
			</div>
		</div><!-- .mosaic-block -->
		
		<div class="service_content">
			<h5><a href="/portfolio/" title="">Project Seven</a></h5>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
		</div><!-- .slide_content -->
		
		<aside><ul><li><a href="/portfolio/" title="">Print Media</a></li></ul></aside>
		
	</article>
	
	<article>
		
		<div class="mosaic-block fade">
			<a href="#" title="" class="mosaic-overlay">&nbsp;</a>
			<div class="mosaic-backdrop">
				<a href="/portfolio/" title=""><img src="theme_assets/images/project8.jpg" alt="" /></a>
			</div>
		</div><!-- .mosaic-block -->
		
		<div class="service_content">
			<h5><a href="/portfolio/" title="">Project Eight</a></h5>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
		</div><!-- .slide_content -->
		
		<aside><ul><li><a href="/portfolio/" title="">Social Media</a></li></ul></aside>
		
	</article>
	
	<article>
		
		<div class="mosaic-block fade">
			<a href="#" title="" class="mosaic-overlay">&nbsp;</a>
			<div class="mosaic-backdrop">
				<a href="/portfolio/" title=""><img src="theme_assets/images/project9.jpg" alt="" /></a>
			</div>
		</div><!-- .mosaic-block -->
		
		<div class="service_content">
			<h5><a href="/portfolio/" title="">Project Nine</a></h5>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
		</div><!-- .slide_content -->
		
		<aside><ul><li><a href="/portfolio/" title="">Branding</a></li></ul></aside>
		
	</article>
	
	<article>
		
		<div class="mosaic-block fade">
			<a href="#" title="" class="mosaic-overlay">&nbsp;</a>
			<div class="mosaic-backdrop">
				<a href="/portfolio/" title=""><img src="theme_assets/images/project10.jpg" alt="" /></a>
			</div>
		</div><!-- .mosaic-block -->
		
		<div class="service_content">
			<h5><a href="/portfolio/" title="">Project Ten</a></h5>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
		</div><!-- .slide_content -->
		
		<aside><ul><li><a href="/portfolio/" title="">Logo creation</a></li></ul></aside>
		
	</article>
	
	<article>
		
		<div class="mosaic-block fade">
			<a href="#" title="" class="mosaic-overlay">&nbsp;</a>
			<div class="mosaic-backdrop">
				<a href="/portfolio/" title=""><img src="theme_assets/images/project11.jpg" alt="" /></a>
			</div>
		</div><!-- .mosaic-block -->
		
		<div class="service_content">
			<h5><a href="/portfolio/" title="">Project Eleven</a></h5>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
		</div><!-- .slide_content -->
		
		<aside><ul><li><a href="/portfolio/" title="">Branding</a></li></ul></aside>
		
	</article>
	
	<article>
		
		<div class="mosaic-block fade">
			<a href="#" title="" class="mosaic-overlay">&nbsp;</a>
			<div class="mosaic-backdrop">
				<a href="/portfolio/" title=""><img src="theme_assets/images/project12.jpg" alt="" /></a>
			</div>
		</div><!-- .mosaic-block -->
		
		<div class="service_content">
			<h5><a href="/portfolio/" title="">Project Twelve</a></h5>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam.</p>
		</div><!-- .slide_content -->
		
		<aside><ul><li><a href="/portfolio/" title="">Print Media</a></li></ul></aside>
		
	</article>

<?php endif; ?>

<?php //==================================================================================== ?>