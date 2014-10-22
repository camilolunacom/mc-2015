<?php
/* Template name: Gallery */
get_header();

?>

		<div id="content" role="main">
			<?php
				if ( have_posts() ) {
					while ( have_posts() ) {
						the_post();
			?>
			
			<header class="entry-title">
				<?php do_action( 'kct_before_entry_title' ); ?>
				<?php
					if ( $_title = get_the_title() ) {
						$title = is_singular() ? "<h1>{$_title}</h1>\n" : "<h1><a href='".get_permalink()."' title='".the_title_attribute(array('echo' => false))."'>{$_title}</a></h1>\n";
						echo apply_filters( 'kct_entry_title', $title, $_title );
					}
				?>
				<?php do_action( 'kct_after_entry_title' ); ?>
			</header>

			<?php do_action( 'kct_before_loop' ) ?>
			<?php
				$_images = kc_get_option( 'mcg', 'gallery', 'images' );
				if ( isset($_images['selected']) ) {
			?>
			<div class="ss-wrap">
				<section class="ss-images">
					<ul class="slides">
						<?php
							foreach ( $_images['selected'] as $c => $i ) {
								$full = wp_get_attachment_image_src( $i, 'full' );
						?>
						<li class="item" data-index="<?php echo $c ?>">
							<h3><?php echo get_the_title( $i ) ?></h3>
							<?php echo wp_get_attachment_image( $i, 'mcg-medium' ) ?>
							<a href="<?php echo $full[0] ?>" title="<?php _e('View original size', 'mcg') ?>" class="zoom ss-button" rel="prefetch"><span class="visuallyhidden"><?php _e('Zoom', 'mcg') ?></span></a>
						</li>
						<?php } ?>
					</ul>
				</section>
			</div>
			<?php } ?>

				<?php do_action( 'kct_before_entry' ); ?>
				<article id="post-<?php the_ID() ?>" <?php post_class() ?>>

					<?php do_action( 'kct_before_entry_content' ); ?>
					<div class="entry-content">
						<?php the_content(__('Continue&hellip;', 'mcg')) ?>
					</div>
					<?php do_action( 'kct_after_entry_content' ); ?>

				</article>
				<?php do_action( 'kct_after_entry' ); ?>

			<?php
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
