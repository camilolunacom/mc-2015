<?php
	//Protect against arbitrary paged values
	$paged = (get_query_var('paged')) ? absint(get_query_var('paged')) : 1;

	$args = array('post_type' => 'post', 'posts_per_page' => 10, 'paged' => $paged);
	$loop = new WP_Query($args);

	$big = 999999999;
	$p_args = array(
		'base'         => str_replace($big, '%#%', esc_url(get_pagenum_link($big))),
		'format'       => '?paged=%#%',
		'total'        => $loop->max_num_pages,
		'current'      => max(1, get_query_var('paged')),
		'show_all'     => True,
		'prev_next'    => True,
		'prev_text'    => __('<span class="icon-page-prev"></span>'),
		'next_text'    => __('<span class="icon-page-next"></span>'),
		'type'         => 'list',
		'add_args'     => False,
	);
?>
<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<div class="news-filter">
			<div class="news-filter-title"><?php _e('Filter', 'mor'); ?></div>
			<ul class="filter">
				<li class="filter-item"><a class="active" href=""><?php _e('News', 'mor'); ?></a></li>
				<li class="filter-item"><a href=""><?php _e('Art', 'mor'); ?></a></li>
				<li class="filter-item"><a href=""><?php _e('Exhibition', 'mor'); ?></a></li>
				<li class="filter-item"><a href=""><?php _e('Fair', 'mor'); ?></a></li>
				<li class="filter-item"><a href=""><?php _e('Artist', 'mor'); ?></a></li>
				<li class="filter-item"><a href=""><?php _e('Date', 'mor'); ?></a></li>
			</ul>
		</div>
		<ul class="news">
			<?php while ( $loop->have_posts() ) : $loop->the_post();
				$attachment_id = get_post_thumbnail_id($post_id);
				$image_attributes = wp_get_attachment_image_src($attachment_id, 'medium');
			?>
			<li class="news-item" style="background-image: url(<?php echo $image_attributes[0]; ?>)">
				<div>
					<span class="news-date"><?php echo the_date('d/m/Y'); ?></span>
					<h2 class="news-title"><?php echo the_title(); ?></h2>
					<div class="news-excerpt">
						<?php echo the_excerpt(); ?>
					</div>
					<?php 
						$more_link = get_post_meta( get_the_ID(), '_external-link', true );
						$more_link_active = get_post_meta( get_the_ID(), '_hide-more-link', true );
						$target = '_blank';

						if( !$more_link ){
							$more_link = get_permalink();
							$target = '_self';
						}
					?>

					<?php if( $more_link_active[0] != 'cbox2' ){ ?>
						<a target="<?php echo $target; ?>" href="<?php echo $more_link; ?>" class="read-more"><?php _e('Read more', 'mor'); ?></a>
					<?php } ?>

				</div>
			</li>
			<?php endwhile; ?>
		</ul>
		<?php echo paginate_links($p_args); ?>
	</main>
</div>
<?php get_footer(); ?>