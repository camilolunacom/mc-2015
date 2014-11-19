<?php 
	get_header(); 
	get_template_part('part', 'header'); 
	global $post;
	$data = MCG::$exhibition_data;
?>
<div class="wrap">
	<main role="main">
		<?php while(have_posts()) : the_post(); ?>
		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<h1 class="post-title"><?php the_title(); ?></h1>
			<h2 class="post-subtitle"><?php echo MCG::$exhibition_data['date']['result']; ?></h2>

			<?php if ( $data['images'] ) { ?>
			<div class="post-gallery">
				<div class="owl-carousel">
					<?php foreach ( $data['images'] as $c => $img ) { ?>
					<figure>
						<img src="<?php echo $img['medium'][0] ?>" alt="">
						<?php 
							$text = $img['title'];
							preg_match( '#\((.*?)\)#' , $text , $match );
							$line1 = preg_replace( "/\([^)]+\)/" , "" , $text );
						?>
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
					<?php if ( $pr = get_post_meta(get_the_ID(), '_press-release', true) ) { ?>
					<div class="post-attachment">
						<a href="<?php echo wp_get_attachment_url( $pr ) ?>" class="post-attachment-link">
							<div class="icon-doc"></div>
							<div class="post-attachment-text"><?php _e( 'Press release', 'mor'); ?></div>
						</a>
					</div>
					<?php } ?>
					<?php get_template_part( 'post', 'share' ); ?>
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