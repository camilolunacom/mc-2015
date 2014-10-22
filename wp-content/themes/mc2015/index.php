<?php get_header(); ?>
<div class="wrap">
	<main role="main"   style="background:url(<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>)">
		<figure class="logo">
			<a href="<?php echo home_url(); ?>/" rel="home">
				<img src="" alt="Mor-Charpentier">
			</a>
		</figure>
		<?php kc_ml_list_languages(false) ?>
		<?php get_template_part('prod', 'team'); ?>
		<?php get_template_part('picture', 'credits'); ?>
		<nav role="navigation">
			<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
		</nav>
		<div class="announcements">Open today from 11:00am to 6:00pm</div>
		<?php get_template_part('footer-content'); ?>
	</main>
</div>
<?php get_footer(); ?>