<?php get_header() ?>

		<div id="content" role="main">
		<?php 
			$url = $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		   	if (preg_match("/\Dpast\D/", $url)) {
				$range = "past";
			} elseif (preg_match("/\Dfuture\D/", $url)) {
				$range = "future";
			}else{
				$range = "present";
			}
		?>
		<!-- <h1><?=$range?></h1> -->
		<?php do_action( 'kct_before_loop' ) ?>

		<?php 
		if($range == "past"){
			if ( have_posts() ) {
				mcgTheme::exhibition_grid();
			}
		}else{ ?>

		<?php
			if ( have_posts() ) {
				mcgTheme::exhibition_slideshow();
			}
		}
		
		wp_reset_postdata();
		
		?>
		<?php do_action( 'kct_after_loop' ) ?>
		</div>

<?php get_footer() ?>
