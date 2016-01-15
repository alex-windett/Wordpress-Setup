<?php
namespace PD\ThemeFramework\Extra;

function body_class( $classes ) {
	// Add page slug if it doesn't exist
	if ( is_single() || is_page() && !is_front_page() ) {
		$slug = basename( get_permalink() );

		if ( !in_array( $slug, $classes ) ) {
			$classes[] = $slug;
		}
	}

	$home_id_class = 'page-id-' . get_option( 'page_on_front' );

	$remove_classes = array(
		'page-template-default',
		$home_id_class
	);

	$classes = array_diff( $classes, $remove_classes );

	return $classes;
}

add_filter( 'body_class', __NAMESPACE__ . '\\body_class' );

// Add zone colour to wordpress body
add_filter( 'body_class', function ( $classes ) {
	global $post, $bf_zone_colour;

	if ( !( is_single() || is_page() || is_attachment() ) && !isset( $bf_zone_colour ) ) {
		return $classes;
	}

	$zone_colour = isset( $bf_zone_colour ) ? $bf_zone_colour : get_field( 'zone_colour', $post->ID );

	if ( $zone_colour ) {
		$classes[] = 'zone-' . $zone_colour;
	}

	if ( !empty($post->post_name) ) {
		$classes[] = $post->post_name;
	}

	return $classes;
} );


if ( !function_exists( 'override_zone_colour' ) ):
	function override_zone_colour( $colour ) {
		global $bf_zone_colour;

		$bf_zone_colour = $colour;
	}
endif;

function head_cleanup() {
	global $wp_widget_factory;

	remove_action( 'wp_head', 'feed_links_extra', 3 );
	add_action( 'wp_head', 'ob_start', 1, 0 );

	add_action( 'wp_head', function () {
		$pattern = '/.*' . preg_quote( esc_url( get_feed_link( 'comments_' . get_default_feed() ) ), '/' ) . '.*[\r\n]+/';
		echo preg_replace( $pattern, '', ob_get_clean() );
	}, 3, 0 );

	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_generator' );
	remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0 );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'use_default_gallery_style', '__return_false' );

	if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}

	if ( !class_exists( 'WPSEO_Frontend' ) ) {
		remove_action( 'wp_head', 'rel_canonical' );
		add_action( 'wp_head', __NAMESPACE__ . '\\rel_canonical' );
	}
}

function rel_canonical() {
	global $wp_the_query;

	if ( !is_singular() ) {
		return;
	}

	if ( !$id = $wp_the_query->get_queried_object_id() ) {
		return;
	}

	$link = get_permalink( $id );

	echo "\t<link rel=\"canonical\" href=\"$link\">\n";
}

add_action( 'init', __NAMESPACE__ . '\\head_cleanup' );
add_filter( 'the_generator', '__return_false' );

function language_attributes() {
	$attributes = array();
	if ( is_rtl() ) {
		$attributes[] = 'dir="rtl"';
	}
	$lang = get_bloginfo( 'language' );
	if ( $lang ) {
		$attributes[] = "lang=\"$lang\"";
	}
	$output = implode( ' ', $attributes );
	$output = apply_filters( 'soil/language_attributes', $output );
	return $output;
}

add_filter( 'language_attributes', __NAMESPACE__ . '\\language_attributes' );


function clean_style_tag( $input ) {
	preg_match_all( "!<link rel='stylesheet'\s?(id='[^']+')?\s+href='(.*)' type='text/css' media='(.*)' />!", $input, $matches );

	$media = $matches[3][0] !== '' && $matches[3][0] !== 'all' ? ' media="' . $matches[3][0] . '"' : '';

	return '<link rel="stylesheet" href="' . $matches[2][0] . '"' . $media . '>' . "\n";
}

add_filter( 'style_loader_tag', __NAMESPACE__ . '\\clean_style_tag' );

function clean_script_tag( $input ) {
	$input = str_replace( "type='text/javascript' ", '', $input );
	return str_replace( "'", '"', $input );
}

add_filter( 'script_loader_tag', __NAMESPACE__ . '\\clean_script_tag' );


/**
 * Wrap embedded media as suggested by Readability
 *
 * @link https://gist.github.com/965956
 * @link http://www.readability.com/publishers/guidelines#publisher
 */
function embed_wrap( $cache ) {
	return '<div class="entry-content-asset">' . $cache . '</div>';
}

add_filter( 'embed_oembed_html', __NAMESPACE__ . '\\embed_wrap' );
/**
 * Remove unnecessary dashboard widgets
 *
 * @link http://www.deluxeblogtips.com/2011/01/remove-dashboard-widgets-in-wordpress.html
 */
function remove_dashboard_widgets() {
	remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_plugins', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_primary', 'dashboard', 'normal' );
	remove_meta_box( 'dashboard_secondary', 'dashboard', 'normal' );
}

add_action( 'admin_init', __NAMESPACE__ . '\\remove_dashboard_widgets' );

/**
 * Remove unnecessary self-closing tags
 */
function remove_self_closing_tags( $input ) {
	return str_replace( ' />', '>', $input );
}

add_filter( 'get_avatar', __NAMESPACE__ . '\\remove_self_closing_tags' ); // <img />
add_filter( 'comment_id_fields', __NAMESPACE__ . '\\remove_self_closing_tags' ); // <input />
add_filter( 'post_thumbnail_html', __NAMESPACE__ . '\\remove_self_closing_tags' ); // <img />


function remove_default_description( $bloginfo ) {
	$default_tagline = 'Just another WordPress site';
	return ( $bloginfo === $default_tagline ) ? '' : $bloginfo;
}

add_filter( 'get_bloginfo_rss', __NAMESPACE__ . '\\remove_default_description' );