<?php 
	get_header();
	get_template_part('part', 'header');
	$data = MCG::get_artist_data();
?>
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

			<?php if ( isset($data['images']) ) { ?>
			<div class="post-gallery">
				<div class="owl-carousel">
					<?php foreach ( $data['images'][1] as $c => $i ) { ?>

					<?php 
						$text = $i['title'];
						preg_match( '#\((.*?)\)#' , $text , $match );
						$line1 = preg_replace( "/\([^)]+\)/" , "" , $text );
					?>
						<figure>
							<img src="<?php echo $i['img']['medium'][0] ?>" alt="">
							<figcaption>
								<div class="line1"><?php echo $line1; ?></div>
								<div class="line2"><?php echo $match[0]; ?></div>
							</figcaption>
						</figure>
					<?php } ?>
					
				</div>
				<div class="gallery-controls"></div>
			</div>
			<?php } ?>

			<div class="post-content">
				<?php the_content(); ?>
				<div class="post-actions">
					<?php if ( $cv = get_post_meta(get_the_ID(), '_cv', true) ) { ?>
					<div class="post-attachment">
						<a href="<?php echo wp_get_attachment_url( $cv ) ?>" class="post-attachment-link">
							<div class="icon-download"></div>
							<div class="post-attachment-text"><?php _e( 'Download CV', 'mor'); ?></div>
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