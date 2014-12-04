<?php
	$args = array('post_type' => 'artist', 'posts_per_page' => 50, 'orderby' => 'menu_order', 'order' => 'ASC');
	$loop = new WP_Query($args);
?>
<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<ul class="select-display">
			<li class="active"><a id="disp-thumb" href="#"><span><?php _e( 'Thumbnails', 'mor'); ?></span><span class="icon-grid"></span></a></li>
			<li><a id="disp-list" href="#"><span class="icon-list"></span><span><?php _e( 'List', 'mor'); ?></span></a></li>
		</ul>
		<ul class="artists thumb">
			<?php while ( $loop->have_posts() ) : $loop->the_post();
				$attachment_id = get_post_thumbnail_id($post_id);
				$image_attributes = wp_get_attachment_image_src($attachment_id, 'large');
			?>
			<li class="artist thumb" style="background-image: url(<?php echo $image_attributes[0]; ?>)">
				<a href="<?php echo the_permalink(); ?>" class="artist-name">
					<span><?php echo the_title(); ?></span>
					<div class="view-artist"><?php _e( 'View artist', 'mor'); ?></div>
					<a href="<?php echo the_permalink(); ?>" class="artist-link"><?php echo the_title(); ?></a>
				</a>
			</li>
			<?php endwhile; ?>
		</ul>
	</main>
</div>
<?php get_footer(); ?>