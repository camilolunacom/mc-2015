<?php get_header(); ?>
	<div class="wrap index">
		<main class="index vertical-align" role="main"   style="background:url(http://dev.mor-charpentier.com/wp-content/uploads/2013/01/Julieta-Aranda-For-I-am-not-sleepy-yet-and-I-dont-want-to-rest.jpg); ?>)">
			<div class="logo">
				<a class="icon-logo" href="<?php echo home_url(); ?>/" rel="home"></a>
			</div>
			<?php kc_ml_list_languages(false) ?>
			<?php get_template_part('prod', 'team'); ?>
			<?php get_template_part('picture', 'credits'); ?>
			<div class="index-menu">
				<nav role="navigation">
					<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
				</nav>
				<div class="announcements">
					<span><?php the_post(); echo get_the_content(); ?></span>
				</div>
			</div>
			<?php get_template_part('footer-content'); ?>
		</main>
	</div>
	<?php get_footer(); ?>