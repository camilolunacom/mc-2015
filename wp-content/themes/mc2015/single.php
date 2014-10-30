<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<?php while(have_posts()) : the_post(); ?>

		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h1 class="post-title"><?php the_title(); ?></h1>
			<div class="post-gallery">
				<div class="owl-carousel">
					<figure>
						<img src="http://dev.mor-charpentier.com/wp-content/uploads/2014/05/13-1024x731.jpg" alt="">
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
					<div class="post-attachment">
						<a href="" class="post-attachment-link">
							<div class="icon-download"></div>
							<div class="post-attachment-text">Download CV</div>
						</a>
					</div>
					<div class="post-share"></div>
				</div>
			</div>
			<?php $meta_values = get_post_meta( get_the_ID(), '_images', true); ?>
		</article>

		<?php endwhile; ?>
	</main>
</div>
<?php get_template_part('part', 'footer'); ?>
<?php get_footer(); ?>