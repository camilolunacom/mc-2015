<?php get_header(); ?>
<?php get_template_part('part', 'header'); ?>
<div class="wrap">
	<main role="main">
		<?php while(have_posts()) : the_post(); ?>
		<article <?php post_class(); ?> id="post-<?php the_ID(); ?>">
		<?php $date_field = get_post_meta( get_the_ID(), '_date-field', true ); ?>
		<?php if( $date_field ){ ?>
			<h3 class="post-date"><?php echo $date_field; // the_date(); ?></h3>
		<?php }else{ ?>
			<h3 class="post-date"><?php echo the_date(); ?></h3>
		<?php } ?>
			<h1 class="post-title"><?php the_title(); ?></h1>
			<div class="post-content">
				<?php the_content(); ?>
				<div class="post-actions">
					<?php if ( $pr = get_post_meta(get_the_ID(), '_press-release', true) ) { ?>
					<div class="post-attachment">
						<a href="<?php echo wp_get_attachment_url( $pr ) ?>" class="post-attachment-link" target="_blank">
							<div class="icon-doc"></div>
							<div class="post-attachment-text"><?php _e( 'Press release', 'mor'); ?></div>
						</a>
					</div>
					<?php } ?>
					<?php get_template_part( 'post', 'share' ); ?>
				</div>
			</div>
			<?php $meta_values = get_post_meta( get_the_ID(), '_images', true); ?>
		</article>
		<?php get_template_part('events'); ?>
		<?php endwhile; ?>
	</main>
</div>
<?php get_footer(); ?>