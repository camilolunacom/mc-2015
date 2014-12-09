<?php
/**
 * Register latest jQuery, load on footer
 */
function minimal_jquery_script() {
	if ( ! is_admin() ) {
		wp_deregister_script('jquery');
		wp_register_script('jquery', '//cdnjs.cloudflare.com/ajax/libs/jquery/1.11.1/jquery.min.js', false, '1.11.1', true);
	}
}
add_action('wp_enqueue_scripts', 'minimal_jquery_script');

/**
 * Theme setup
 */
function minimal_theme_setup() {
	// i18n
	load_theme_textdomain( 'mor', get_template_directory() . '/lang' );

	// Adds RSS feed links to <head> for posts and comments.
	add_theme_support('automatic-feed-links');

	// Custom menu support.
	register_nav_menu('Main', 'Primary Menu');
	register_nav_menu('Social', 'Social menu');

	// Most themes need featured images.
	add_theme_support('post-thumbnails' );
  add_image_size( 'mcg-thumb',   70,  70, true );
  add_image_size( 'mcg-grid-thumb',   280,  185, true );
  add_image_size( 'mcg-medium',   1000, 565, false );
  add_image_size( 'mcg-news',   150);
}
add_action('after_setup_theme', 'minimal_theme_setup');


/**
 * Customize Adjacent Post Link Order
 */
function wpse73190_gist_adjacent_post_where($sql) {
  if ( !is_main_query() || !is_singular() )
    return $sql;

  $the_post = get_post( get_the_ID() );
  $patterns = array();
  $patterns[] = '/post_date/';
  $patterns[] = '/\'[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}\'/';
  $replacements = array();
  $replacements[] = 'menu_order';
  $replacements[] = $the_post->menu_order;
  return preg_replace( $patterns, $replacements, $sql );
}
add_filter( 'get_next_post_where', 'wpse73190_gist_adjacent_post_where' );
add_filter( 'get_previous_post_where', 'wpse73190_gist_adjacent_post_where' );

function wpse73190_gist_adjacent_post_sort($sql) {
  if ( !is_main_query() || !is_singular() )
    return $sql;

  $pattern = '/post_date/';
  $replacement = 'menu_order';
  return preg_replace( $pattern, $replacement, $sql );
}
add_filter( 'get_next_post_sort', 'wpse73190_gist_adjacent_post_sort' );
add_filter( 'get_previous_post_sort', 'wpse73190_gist_adjacent_post_sort' );

/**
 * Remove code from the <head>
 */
remove_action('wp_head', 'wp_shortlink_wp_head', 10, 0);// http://www.tech-evangelist.com/2011/09/05/disable-remove-wordpress-shortlink/
//remove_action('wp_head', 'rsd_link'); // Might be necessary if you or other people on this site use remote editors.
//remove_action('wp_head', 'feed_links', 2); // Display the links to the general feeds: Post and Comment Feed
//remove_action('wp_head', 'feed_links_extra', 3); // Display the links to the extra feeds such as category feeds
//remove_action('wp_head', 'index_rel_link'); // Displays relations link for site index
remove_action('wp_head', 'wlwmanifest_link'); // Might be necessary if you or other people on this site use Windows Live Writer.
//remove_action('wp_head', 'start_post_rel_link', 10, 0); // Start link
//remove_action('wp_head', 'parent_post_rel_link', 10, 0); // Prev link
remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0); // Display relational links for the posts adjacent to the current post.

// http://justintadlock.com/archives/2010/07/08/lowercase-p-dangit
remove_filter( 'the_title', 'capital_P_dangit', 11 );
remove_filter( 'the_content', 'capital_P_dangit', 11 );
remove_filter( 'comment_text', 'capital_P_dangit', 31 );

// Hide the version of WordPress you're running from source and RSS feed // Want to JUST remove it from the source? Try: remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_false');
