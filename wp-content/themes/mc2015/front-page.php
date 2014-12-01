<?php 
	get_header();
	$_images = kc_get_option( 'mcg', 'gallery', 'images' );
	if ( isset($_images['selected']) ) { 
		$img_count = count( $_images['selected'] );
		$rand_img = rand( 0, $img_count-1 );
		$img = $_images['selected'][$rand_img];
		$full = wp_get_attachment_image_src( $img, 'full' );
	}
?>
	<div class="wrap index">
		<main class="index vertical-align" role="main"   style="background-image:url(<?php echo $full[0] ?>); ?>)">

			<div class="logo">
				<a class="icon-logo" href="<?php echo home_url(); ?>/" rel="home"></a>
			</div>

			<?php 
				kc_ml_list_languages(false, 'language_code'); 
				get_template_part('prod', 'team');
				$text = get_the_title( $img );
				preg_match( '#\((.*?)\)#' , $text , $match );
				$line1 = preg_replace( "/\([^)]+\)/" , "" , $text );
				$line2 = str_replace(array( '(', ')' ), '', $match[0] );
			?>

			<div class="picture-credits">
				<span class="picture-artist"><?php echo $line1; ?></span>
				<span class="picture-title"><?php echo $line2; ?></span>
			</div>

			<div class="index-menu">
				<nav role="navigation">
					<?php wp_nav_menu(array('theme_location' => 'primary')); ?>
				</nav>
				<div class="announcements">
					<span><?php the_post(); echo get_the_content(); ?></span>
				</div>
			</div>
			<?php get_template_part('footer-content'); ?>
		</main>
	</div>
<?php get_footer(); ?>