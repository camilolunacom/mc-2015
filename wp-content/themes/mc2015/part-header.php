<header class="navigation-menu" role="banner">
	<div class="logo">
		<a class="icon-logo" href="<?php echo home_url(); ?>/" rel="home"></a>
	</div>
	<div id="hamburguer" class="icon-menu"></div>
	<nav role="navigation">
		<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
	</nav>
	<div class="nav-footer">
		<ul class="social-networks">
			<li class="social-network"><a href="" class="icon-facebook"></a></li>
			<li class="social-network"><a href="" class="icon-twitter"></a></li>
			<li class="social-network"><a href="" class="icon-instagram"></a></li>
		</ul>
		<?php kc_ml_list_languages( false, 'language_code' ); ?>
		<?php get_template_part('prod', 'team'); ?>
	</div>
</header>