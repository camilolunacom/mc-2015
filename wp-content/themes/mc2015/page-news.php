<?php
	$args = array( 'post_type' => 'post', 'posts_per_page' => 50 );
	$loop = new WP_Query( $args );
?>
<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<ul class="news">
			<?php while ( $loop->have_posts() ) : $loop->the_post();
				$attachment_id = get_post_thumbnail_id($post_id);
				$image_attributes = wp_get_attachment_image_src($attachment_id, 'large');
			?>
			<li class="news-item" style="background-image: url(<?php echo $image_attributes[0]; ?>)">
				<div>
					<span class="news-date"><?php echo the_date('d/m/Y'); ?></span>
					<h2 class="news-title"><?php echo the_title(); ?></h2>
					<div class="news-excerpt">
						<?php echo the_excerpt(); ?>
					</div>
					<a href="<?php echo the_permalink(); ?>" class="read-more"><?php _e('Read more', 'mor'); ?></a>
				</div>
			</li>
			<?php endwhile; ?>
		</ul>
	</main>
</div>
<?php get_footer(); ?>