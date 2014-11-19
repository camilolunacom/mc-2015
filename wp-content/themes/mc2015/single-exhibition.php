<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<?php while(have_posts()) : the_post(); ?>
		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h1 class="post-title"><?php the_title(); ?></h1>
			<h2 class="post-subtitle">6 Septembre-11 Octobre 2014</h2>
			<div class="post-gallery">
				<div class="owl-carousel">
					<figure>
						<img src="http://dev.mor-charpentier.com/wp-content/uploads/2013/10/Still-Aftershock4.jpg" alt="">
						<figcaption>
							<div class="line1">Fontainebleau, Plaza Venezuela</div>
							<div class="line2">2003, Digital photograph, 125 x 124 cm.</div>
						</figcaption>
					</figure>
					<figure>
						<img src="http://dev.mor-charpentier.com/wp-content/uploads/2013/01/CCC-1024x693.jpg" alt="">
						<figcaption>
							<div class="line1">Fontainebleau, Plaza Venezuela</div>
							<div class="line2">2003, Digital photograph, 125 x 124 cm.</div>
						</figcaption>
					</figure>
				</div>
				<div class="gallery-controls"></div>
			</div>
			<div class="post-content">
				<?php the_content(); ?>
				<div class="post-actions">
					<?php if ( $pr = get_post_meta(get_the_ID(), '_press-release', true) ) { ?>
					<div class="post-attachment">
						<a href="<?php echo wp_get_attachment_url( $pr ) ?>" class="post-attachment-link">
							<div class="icon-doc"></div>
							<div class="post-attachment-text"><?php _e( 'Press release', 'mor'); ?></div>
						</a>
					</div>
					<?php } ?>
					<div class="post-share">
						<div class="post-share-text"><?php _e( 'Share', 'mor'); ?></div>
						<ul class="social-networks">
							<li class="social-network"><a href="" class="icon-facebook"></a></li>
							<li class="social-network"><a href="" class="icon-twitter"></a></li>
							<li class="social-network"><a href="" class="icon-instagram"></a></li>
						</ul>
					</div>
				</div>
			</div>
			<?php $meta_values = get_post_meta( get_the_ID(), '_images', true); ?>
		</article>
		<?php get_template_part('_past', 'exhibitions'); ?>
		<?php endwhile; ?>
	</main>
</div>
<?php get_template_part('part', 'footer'); ?>
<?php get_footer(); ?>