<?php
	$args = array( 'post_type' => 'exhibition', 'posts_per_page' => 1 );
	$loop = new WP_Query( $args );
?>
<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<?php 
			if( $loop-> have_posts() ) : $loop->the_post(); 
				global $post; 
				$image_attributes = wp_get_attachment_image_src( get_post_thumbnail_id() , 'medium');
		?>
		<div class="exhibition-current" style="background-image: url(<?php echo $image_attributes[0]; ?>)">
			<div class="exhibition-content">
				<div class="exhibition-type">Current exhibition</div>
				<a  href="<?php the_permalink(); ?>" class="call-to-action">
					<h2 class="exhibition-title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
					<h4 class="exhibition-detail"><?php $lafecha = MCG::get_exhibition_date( $post ); echo $lafecha['result']; ?></h4>
					<div class="exhibition-text">
						<?php the_content(); ?>
					</div>
				</a>
				<?php get_template_part('post', 'share'); ?>
			</div>
		</div>
		<?php endif; ?>
		<?php get_template_part('_past', 'exhibitions'); ?>
	</main>
</div>
<?php get_footer(); ?>