<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<div class="the-gallery-pic" style="background-image:url(http://dev.mor-charpentier.com/wp-content/uploads/2014/02/Mor_Charpentier_2014jan-212.jpg)"></div>
			<div class="the-gallery-pic" style="background-image:url(http://dev.mor-charpentier.com/wp-content/uploads/2012/04/IMG_00621-847x565.jpg)"></div>
			<div <?php post_class(); ?> id="the-gallery">
				<?php the_content(); ?>
				<div class="contact-info">
					<div class="contact-info-city">
						<h2 class="contact-city-name">Paris</h2>
						<p class="contact-city-details">8, Rue Saint-Claude, Paris, France 75003</p>
						<p class="contact-city-details">M°8, Saint-Sébastien Froissart</p>
						<p class="contact-city-details"><?php _e( 'Tue/Sat 11am-7pm', 'mor'); ?></p>
						<a href="mailto:contact@mor-charpentier.com" class="contact-city-mail">contact@mor-charpentier.com</a>
						<p class="contact-city-details">+33 (0) 1 44 54 01 58</p>
					</div>
				</div>
				<?php get_template_part('part', 'social'); ?>
				<div class="arrow"><i class="icon-arrow-down"></i></div>
			</div>
		<?php endwhile; ?>
	</main>
	<section class="map">
		<div id="map-canvas"></div>
	</section>
	<section class="newsletter">
		<h2 class="newsletter-title"><?php _e('Newsletter', 'mor'); ?></h2>
		<?php echo do_shortcode('[mc4wp_form]'); ?>
		<?php get_template_part('events'); ?>
	</section>
</div>
<?php get_template_part('part', 'footer'); ?>
<?php get_footer(); ?>