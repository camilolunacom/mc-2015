				<?php do_action( 'kct_before_entry' ); ?>
				<article id="post-<?php the_ID() ?>" <?php post_class() ?>>
					<header class="entry-title">
						<h1 class="text"><span><?php the_title() ?></span></h1>
						<?php
							global $post;
							$data = MCG::$exhibition_data;
							if ( $artists = MCG::get_exhibition_artists($post->ID) )
								echo "<p class='text artists'><span>".implode( ', ', $artists )."</span></p>\n";
							if ( $data['date']['result'] )
								echo "<p class='text date'><span>".MCG::$exhibition_data['date']['result']."</span></p>\n";
						?>
						<?php do_action( 'kct_after_entry_title' ); ?>
					</header>

					<?php if ( $data['images'] ) { ?>
					<div class="ss-wrap">
						<section class="ss-images ss-exhibitions">
							<ul class="slides">
								<?php foreach ( $data['images'] as $c => $img ) { ?>
								<li class="item" data-index="<?php echo $c ?>">
									<img alt="" title="<?php echo $img['title'] ?>" src="<?php echo $img['medium'][0] ?>" width="<?php echo $img['medium'][1] ?>" height="<?php echo $img['medium'][2] ?>"/>
									<a href="<?php echo $img['full'][0] ?>" title="<?php _e('View original size', 'mcg') ?>" class="zoom ss-button" rel="prefetch"><span class="visuallyhidden"><?php _e('Zoom', 'mcg') ?></span></a>
								</li>
								<?php } ?>
							</ul>
						</section>
					</div>
					<?php } ?>

					<?php do_action( 'kct_before_entry_content' ); ?>
					<div class="entry-content">
						<?php if ( $data['quotes'] ) { ?>
						<div class="quotes">
							<?php foreach ( $data['quotes'] as $q ) { ?>
							<blockquote>
								<?php if ( isset($q['value']) && $q['value'] ) echo wpautop( $q['value'] ) ?>
								<?php if ( isset($q['key']) && $q['key'] ) echo "<cite class='person'>{$q['key']}</cite>\n" ?>
							</blockquote>
							<?php } ?>
						</div>
						<?php	} ?>
						<?php the_content(__('Continue&hellip;', 'mcg')) ?>
					</div>
					<?php do_action( 'kct_after_entry_content' ); ?>

				</article>
				<?php do_action( 'kct_after_entry' ); ?>
