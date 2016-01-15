<?php
/*
Plugin Name: Gallery CPT
Description: Adds CPT for Gallery
Version: 1.0
Author: Alex
Author URI:
*/

defined( 'ABSPATH' ) or exit;


Class YesGallery {
	const CPT_NAME = 'yes-gallery';


	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'show_all_by_menu_order' ) );
		add_action( 'template_redirect', array( __CLASS__, 'dont_allow_single_faq' ) );
	}


	public static function register_post_type() {
		$args = array(
			'label'           => 'Gallery',
			'public'          => true,
			'supports'        => array( 'title', 'thumbnail' ),
			'rewrite'         => array(
				'slug'       => 'gallery/album',
				'with_front' => false
			),
			'has_archive'     => 'gallery',
			'admin_post_sort' => true
		);

		register_post_type( self::CPT_NAME, $args );


	}


	/**
	 * @param $q WP_Query
	 */
	public static function show_all_by_menu_order( $q ) {
		if ( !$q->is_main_query() || !isset( $q->query['post_type'] ) || $q->query['post_type'] !== self::CPT_NAME ) {
			return;
		}

		$q->set( 'orderby', 'menu_order' );
		$q->set( 'order', 'ASC' );
		$q->set( 'posts_per_page', -1 );
	}


	public static function dont_allow_single_faq() {
		if ( !is_singular( self::CPT_NAME ) ) {
			return;
		}

		wp_redirect( home_url( 'gallery' ) );
		die();
	}
}


YesGallery::init();
