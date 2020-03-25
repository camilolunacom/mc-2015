<header class="navigation-menu" role="banner">
	<div class="logo">
		<a class="icon-logo" href="<?php echo home_url(); ?>/" rel="home"></a>
	</div>
	<div id="hamburguer" class="icon-menu"></div>
	<nav role="navigation">
		<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
	</nav>

	<div class="nav-footer">
		<?php get_template_part('part', 'social'); ?>
		<?php kc_ml_list_languages( false, 'language_code' ); ?>
		<?php get_template_part('prod', 'team'); ?>
	</div>
</header>