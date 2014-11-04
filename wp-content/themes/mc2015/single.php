<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<?php while(have_posts()) : the_post(); ?>
		<div class="prev-post-link">
			<?php next_post_link('%link', '<i class="icon-arrow-right"></i>%title'); ?>	
		</div>
		<div class="next-post-link">
			<?php previous_post_link('%link', '%title<i class="icon-arrow-right"></i>'); ?>
		</div>
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
		<div class="events">
			<h3>Next fairs</h3>
			<ul>
				<li>
					FIAC<br />22-26 October
				</li>
				<li>
					ArtBo<br />23-27 October
				</li>
			</ul>
			<br />
			<h3>Current show</h3>
			<ul>
				<li>
					Illimitée promesse d'avenir
				</li>
			</ul>
			<p>Uriel Orlow<br/>& Natacha Nisic<br />5th of June - 2nd of August</p>
		</div>
		<?php endwhile; ?>
	</main>
</div>
<?php get_template_part('part', 'footer'); ?>
<?php get_footer(); ?>