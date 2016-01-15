<?php
namespace PD\ThemeFramework\Setup;

// Gravity forms support
add_filter( 'gform_init_scripts_footer', '__return_true' );
add_filter('gform_confirmation_anchor', '__return_false');

function wrap_gform_cdata_open( $content = '' ) {
	$content = 'document.addEventListener( "DOMContentLoaded", function() { ';
	return $content;
}
add_filter( 'gform_cdata_open', __NAMESPACE__ . '\\wrap_gform_cdata_open' );

function wrap_gform_cdata_close( $content = '' ) {
	$content = ' }, false );';
	return $content;
}
add_filter( 'gform_cdata_close', __NAMESPACE__ . '\\wrap_gform_cdata_close' );

function theme_support() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'caption', 'comment-form', 'comment-list' ) );
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\\theme_support' );

function theme_menus() {
	register_nav_menus(
		array(
			'side_menu' => 'Side Menu',
			'header_menu' => 'Header Menu'
		)
	);
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\\theme_menus' );

add_action( 'admin_print_styles', function () {
	wp_enqueue_style( "bf-admin-cdd", get_stylesheet_directory_uri() . '/assets/css/admin.css', array(), '1.1' );
} );

add_action('wp_enqueue_scripts', function (){

	// Registering Styles
	bf_wp_register_style('app-css', 'app.css');

	// Registering Scripts
	bf_wp_register_script('vendor-js', 'vendor', array('jquery'), true, true);
	bf_wp_register_script('app-js', 'app', array('vendor-js', 'masonry'), true, true);
	bf_wp_register_script('modernizr', 'assets/bower_components/modernizr/modernizr.js', array(), false, false );
	bf_wp_register_script('es5-shim', 'assets/bower_components/es5-shim/es5-shim.min.js', array(), false, false );
	bf_wp_register_script('ie-vendor', 'ie-vendor', array(), true, false );

	// Enqueue Styles for all pages
	wp_enqueue_style('app-css');

	// Enqueue Scripts for all pages
	wp_enqueue_script('modernizr');
	wp_enqueue_script('es5-shim');
	wp_enqueue_script('vendor-js');
	wp_enqueue_script('app-js');

});

// Function to locate images
if (!function_exists('get_image_directory_uri')) {
	function get_image_directory_uri() {
		if ( defined( 'IS_DEV' ) && IS_DEV ) {
			return get_stylesheet_directory_uri() . '/assets/img/src';
		}

		return get_stylesheet_directory_uri() . '/assets/img/min/src';
	}
}

add_theme_support( 'post-thumbnails' );

// Function to register scripts
if (!function_exists('bf_wp_register_script')) {
	function bf_wp_register_script( $name, $location, $dependencies = array(), $min = false, $in_footer = true ) {
		if( !$min ) {
			$file_location = '/' . $location;
		} elseif( defined( 'IS_DEV' ) && IS_DEV ) {
			$file_location = '/assets/js/concat/' . $location . '.js';
		} else {
			$file_location = '/assets/js/min/' . $location . '.min.js';
		}
		wp_register_script( $name, get_stylesheet_directory_uri() . $file_location, $dependencies, filemtime( get_stylesheet_directory() . $file_location ), $in_footer );
	}
}

// Function to register styles
if (!function_exists('bf_wp_register_style')) {
	function bf_wp_register_style( $name, $location, $dependencies = array() ) {
		$file_location = '/assets/css/' . $location;

		wp_register_style( $name, get_stylesheet_directory_uri() . $file_location, $dependencies, filemtime( get_stylesheet_directory() . $file_location ) );
	}
}

// Function for retina srcset
if ( !function_exists( 'srcset' ) ) {
	function srcset( $src, $w = 500, $h = 500, $zc = 1, $s = 1, $f = 0 ) {
		return 'src="' . timthumb( $src, $w, $h, $zc, $s, $f ) . '" '
		. 'srcset="'
		. timthumb( $src, $w, $h, $zc, $s, $f ) . ' 1x, '
		. timthumb( $src, srcset_multiple( $w, 1.5 ), srcset_multiple( $h, 1.5 ), $zc, $s, $f ) . ' 1.5x, '
		. timthumb( $src, srcset_multiple( $w, 2 ), srcset_multiple( $h, 2 ), $zc, $s, $f ) . ' 2x '
		. '" ';
	}
}

if ( !function_exists( 'srcset_multiple' ) ) {
	function srcset_multiple( $dimension, $multiple ) {
		if ( $dimension == 'auto' ) {
			return $dimension;
		}

		return ceil( $dimension * $multiple );
	}
}

add_filter( 'excerpt_length', function () {
    return 20;
} );

add_filter( 'excerpt_more', function () {
    return '&hellip; <a href="' . get_permalink() . '">read post</a>';
} );

add_action( 'wp_footer', function () {
	if ( !defined( 'IS_DEV' ) || !IS_DEV ) {
		return;
	}

	if (preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || (strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0; rv:11.0') !== false)) {
		return;
	}

	?><script src="<?= rtrim(home_url(), '/'); ?>:35740/livereload.js"></script><?php
}, 999 );

?>