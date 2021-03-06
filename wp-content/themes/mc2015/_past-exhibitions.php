<?php 
	$open = false;
	$year = 0;
	$today = date( 'Y-m-d' );
	$past_exhibitions = new WP_Query( array(
							'post_type' => 'exhibition',
							'posts_per_page' => 999999999,
							'meta_query' => array(
								array(
									'key'     => '_date-end',
									'value'   => $today,
									'compare' => '<',
									'type'    => 'CHAR'
								)
							),
							'orderby' => 'meta_value',
							'meta_key' => '_date-start',
							'order' => 'DESC'
						) );

	$connected = new WP_Query( array(
	  'connected_type' => 'exhibitions_to_artists',
	  'connected_items' => $past_exhibitions->posts,
	  'nopaging' => true,
	  'post_status' => array(
			'publish',
			'draft'
		)
	) );

	p2p_distribute_connected($past_exhibitions->posts, $connected->posts, 'connected');

	if( $past_exhibitions->have_posts() ) :
?>
<div class="past-exhibitions">
	<div class="exhibition-type"><?php _e( 'Past exhibitions', 'mor'); ?></div>

	<?php 
		while( $past_exhibitions->have_posts() ) : $past_exhibitions->the_post();
			global $post;
			$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id() , 'medium');
	?>

		<?php 
			if( $year != get_the_time('Y') ){
				$start_date = get_post_meta( get_the_ID(), '_date-start', true );

				$year = strtok( $start_date , '-');

				if( $open == true ){
					echo '</div></div>';
					$open = false;
				}
		?>
		<div class="past-exhibition-by-year">
			<h2 class="past-exhibition-year"><a href="#"><?php echo $year; ?></a></h2>
			<div class="exhibition-group">
				<button class="exhibition-close">x</button>
		<?php
				$open = true;
			}
		?>
				<div class="exhibition-past">
					<a href="<?php the_permalink(); ?>" class="exhibition-link"></a>
					<div class="exhibition-img" style="background-image: url(<?php echo $image_attributes[0]; ?>)">
						<div>
							<span class="read-more"><?php _e( 'View exhibition', 'mor'); ?></span>
						</div>
					</div>
					<h2 class="exhibition-title"><?php the_title(); ?></h2>
					<?php if(count($post->connected) > 1){ ?>
						<h2 class="exhibition-artist"><?php _e( 'Group exhibition', 'mor'); ?></h2>
					<?php }
						else if(count($post->connected) == 1){ ?>
						<h2 class="exhibition-artist"><?php echo $post->connected[0]->post_title; ?></h2>
					<?php } ?>
					<h2 class="exhibition-artist"></h2>
					<h4 class="exhibition-detail"><?php $lafecha = MCG::get_exhibition_date( $post ); echo $lafecha['result']; ?></h4>
				</div>
	<?php 
		endwhile; 

		if( $open == true ){
			echo '</div></div>';
			$open = false;
		}
	?>
</div>
<?php endif; ?>