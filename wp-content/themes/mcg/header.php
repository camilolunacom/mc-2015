<?php

ob_start();
language_attributes();
$lang_attr = ob_get_clean();

?>
<!doctype html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php echo $lang_attr; ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php echo $lang_attr; ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php echo $lang_attr; ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php echo $lang_attr; ?>> <!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ) ?>">
	<title><?php wp_title('') ?></title>
	<?php wp_head() ?>
</head>

<body <?php body_class() ?>>
	<div id="fb-root"></div>
	<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, 'script', 'facebook-jssdk'));</script>
	<div id="page">
		<header id="branding" role="banner">
			<?php do_action( 'kct_before_branding' ) ?>
			<hgroup>
				<h1 id="site-title"><a class="no-ajaxy" href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><span class="visuallyhidden"><?php bloginfo('name') ?></span></a></h1>
			</hgroup>
			<?php kc_ml_list_languages( false ) ?>
			<?php wp_nav_menu( array(
				'theme_location'  => 'main',
				'container'       => 'nav',
				'container_id'    => 'main-menu',
				'container_class' => 'menu-container main-menu-container',
				'menu_class'      => 'menu main-menu',
				'fallback_cb'     => false
			) ); ?>
			<?php wp_nav_menu( array(
				'theme_location' => 'social',
				'container'      => '',
				'menu_id'        => 'social-menu',
				'fallback_cb'    => false,
				'link_before'    => '<span class="visuallyhidden">',
				'link_after'     => '</span>'
			) ); ?>
			<?php kct_do_sidebar( 'wa-header', false ) ?>
			<?php do_action( 'kct_after_branding' ) ?>
		</header>