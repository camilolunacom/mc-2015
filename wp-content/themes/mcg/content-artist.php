<?php
	$data = MCG::get_artist_data();
?>
				<?php do_action( 'kct_before_entry' ); ?>
				<article id="post-<?php the_ID() ?>" <?php post_class() ?>>
					<header class="entry-title">
						<h1><?php the_title() ?></h1>
						<?php if ( $data ) { ?>
						<ul>
							<?php foreach ( $data as $k => $v ) { ?>
							<li><a href="#artist-<?php echo $k ?>"><?php echo $v[0] ?></a></li>
							<?php } ?>
						</ul>
						<?php } ?>
						<?php do_action( 'kct_after_entry_title' ); ?>
					</header>

					<?php do_action( 'kct_before_entry_content' ); ?>
					<div class="entry-content<?php if ( isset($data['pub']) ) echo ' has-publication'?>">
						<?php if ( isset($data['images']) || isset($data['video']) ) { ?>
						<div id="artist-media" class="ss-wrap">
							<?php if ( isset($data['images']) ) { ?>
							<section id="artist-images" class="ss-images">
								<h2 class="assistive-text"><?php echo $data['images'][0] ?></h2>
								<ul class="slides">
									<?php foreach ( $data['images'][1] as $c => $i ) { ?>
									<li class="item" data-index="<?php echo $c ?>">
										<h3><?php echo $i['title'] ?></h3>
										<img alt="" src="<?php echo $i['img']['medium'][0] ?>" /> <!-- width="<?php echo $i['img']['medium'][1] ?>" height="<?php echo $i['img']['medium'][2] ?>" -->
										<a href="<?php echo $i['img']['full'][0] ?>" title="<?php _e('View original size', 'mcg') ?>" class="zoom ss-button" rel="prefetch"><span class="visuallyhidden"><?php _e('Zoom', 'mcg') ?></span></a>
									</li>
									<?php } ?>
								</ul>
							</section>
							<?php } if ( isset($data['video']) ) { ?>
							<section id="artist-video" class="ss-video">
								<h2 class="assistive-text"><?php echo $data['video'][0] ?></h2>
								<ul class="slides">
									<?php foreach ( $data['video'][1] as $vid ) { ?>
									<li class="item">
										<?php if ( isset($vid['value']) ) echo "<h3>".trim($vid['value'])."</h3>\n" ?>
										<?php if ( isset($vid['key']) ) echo apply_filters( 'the_content', trim($vid['key']) ) ?>
									</li>
									<?php } ?>
								</ul>
							</section>
							<?php } ?>
						</div>
						<?php } ?>

						<?php if ( isset($data['bio']) ) { ?>
						<section id="artist-bio">
							<h2><?php echo $data['bio'][0] ?></h2>
							<?php the_content() ?>
							<?php if ( $cv = get_post_meta(get_the_ID(), '_cv', true) ) { ?>
							<a href="<?php echo wp_get_attachment_url( $cv ) ?>" class="icon doc"><?php _e('Artist CV', 'mcg') ?></a>
							<?php } ?>
						</section>
						<?php } ?>

						<?php if ( isset($data['pub']) ) { ?>
						<section id="artist-pub">
							<h2><?php echo $data['pub'][0] ?></h2>
							<ul>
								<?php
									foreach ( $data['pub'][1] as $i ) {
										if ( $i['url'] ) {
											$p_url = $i['url'];
											$p_rel = 'publication';
										}
										else {
											$p_url = $i['img']['full'][0];
											$p_rel = '';
										}
								?>
								<li>
									<h3><?php echo $i['title'] ?></h3>
									<a href="<?php echo $p_url ?>" <?php if ( $p_rel ) echo ' rel="'.$p_rel.'"'?> title="<?php esc_attr_e($i['title']) ?>"><img alt="" src="<?php echo $i['img']['thumb'][0] ?>" /></a>
									<?php if ( $i['year'] ) echo '<span>'.$i['year'].'</span>' ?>
								</li>
								<?php } ?>
							</ul>
							<?php
							?>
						</section>
						<?php } ?>

						<?php if ( isset($data['news']) ) { ?>
						<section id="artist-news">
							<h2><?php echo $data['news'][0] ?></h2>
							<?php echo $data['news'][1] ?>
						</section>
						<?php } ?>
					</div>
					<?php do_action( 'kct_after_entry_content' ); ?>

				</article>
				<?php do_action( 'kct_after_entry' ); ?>
