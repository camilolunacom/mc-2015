<?php get_header() ?>

		<div id="content" role="main">
			<?php do_action( 'kct_before_loop' ) ?>
			<?php
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
						get_template_part( 'content', apply_filters('kct_content_template', get_post_type()) );
					}

					kct_paginate_links();
				}
				else {
					get_template_part( 'content', apply_filters('kct_content_template', '404') );
				}
			?>
			<?php do_action( 'kct_after_loop' ) ?>
			<?php if ( is_home() ) kct_do_sidebar( 'wa-news' ) ?>
		</div>

<?php get_footer() ?>
