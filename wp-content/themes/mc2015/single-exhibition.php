<?php 
	get_header(); 
	get_template_part('part', 'header'); 
	global $post;
	$data = MCG::$exhibition_data;
?>
<div class="wrap">
	<main role="main">
		<?php while(have_posts()) : the_post();
			$artists = get_posts(array(
		  		'connected_type' => 'exhibitions_to_artists',
		  		'connected_items' => $post,
		  		'nopaging' => true,
		  		'suppress_filters' => false, 
		  		'post_status' => array(
		  				'publish',
		  				'draft'
		  			)
		  		)
			);
		?>
		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
			<?php foreach ($artists as $artist) { ?>
				<h2 class="post-title"><?php echo $artist->post_title ?></h2>
			<?php } ?>
			<h1 class="post-subtitle"><?php the_title(); ?></h1>
			<div class="post-info"><?php the_content(); ?></div>

			<?php if ( $data['images'] ) { ?>
			<div class="post-gallery">
				<div class="loader"></div>
				<button type="button" class="exit-fs"><span><?php _e( 'Close', 'mor'); ?></span><span class="icon-close"></span></button>
				<div class="owl-carousel">
					<?php foreach ( $data['images'] as $c => $img ) { ?>
					<figure>
						<div class="img">
							<img class="owl-lazy" data-src="<?php echo $img['medium'][0] ?>" alt="">	
						</div>
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
				<?php if(count($data['images']) > 1){ ?>
					<div class="gallery-controls"></div>
				<?php } ?>
			</div>
			<?php } ?>
			<div class="post-content">
				<div class="post-actions">
					<?php if ( $pr = get_post_meta(get_the_ID(), '_press-release', true) ) { ?>
					<div class="post-attachment">
						<a href="<?php echo wp_get_attachment_url( $pr ) ?>" class="post-attachment-link" target="_blank">
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
<?php get_footer(); ?>