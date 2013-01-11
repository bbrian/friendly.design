<?php friendly_globalise_options(); global $style_dir, $use_friendly_breadcrumbs, $sidebar_choice, $data; ?>

<header role="banner" id="main_header" class="boxed">

	<div class="wrap_for_static_menu">
	
		<nav id="main_menu" role="navigation">
	
			<ul class="text_menu">
				<li class="current-menu-item"><a href="#" title=""><span class="main_heading">Menu Item</span><span class="subtitle">Sub title for menu item</span></a></li>
				<ul class="submenu">
					<li><a href="#" title="#"></a></li>
				</ul>
				<li><a href="#" title=""><span class="main_heading">Another Item</span><span class="subtitle">Different subtitle</span></a></li>
			</ul>
		
		</nav><!-- #main_menu -->
		
		<nav id="social_media_menu">
		
			<ul class="">
				<li>
					<a href="#" title="Twitter">
						<img src="<?php echo $style_dir; ?>/theme_assets/images/rss.png" alt="" />
					</a>
				</li>
				<li>
					<a href="#" title="Facebook">
						<img src="<?php echo $style_dir; ?>/theme_assets/images/facebook.png" alt="" />
					</a>
				</li>
				<li>
					<a href="#" title="Contact" class="contact_link">
						<img src="<?php echo $style_dir; ?>/theme_assets/images/twitter.png" alt="" />
					</a>
				</li>
				<li>
					<a href="#" title="Search" class="search_link">
						<img src="<?php echo $style_dir; ?>/theme_assets/images/dribbble.png" alt="" />
					</a>
				</li>
			</ul>
		
		</nav><!-- #social_menu_menu -->
	
	</div><!-- .wrap_for_static_menu -->

</header>