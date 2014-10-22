<?php


# Set the content width based on the theme's design and stylesheet.
if ( ! isset( $content_width ) )
	$content_width = 810;

class mcgTheme {
	const version = '0.1';
	public static $dir_theme;
	public static $url_theme;


	public static function setup() {
		self::$dir_theme = $dir = get_template_directory();
		self::$url_theme = get_template_directory_uri();

		# The mini-lib
		require_once "{$dir}/p/krr.php";
		self::init();
	}


	public static function init() {
		# i18n
		load_theme_textdomain( 'mcg', self::$dir_theme . '/l' );

		# Menus
		register_nav_menus( array(
			'main'   => __('Main menu', 'mcg'),
			'social' => __('Social menu', 'mcg')
		) );

		# Images
		add_theme_support( 'post-thumbnails' );
		add_image_size( 'mcg-thumb',   70,  70, true );
		add_image_size( 'mcg-grid-thumb',   280,  185, true );
		add_image_size( 'mcg-medium',   1000, 565, false );
		add_image_size( 'mcg-news',   150);

		add_action( 'widgets_init', array(__CLASS__, 'register_sidebars') );

		add_action( 'wp_enqueue_scripts', array(__CLASS__, 'sns'), 99 );
		add_action( 'wp_head', 'kct_head_stuff' );

		add_filter( 'wp_nav_menu_items', array(__CLASS__, 'main_menu_items'), 10, 2 );
		add_filter( 'walker_nav_menu_start_el', array(__CLASS__, 'facebook_like'), 10, 4 );
		add_filter( 'body_class', array(__CLASS__, 'body_class') );

		foreach ( array('kct_before_entry_title', 'kct_after_entry_title', 'kct_before_entry_content', 'kct_after_entry_content') as $hook )
			add_action( $hook, array(__CLASS__, 'news_data') );
	}


	public static function register_sidebars() {
		$wa = array(
			'wa-header' => __('Header', 'mcg'),
			'wa-news'   => __('News index', 'mcg')
		);

		foreach ( $wa as $id => $name )
			register_sidebar( array(
				'id'            => $id,
				'name'          => $name,
				'before_widget' => '<div id="%1$s" class="widget %2$s">'."\n",
				'after_widget'  => "</div>\n",
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>'
			) );
	}


	public static function sns() {
		wp_enqueue_style( 'mcg', self::$url_theme.'/style.css', false, self::version );

		if ( is_singular() && post_type_supports(get_post_type(), 'comments') && comments_open() && get_option('thread_comments') )
			wp_enqueue_script( 'comment-reply' );

		wp_register_script( 'html5', self::$url_theme.'/j/html5.js', false, 'trunk' );
		wp_register_script( 'jquery-flexslider', self::$url_theme.'/j/jquery.flexslider.min.js', array('jquery'), '1.8', true );
		wp_register_script( 'jquery-colorbox', self::$url_theme.'/j/jquery.colorbox-min.js', array('jquery'), '1.3.19', true );
		wp_register_script( 'jquery-cycle', self::$url_theme.'/j/jquery.cycle-2.9999.3.min.js', array('jquery'), '2.9999.3', true );
		wp_register_script( 'mcg-plugins', self::$url_theme.'/j/plugins.js', array('jquery'), '2.9999.6', true );


		if ( is_front_page()
			|| is_post_type_archive('exhibition')
			|| is_singular('exhibition')
			|| is_singular('artist')
			|| is_page_template('tpl-gallery.php') )
		{
			wp_enqueue_script( 'jquery-colorbox' );
			wp_enqueue_script( 'jquery-flexslider' );
		}

		wp_enqueue_script( 'mcg-plugins' );
		wp_enqueue_script( 'mcg', self::$url_theme.'/j/mcg.js', array('jquery'), self::version, true );
	}


	public static function body_class( $classes ) {
		if ( is_singular() ) {
			global $post;
			$classes[] = "{$post->post_type}-{$post->post_name}";
		}

		return $classes;
	}


	public static function main_menu_items( $items, $args ) {
		if ( !isset($args->theme_location) || $args->theme_location != 'main' )
			return $items;

		$current = get_queried_object();
		$is_singular = is_singular();

		# Artist
		$out = '';
		$post_type = 'artist';
		$post_type_object = get_post_type_object( $post_type );
		$q = new WP_Query( array(
			'post_type'      => $post_type,
			'posts_per_page' => -1
		) );
		if ( $q->have_posts() ) {
			$out .= "<li class='menu-item";
			if ( $is_singular && $current->post_type == $post_type )
				$out .= " current-menu-ancestor";
			$out .= "'>\n<span class='parent'>{$post_type_object->label}</span>\n";
			$out .= "<ul class='sub-menu'>\n";
			while ( $q->have_posts() ) {
				$q->the_post();
				$out .= "<li class='menu-item";
				if ( $is_singular && $current->ID === get_the_ID() )
					$out .= " current-menu-item";
				$out .= "'><a href='".get_permalink()."'>".get_the_title()."</a></li>\n";
			}
			$out .= "</ul>\n";
			$out .= "</li>\n";
		}
		wp_reset_query();
		$items = $out . $items;

		$out = '';
		$post_type = 'exhibition';
		$post_type_object = get_post_type_object( $post_type );
		$list = array(
			'present' => array(),
			'future'  => array(),
			'past'    => array(),
			'something' => '',
		);
		$q = new WP_Query( array(
			'post_type'      => $post_type,
			'posts_per_page' => -1
		) );
		if ( $q->have_posts() ) {
			while ( $q->have_posts() ) {
				$q->the_post();
				global $post;
				if ( $date = MCG::get_exhibition_date($post) ) {
					$list[$date['status']][] = $post->ID;
				}
			}
		}
		wp_reset_query();
		$list = kc_array_remove_empty($list);
		if ( !empty($list) ) {
			$archive_url = get_post_type_archive_link($post_type);
			$pretty_permalink = (bool) get_option('permalink_structure');

			$out .= "<li class='menu-item";
			if ( MCG::$exhibition_in_view || is_singular('exhibition') )
				$out .= " current-menu-ancestor";
			$out .= "'>\n<span class='parent";
			$out .= "'>{$post_type_object->label}</span>\n";
			$out .= "<ul class='sub-menu'>\n";
			foreach( $list as $time => $IDs ) {
				$out .= "<li class='menu-item";
				if ( MCG::$exhibition_in_view == $time || ( is_singular('exhibition') && MCG::$exhibition_data['date']['status'] == $time ) )
					$out .= " current-menu-item";
				$out .= "'><a href='";
				if ( $time === 'present' ) {
					$out .= get_permalink( $IDs[0] );
				}
				else {
					if ( $pretty_permalink )
						$out .= $archive_url . "range/$time";
					else
						$out .= add_query_arg( array('range' => $time), $archive_url );
				}
				$out .= "'>".MCG::$exhibition_statuses[$time]."</a></li>";
			}
			$out .= "</ul>\n";
			$out .= "</li>\n";
		}

		$items = $out . $items;

		return $items;
	}


	public static function facebook_like( $item_output, $item, $depth, $args ) {
		if ( in_array('facebook', $item->classes) ) {
			$item_output .= '<div class="fb-like" data-href="'.$item->url.'" data-send="true" data-layout="button_count" data-width="140" data-show-faces="false"></div>';
		}

		return $item_output;
	}


	public static function news_data() {
		global $post;
		if ( is_404() || $post->post_type != 'post' )
			return;

		$current = $post->ID;
		$hook = current_filter();

		if ( $hook == 'kct_before_entry_title' && !is_singular() )
			the_post_thumbnail( 'mcg-news', array('class' => 'news-thumb') );

		elseif ( $hook == 'kct_after_entry_title' )
			echo "<abbr class='date' title='".get_the_date('r')."'>".get_the_date(get_option('date_format'))."</abbr>\n";

		elseif ( $hook == 'kct_after_entry_content' ) {
			$exh_info = '';
			$meta = get_post_custom( $current );
			$exhibition = new WP_Query( array(
				'connected_type'  => 'posts_to_exhibitions',
				'connected_items' => $current,
				'nopaging'        => true,
				'posts_per_page'  => 1
			) );
			if ( $exhibition->have_posts() ) {
				while ( $exhibition->have_posts() ) {
					$exhibition->the_post();
					$exh_ID = get_the_ID();
					if ( $pr = get_post_meta( $exh_ID, '_press-release', true ) )
						$exh_info .= "<a class='icon doc' href='".wp_get_attachment_url($pr)."'>".__('Press release', 'mcg')."</a><br />";

					$artist = new WP_Query( array(
						'connected_type'  => 'exhibitions_to_artists',
						'connected_items' => $exh_ID,
						'nopaging'        => true,
						'posts_per_page'  => 1
					) );
					if ( $artist->have_posts() ) {
						while ( $artist->have_posts() ) {
							$artist->the_post();
							$exh_info .= "<a class='icon view' href='".get_permalink()."'>".__('Artist info', 'mcg')."</a>";
						}
					}
					wp_reset_postdata();
				}
			}
			wp_reset_postdata();

			if ( $exh_info )
				echo "<p class='news-info'>{$exh_info}</p>\n";
		}
	}


	public static function exhibition_slideshow( $query = '' ) {
		if ( !$query ) {
			global $wp_query;
			$query = $wp_query;
		}
		$c = 0;
		if ( $query->have_posts() ) {
		?>
<div class="ss-wrap">
	<section class="ss-images ss-exhibitions">
		<ul class="slides">
			<?php
				while ( $query->have_posts() ) {
				$query->the_post();
				if ( !has_post_thumbnail() )
					continue;

				global $post;
				$exh = $post;
				$img_id     = get_post_thumbnail_id($exh->ID);
				$img_title  = get_the_title( $img_id );
				$img_medium = wp_get_attachment_image_src( $img_id, 'mcg-medium' );
				$img_full   = wp_get_attachment_image_src( $img_id, 'full' );
			?>
			<li class="item" data-index="<?php echo $c ?>">
				<div class="info">
					<h3 class="text"><span><a href="<?php the_permalink() ?>"><?php echo the_title() ?></a></span></h3>
					<?php if ( $artists = MCG::get_exhibition_artists($exh->ID) ) echo "<p class='text artists'><span>".implode( ', ', $artists )."</span></p>\n"; ?>
					<?php if ( $date = MCG::get_exhibition_date($exh) ) echo "<p class='date text'><span>".$date['result']."</span></p>\n"; ?>
				</div>
				<img alt="" title="<?php echo $img_title ?>" src="<?php echo $img_medium[0] ?>" /> <!-- width="<?php echo $img_medium[1] ?>" height="<?php echo $img_medium[2] ?>" -->
				<a href="<?php echo $img_full[0] ?>" title="<?php _e('View original size', 'mcg') ?>" class="zoom ss-button" rel="prefetch"><span class="visuallyhidden"><?php _e('Zoom', 'mcg') ?></span></a>
			</li>
			<?php $c++; } ?>
		</ul>
	</section>
</div>
	<?php } wp_reset_postdata(); }


	public static function exhibition_grid( $query = '' ) {

			$today = date( 'Y-m-d' );

			 $args = array(
			 	'post_type' => 'exhibition',
			 	'posts_per_page' => -1,
			 	'suppress_filters' => false
			  );

			 /*

			 	// DOESN'T WORK IF WE ADD THIS
			 	// ref: http://wpml.org/forums/topic/new-wp_query-not-working-with-meta_query/

			 	// Well, this what makes the time range thingy works :(
			 	// -- kucrut

				'meta_query' => array(
									array(
										'key'     => '_date-end',
										'value'   => $today,
										'compare' => '<',
										'type'    => 'CHAR'
									)
								)

			 */

			$query = new WP_Query($args);


		$c = 0;
		if ( $query->have_posts() ) {
		?>
		<div class="grid-wrap">
			<section class="grid-images grid-exhibitions">
				<ul class="items">
					<?php
						while ( $query->have_posts() ) {
						$query->the_post();
						if ( !has_post_thumbnail() )
							continue;

						global $post;
						$exh = $post;
						$img_id     = get_post_thumbnail_id($exh->ID);
						$img_title  = get_the_title( $img_id );
						$img_medium = wp_get_attachment_image_src( $img_id, 'mcg-grid-thumb' );
						$img_full   = wp_get_attachment_image_src( $img_id, 'full' );
						$link 		= get_permalink($exh->ID);
					?>
					<li class="item-grid left" data-index="<?php echo $c ?>">
						<a href="<?php the_permalink() ?>">
							<img alt="" title="<?php echo $img_title ?>" src="<?php echo $img_medium[0] ?>" width="<?php echo $img_medium[1] ?>" height="<?php echo $img_medium[2] ?>"/>
						</a>
						<div class="info">
							<h3 class="text"><span><a href="<?php echo $link; ?>"><?php echo the_title() ?></a></span></h3>
							<?php if ( $date = MCG::get_exhibition_date($exh) ) echo "<p class='date text'><span>".$date['result']."</span></p>\n"; ?>
							<?php if ( $artists = MCG::get_exhibition_artists($exh->ID) ) echo "<p class='text artists'><span>".implode( ', ', $artists )."</span></p>\n"; ?>
							<p class="text view"><a href="<?php echo $link; ?>"><?php _e('View exhibition', 'mcg') ?></a></p>
						</div>
					</li>
					<?php $c++; } ?>
				</ul>
			</section>
		</div>
	<?php } wp_reset_postdata(); }

	public static function locale_hack() {
		$strings = array(
			__('Site settings', 'mcg'),
			__('Contact &amp; address info'),
			__('GPS coordinate', 'mcg'),
			__('Phone number', 'mcg'),
			__('Email', 'mcg'),
			__('Address', 'mcg'),
			__('Social networks', 'mcg'),
			__('Exhibition', 'mcg'),
			__('Exhibitions', 'mcg'),
			__('Artist', 'mcg'),
			__('Artists', 'mcg'),
			__('Facebook URL', 'mcg'),
			__('LinkedIn URL', 'mcg'),
			__('Twitter username', 'mcg'),
			__('Artist data', 'mcg'),
			__('Start date', 'mcg'),
			__('End date', 'mcg'),
			__('Images', 'mcg'),
			__('Post data', 'mcg'),
			__('Press release', 'mcg'),
			__('Past', 'mcg'),
			__('Present', 'mcg'),
			__('Future', 'mcg')
		);
	}
}
add_action( 'after_setup_theme', array('mcgTheme', 'setup') );

?>
