<?php
	$today = date( 'Y-m-d' );
	$args = array( 
		'post_type' => 'exhibition', 
		'posts_per_page' => 1,
		'meta_query' => array(
						'relation'=>'AND',
						array(
							'key'     => '_date-start',
							'value'   => $today,
							'compare' => '<',
							'type'    => 'CHAR'
						),
						array(
							'key'     => '_date-end',
							'value'   => $today,
							'compare' => '>',
							'type'    => 'CHAR'
						)
					)
	);
	$loop = new WP_Query( $args );
?>
<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<?php 
			if( $loop-> have_posts() ) : $loop->the_post(); 
				global $post; 
				$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id() , 'medium');
				$artists = get_posts(array(
			  		'connected_type' => 'exhibitions_to_artists',
			  		'connected_items' => $post,
			  		'nopaging' => true,
			  		'suppress_filters' => false
			  		)
				);
		?>
		<div class="exhibition-current" style="background-image: url(<?php echo $image_attributes[0]; ?>)">
			<a href="<?php the_permalink(); ?>" class="exhibition-link"></a>
			<div class="exhibition-content">
				<div class="exhibition-type"><?php _e('Current exhibition', 'mor'); ?></div>
				<?php foreach ($artists as $artist) { ?>
					<h2 class="exhibition-artist"><?php echo $artist->post_title ?></h2>
				<?php } ?>
				<h2 class="exhibition-title"><?php the_title(); ?></h2>
				<div class="exhibition-text">
					<?php the_content(); ?>
				</div>
			</div>
		</div>
		<?php endif; ?>
		<?php get_template_part('_past', 'exhibitions'); ?>
	</main>
</div>
<?php get_footer(); ?>