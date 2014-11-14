<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<?php while(have_posts()) : the_post(); ?>
		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h3 class="post-date"><?php the_date(); ?></h3>
			<h1 class="post-title"><?php the_title(); ?></h1>
			<div class="post-gallery">
				<figure>
					<img src="<?php echo wp_get_attachment_url(get_post_thumbnail_id($post->ID)); ?>" alt="">
				</figure>
			</div>
			<div class="post-content">
				<?php the_content(); ?>
				<div class="post-actions">
					<div class="post-attachment">
						<a href="" class="post-attachment-link">
							<div class="icon-doc"></div>
							<div class="post-attachment-text">Press release</div>
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