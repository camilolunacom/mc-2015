<?php get_header() ?>

		<div id="content" role="main">
		<?php do_action( 'kct_before_loop' ) ?>
		<?php
			$q = new WP_Query( array(
				'post_type'      => array('exhibition'),
				'posts_per_page' => -1,
				'meta_key'       => '_date-start',
				'orderby'        => 'meta_value',
				'order'        => 'DESC',

			) );
			if ( $q->have_posts() ) {
				mcgTheme::exhibition_slideshow( $q );
			}
			wp_reset_postdata();
		?>
		<?php do_action( 'kct_after_loop' ) ?>
		</div>

<?php get_footer() ?>
