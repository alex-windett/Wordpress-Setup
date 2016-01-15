<?php
/*
Plugin Name: Remove WP Default Image Sizes
Plugin URI:
Description: Removes WordPress default images sizes as we don't use them due to using timthumb to deal with image sizes.
Version: 2.0
Author: Scott Cariss
Author URI: http://l3rady.com
*/
!defined( 'ABSPATH' ) and exit;

if ( !function_exists( 'bfdis_alter_default_image_sizes' ) ):

	function bfdis_alter_default_image_sizes() {
		$thumbnail_dimensions = array(
			'width'  => (int) get_option( 'thumbnail_size_w' ),
			'height' => (int) get_option( 'thumbnail_size_h' ),
			'crop'   => (int) get_option( 'thumbnail_crop' )
		);

		add_image_size(
			'medium',
			apply_filters( 'bfdis_medium_width', $thumbnail_dimensions['width'] ),
			apply_filters( 'bfdis_medium_height', $thumbnail_dimensions['height'] ),
			apply_filters( 'bfdis_medium_crop', (bool) $thumbnail_dimensions['crop'] )
		);

		add_image_size(
			'large',
			apply_filters( 'bfdis_large_width', $thumbnail_dimensions['width'] ),
			apply_filters( 'bfdis_large_height', $thumbnail_dimensions['height'] ),
			apply_filters( 'bfdis_large_crop', (bool) $thumbnail_dimensions['crop'] )
		);
	}

	add_action( 'after_setup_theme', 'bfdis_alter_default_image_sizes' );

endif;