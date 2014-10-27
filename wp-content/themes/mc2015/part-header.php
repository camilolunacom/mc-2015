<header class="navigation-menu" role="banner">
	<div class="logo">
		<a class="icon-logo" href="<?php echo home_url(); ?>/" rel="home"></a>
	</div>
	<nav role="navigation">
		<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
	</nav>
	<?php kc_ml_list_languages(false) ?>
	<?php get_template_part('prod', 'team'); ?>
</header>