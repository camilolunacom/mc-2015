<?php 
	$open = false;
	$year = 0;
	$past_exhibitions = new WP_Query( array(
							'post_type' => 'exhibition',
							'posts_per_page' => -1
						) );

	if( $past_exhibitions->have_posts() ) :
?>
<div class="past-exhibitions">
	<div class="exhibition-type"><?php _e( 'Past exhibitions', 'mor'); ?></div>

	<?php 
		while( $past_exhibitions->have_posts() ) : $past_exhibitions->the_post();

			$image_attributes = wp_get_attachment_image_src($attachment_id, 'medium');
	?>

		<?php 
			if( $year != get_the_time('Y') ){
				$year = get_the_time('Y');

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
					<div class="exhibition-img" style="background-image: url(<?php echo $image_attributes[0]; ?>)"><a href="<?php the_permalink(); ?>"></a></div>
					<h2 class="exhibition-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<h4 class="exhibition-detail"><?php echo MCG::$exhibition_data['date']['result']; ?></h4>
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