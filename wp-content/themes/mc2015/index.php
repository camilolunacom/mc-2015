<?php get_header(); ?>
<div class="wrap">
	<main class="index vertical-align" role="main"   style="background:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>)">
		<figure class="logo">
			<a href="<?php echo home_url(); ?>/" rel="home">
				<img src="<?php bloginfo('template_directory'); ?>/img/logo.svg" alt="Mor-Charpentier">
			</a>
		</figure>
		<?php kc_ml_list_languages(false) ?>
		<?php get_template_part('prod', 'team'); ?>
		<?php get_template_part('picture', 'credits'); ?>
		<div class="index-menu">
			<nav role="navigation">
				<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
			</nav>
			<div class="announcements">
				<span>Open today from 11:00am to 6:00pm</span>
			</div>
		</div>
		<?php get_template_part('footer-content'); ?>
	</main>
</div>
<?php get_footer(); ?>