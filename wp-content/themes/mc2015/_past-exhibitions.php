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
	?>

		<?php 
			if( $year != get_the_time('Y') ){
				$year = get_the_time('Y');

				if( $open = true ){
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
					<div class="exhibition-img" style="background-image: url(http://dev.mor-charpentier.com/wp-content/uploads/2013/09/mor.charpentier.Palimpsestes.Septembre-2013.jpg)"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/"></a></div>
					<h2 class="exhibition-title"><a href="http://dev.mor-charpentier.com/exhibition/palimpsestes/"><?php the_title(); ?></a></h2>
					<h4 class="exhibition-detail">6 Septembre-11 Octobre</h4>
				</div>
		<?php 		
			if( $open = true ){
				echo '</div></div>';
				$open = false;
			}	
		?>
			</div>
		</div>
	<?php 
		endwhile; 
	?>
</div>
<?php endif; ?>