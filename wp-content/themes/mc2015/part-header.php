<header role="banner">
	<h1><a href="<?php echo home_url(); ?>/" rel="home"><?php bloginfo('name');?></a></h1>
	<figure class="logo">
		<a href="<?php echo home_url(); ?>/" rel="home">
			<img src="" alt="Mor-Charpentier">
		</a>
	</figure>
	<nav role="navigation">
		<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
	</nav>
</header>