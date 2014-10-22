<?php

/*
Plugin Name: Mor. Charpentier
Version: 1.0
Description: Mor. Charpentier functionalities
Author: 8manos
Author URI: http://8manos.com/
text-domain: mc
*/


class MCG {
	public static $exhibition_statuses;
	public static $exhibition_in_view;
	public static $exhibition_data;


	public static function init() {
		add_action( 'init', array(__CLASS__, 'register_post_types') );
		add_action( 'wp_loaded', array(__CLASS__, 'connection') );

		add_filter( 'kc_plugin_settings', array(__CLASS__, 'site_settings') );
		add_filter( 'kc_post_settings', array(__CLASS__, 'metadata_post') );

		add_filter( 'query_vars', array(__CLASS__, 'query_vars') );
		add_filter( 'rewrite_rules_array', array(__CLASS__, 'rewrite_rules') );
		add_filter( 'wp_loaded', array(__CLASS__, 'flush_rewrite_rules') );
		add_filter( 'request', array(__CLASS__, 'exhibition_request_front') );
		add_filter( 'request', array(__CLASS__, 'exhibition_request_back') );
		add_filter( 'get_header', array(__CLASS__, 'exhibition_data') );
		add_filter( 'manage_exhibition_posts_columns', array(__CLASS__, 'exhibition_columns') );
		add_action( 'manage_exhibition_posts_custom_column', array(__CLASS__, 'exhibition_time_column'), 10, 2 );
		add_filter( 'manage_edit-exhibition_sortable_columns', array(__CLASS__, 'exhibition_time_column_sort') );

		add_shortcode( 'googlemap', array(__CLASS__, 'sc_google_maps') );
	}


	public static function site_settings( $groups ) {
		$groups[] = array(
			'prefix'       => 'mcg',
			'menu_title'   => __('MC Gallery', 'mcg'),
			'page_title'   => __('MC Gallery', 'mcg'),
			'options'      => array(
				array(
					'id'     => 'gallery',
					'title'  => __('Gallery', 'mcg'),
					'fields' => array(
						array(
							'id'    => 'images',
							'title' => __('Images', 'mcg'),
							'type'  => 'file',
							'mode'  => 'checkbox'
						)
					)
				)
			)
		);

		return $groups;
	}


	public static function register_post_types() {
		register_post_type( 'artist', array(
			'labels'       => array(
				'name'          => __('Artists', 'mcg'),
				'singular_name' => __('Artist', 'mcg')
			),
			'public'       => true,
			'hierarchical' => true,
			'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes' ),
			'rewrite'      => array( 'with_front' => false )
		) );

		register_post_type( 'exhibition', array(
			'labels'       => array(
				'name'          => __('Exhibitions', 'mcg'),
				'singular_name' => __('Exhibition', 'mcg')
			),
			'public'       => true,
			'hierarchical' => true,
			'has_archive'  => true,
			'supports'     => array( 'title', 'editor', 'thumbnail' ),
			'rewrite'      => array( 'with_front' => false )
		) );

		self::$exhibition_statuses = array(
			'past'    => __('Past', 'mcg'),
			'present' => __('Present', 'mcg'),
			'future'  => __('Future', 'mcg')
		);
	}


	public static function connection() {
		if ( !function_exists( 'p2p_register_connection_type' ) )
			return;

		p2p_register_connection_type( array(
			'name' => 'posts_to_exhibitions',
			'from' => 'post',
			'to'   => 'exhibition'
		) );

		p2p_register_connection_type( array(
			'name' => 'exhibitions_to_artists',
			'from' => 'exhibition',
			'to'   => 'artist'
		) );
	}


	public static function metadata_post( $groups ) {
		$groups[] = array(
			'artist' => array(
				array(
					'id'     => 'artist-data',
					'title'  => __('Artist data', 'mcg'),
					'fields' => array(
						array(
							'id'    => 'cv',
							'title' => __('CV', 'mcg'),
							'type'  => 'file',
							'mode'  => 'single'
						),
						array(
							'id'    => 'news',
							'title' => __('News', 'mcg'),
							'type'  => 'textarea'
						),
						array(
							'id'    => 'pub',
							'title' => __('Publications', 'mcg'),
							'type'  => 'file',
							'mode'  => 'checkbox'
						),
						array(
							'id'    => 'video',
							'title' => __('Video', 'mcg'),
							'type'  => 'multiinput',
							'subfields' => array(
								array(
									'id'    => 'key',
									'title' => __('URL', 'mcg'),
									'type'  => 'text'
								),
								array(
									'id'    => 'value',
									'title' => __('Title', 'mcg'),
									'type'  => 'text'
								)
							)
						),
						array(
							'id'    => 'images',
							'title' => __('Images', 'mcg'),
							'type'  => 'file',
							'mode'  => 'checkbox'
						)
					)
				)
			),
			'exhibition' => array(
				array(
					'id'     => 'exhibition-data',
					'title'  => __('Exhibition data', 'mcg'),
					'fields' => array(
						array(
							'id'    => 'press-release',
							'title' => __('Press Release', 'mcg'),
							'type'  => 'file',
							'mode'  => 'single'
						),
						array(
							'id'    => 'date-start',
							'title' => __('Start date', 'mcg'),
							'type'  => 'date'
						),
						array(
							'id'    => 'date-end',
							'title' => __('End date', 'mcg'),
							'type'  => 'date'
						),
						array(
							'id'    => 'artists',
							'title' => __('Artists', 'mcg'),
							'desc'  => __('Artists names, one name per line', 'mcg'),
							'type'  => 'textarea'
						),
						array(
							'id'    => 'images',
							'title' => __('Images', 'mcg'),
							'type'  => 'file',
							'mode'  => 'checkbox'
						),
						array(
							'id'        => 'quotes',
							'title'     => __('Quotes', 'mcg'),
							'type'      => 'multiinput',
							'subfields' => array(
								array(
									'id'    => 'key',
									'title' => __('Name', 'mcg'),
									'type'  => 'text'
								),
								array(
									'id'    => 'value',
									'title' => __('Text', 'mcg'),
									'type'  => 'textarea'
								)
							)
						)
					)
				)
			),
			'attachment' => array(
				array(
					'id'     => 'attachment-data',
					'title'  => __('Attachment data', 'mcg'),
					'fields' => array(
						array(
							'id'    => 'pub-year',
							'title' => __('Publication Year', 'mcg'),
							'type'  => 'text'
						),
						array(
							'id'    => 'pub-url',
							'title' => __('Publication URL', 'mcg'),
							'type'  => 'text'
						)
					)
				)
			)
		);

		return $groups;
	}


	public static function get_exhibition_date( $post, $sep = ' &ndash; ' ) {
		if ( $post->post_type != 'exhibition' )
			return;

		$dates = array( 'start' => array(), 'end' => array() );
		foreach ( array_keys($dates) as $d ) {
			if ( $date = get_post_meta( $post->ID, "_date-{$d}", true ) ) {
				$dates[$d]['full'] = $date;
				foreach ( array('Y', 'm', 'd') as $s )
					$dates[$d][$s] = mysql2date( $s, $date );
			}
			else {
				return;
			}
		}

		# Same year and month
		if ( $dates['start']['Y'] == $dates['end']['Y'] && $dates['start']['m'] == $dates['end']['m'] ) {
			$format = array(
				'start' => 'j',
				'end'   => 'j F Y',
			);
		}
		# Same year, different month
		elseif ( $dates['start']['Y'] == $dates['end']['Y'] && $dates['start']['m'] != $dates['end']['m'] ) {
			$format = array(
				'start' => 'j F',
				'end'   => 'j F Y',
			);
		}
		else {
			$format = array(
				'start' => 'j F Y',
				'end'   => 'j F Y'
			);
		}


		# Status
		$start = explode( '-', $dates['start']['full'] );
		$start = mktime( 0, 0, 0, $start[1], $start[2], $start[0] );
		$end   = explode( '-', $dates['end']['full'] );
		$end   = mktime( 0, 0, 0, $end[1], $end[2], $end[0] );
		$now   = time();
		if ( $start < $now && $end > $now )
			$status = 'present';
		elseif ( $end > $now )
			$status = 'future';
		elseif ( $end < $now )
			$status = 'past';


		$out = array(
			'dates'  => $dates,
			'format' => $format,
			'result' => mysql2date( $format['start'], $dates['start']['full'] ) . $sep . mysql2date( $format['end'], $dates['end']['full'] ),
			'status' => $status
		);

		return $out;
	}


	public static function exhibition_data() {
		if ( !is_singular('exhibition') )
			return;

		global $post;
		$data = array( 'date' => array( 'status' => '', 'result' => '' ), 'quotes' => array(), 'images' => array() );
		$date = self::get_exhibition_date( $post );
		if ( isset($date['result']) )
			$data['date'] = $date;

		if ( $quotes = get_post_meta( $post->ID, '_quotes', true ) )
			$data['quotes'] = $quotes;

		$_images = get_post_meta( $post->ID, '_images', true );
		if ( isset($_images['selected']) ) {
			$images = array();
			foreach ( $_images['selected'] as $img ) {
				$images[] = array(
					'title'  => get_the_title( $img ),
					'medium' => wp_get_attachment_image_src( $img, 'mcg-medium' ),
					'full'   => wp_get_attachment_image_src( $img, 'full' )
				);
			}
			$data['images'] = $images;
		}

		self::$exhibition_data = $data;
	}


	public static function get_exhibition_artists( $post_id ) {
		$artists = ( $_artist_m = get_post_meta( $post_id, '_artists', true ) ) ? explode( "\r\n", $_artist_m ) : array();

		$_artists_p = new WP_Query( array(
			'connected_type'  => 'exhibitions_to_artists',
			'connected_items' => $post_id,
			'nopaging'        => true
		) );
		if ( $_artists_p->have_posts() ) {
			while ( $_artists_p->have_posts() ) {
				$_artists_p->the_post();
				$artists[] = "<a href='".get_permalink()."'>".get_the_title()."</a>";
			}
		}
		wp_reset_postdata();

		return $artists;
	}


	public static function flush_rewrite_rules() {
		$rules = get_option( 'rewrite_rules' );

		if ( !isset($rules['exhibition/range/([^/]+)?$']) ) {
			global $wp_rewrite;
			$wp_rewrite->flush_rules();
		}
	}


	public static function rewrite_rules( $rules ) {
		$new = array(
			'exhibition/range/([^/]+)?$'                   => 'index.php?post_type=exhibition&range=$matches[1]',
			'exhibition/range/([^/]+)/page/([0-9]{1,})/?$' => 'index.php?post_type=exhibition&range=$matches[1]&paged=$matches[2]'
		);
		$rules = $new + $rules;

		return $rules;
	}


	public static function query_vars( $vars ) {
		$vars[] = 'range';
		return $vars;
	}


	public static function exhibition_request_front( $vars ) {
		if (
			!is_admin()
			&& isset($vars['post_type']) && $vars['post_type'] == 'exhibition'
			&& !isset($vars['exhibition'])
			&& isset($vars['range'])
		) {
			self::$exhibition_in_view = $vars['range'];
			$today = date( 'Y-m-d' );

			switch ( $vars['range'] ) {
				case 'past' :
					$mq = array(
						array(
							'key'     => '_date-end',
							'value'   => $today,
							'compare' => '<',
							'type'    => 'CHAR'
						)
					);
				break;

				case 'future' :
					$mq = array(
						array(
							'key'     => '_date-start',
							'value'   => $today,
							'compare' => '>',
							'type'    => 'CHAR'
						)
					);
				break;

				default :
					$mq = array(
						'relation'=>'AND',
						array(
							'key'     => '_date-start',
							'value'   => $today,
							'compare' => '<',
							'type'    => 'CHAR'
						),
						array(
							'key'     => '_date-end',
							'value'   => $today,
							'compare' => '>',
							'type'    => 'CHAR'
						)
					);
				break;
			}

			$vars['meta_query'] = $mq;
			$vars['posts_per_page'] = -1;
		}
		return $vars;
	}


	public static function exhibition_columns( $columns ) {
		$columns = array_merge(
			array_slice($columns, 0, 2),
			array('time' => __('Time', 'mcg')),
			array_slice($columns, 2)
		);
		return $columns;
	}


	public static function exhibition_time_column( $column, $post_id ) {
		if ( $column == 'time' ) {
			global $post;
			if ( $time = self::get_exhibition_date($post) )
				echo $time['result'];
		}
	}


	public static function exhibition_time_column_sort( $columns ) {
		$columns['time'] = 'time';
		return $columns;
	}


	public static function exhibition_request_back( $vars ) {
		if (
			is_admin()
			&& isset($vars['post_type']) && $vars['post_type'] == 'exhibition'
			&& isset($vars['orderby']) && $vars['orderby'] == 'time'
		) {
			$vars['meta_key'] = '_date-start';
			$vars['orderby'] = 'meta_value';
		}

		return $vars;
	}


	public static function sc_google_maps( $atts ) {
		global $content_width;
		extract( shortcode_atts(array(
			'width'  => $content_width,
			'height' => absint( $content_width / 1.75 ),
			'src'    => ''
		), $atts) );

		if ( !$src )
			return;

		return '<iframe width="'.$width.'" height="'.$height.'" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="'.$src.'&amp;output=embed"></iframe>';
	}


	public static function get_artist_data() {
		if ( !is_singular('artist') )
			return;

		$data = array();
		global $post;

		# 0. Images
		if ( $_images = get_post_meta($post->ID, '_images', true) ) {
			if ( isset($_images['selected'])) {
				$images = array();
				foreach ( $_images['selected'] as $img ) {
					$images[] = array(
						'title' => get_the_title( $img ),
						'img'   => array(
							'medium' => wp_get_attachment_image_src( $img, 'mcg-medium' ),
							'full'   => wp_get_attachment_image_src( $img, 'full' )
						)
					);
				}
				if ( $images )
					$data['images'] = array( __('Images', 'mcg'), $images );
			}
		}

		# 1. Videos
		if ( $_video = get_post_meta($post->ID, '_video', true) ) {
			$data['video'] = array( __('Videos', 'mcg'), $_video );
		}

		# 2. Bio
		if ( !empty($post->post_content) )
			$data['bio'] = array( __('Bio', 'mcg') );

		# 3. News
		if ( $news = get_post_meta($post->ID, '_news', true) )
			$data['news'] = array( __('News', 'mcg'), wpautop($news) );

		# 4. Publications
		if ( $_pub = get_post_meta($post->ID, '_pub', true) ) {
			if ( isset($_pub['selected'])) {
				$pub = array();
				foreach ( $_pub['selected'] as $img ) {
					$pub[] = array(
						'title' => get_the_title( $img ),
						'img'   => array(
							'thumb' => wp_get_attachment_image_src( $img, 'mcg-thumb' ),
							'full'  => wp_get_attachment_image_src( $img, 'full' )
						),
						'url'   => get_post_meta( $img, '_pub-url', true ),
						'year'  => get_post_meta( $img, '_pub-year', true )
					);
				}
				if ( $pub )
					$data['pub'] = array( __('Publications', 'mcg'), $pub );
			}
		}

		return $data;
	}
}
add_action( 'plugins_loaded', array('MCG', 'init') );

?>
