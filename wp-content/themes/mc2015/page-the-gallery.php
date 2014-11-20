<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			<div <?php post_class(); ?> id="the-gallery">
				<?php the_content(); ?>
				<div class="contact-info">
					<div class="contact-info-city">
						<h2 class="contact-city-name">Paris</h2>
						<p class="contact-city-details"><?php _e( 'Tuesday-Saturday / 11am-7pm', 'mor'); ?></p>
						<p class="contact-city-details">+33 (0) 1 44 54 01 58</p>
						<a href="mailto:contact@mor-charpentier.com" class="contact-city-mail">contact@mor-charpentier.com</a>
					</div>
					<div class="contact-info-city">
						<h2 class="contact-city-name">Bogotá</h2>
						<p class="contact-city-details">+57 (1) 618 2746</p>
						<br />
						<a href="mailto:bogota@mor-charpentier.com" class="contact-city-mail">bogota@mor-charpentier.com</a>
					</div>
				</div>
				<ul class="social-networks">
					<li class="social-network"><a href="" class="icon-facebook"></a></li>
					<li class="social-network"><a href="" class="icon-twitter"></a></li>
					<li class="social-network"><a href="" class="icon-instagram"></a></li>
				</ul>
			</div>
			<div class="arrow"><i class="icon-arrow-down"></i></div>
		<?php endwhile; ?>
	</main>
	<section class="map">
		<div id="map-canvas"></div>
	</section>
	<section class="newsletter">
		<h2 class="newsletter-title">The gallery's newsletter</h2>
		<h4 class="newsletter-subtitle">Monthly.no spam.</h4>
		<?php echo do_shortcode('[mc4wp_form]'); ?>
		<?php get_template_part('events'); ?>
	</section>
</div>
<?php get_template_part('part', 'footer'); ?>
<?php get_footer(); ?>