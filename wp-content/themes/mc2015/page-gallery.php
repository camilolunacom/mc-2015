<?php 
	get_header(); 
	get_template_part('part', 'header'); 
	$data = MCG::get_page_data();
?>
<div class="wrap">
	<main role="main">
		<?php while ( have_posts() ) : the_post(); ?>
			
			<?php if ( isset($data['images']) ) { ?>
			<?php $reversed = array_reverse( $data['images'][1] ); ?>
				<?php foreach($reversed as $c => $i){ ?>
					<div class="the-gallery-pic" style="background-image:url(<?php echo $i['img']['medium'][0] ?>)"></div>
				<?php } ?>
			<?php } ?>

			<div <?php post_class(); ?> id="the-gallery">
				<?php the_content(); ?>
				<div class="contact-info">
					<div class="contact-info-city">
						<address itemscope itemtype="http://schema.org/PostalAddress">
							<h2 class="contact-city-name" itemprop="addressLocality">Paris</h2>
							<p class="contact-city-details" itemprop="streetAddress">61 Rue de Bretagne, 75003 Paris</p>
							<p class="contact-city-details" itemprop="streetAddress">M° Arts et Métiers</p>
							<p class="contact-city-details" itemprop="hoursAvailable"><time itemprop="openingHours" datetime="Tu,We,Th,Fr,Sa 11:00-19:00"><?php _e( 'Tue/Sat 11am-7pm', 'mor'); ?></time></p>
							<a href="mailto:contact@mor-charpentier.com" class="contact-city-mail" itemprop="email">contact@mor-charpentier.com</a>
							<p class="contact-city-details" itemprop="telephone">+33 (0) 1 44 54 01 58</p>
						</address>
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