<?php
/*
Plugin Name: CPT - Our History Slides
Description: Adds CPT for our history slides
Version: 1.0
Author: Scott Cariss
Author URI: http://l3rady.com
*/

!defined( 'ABSPATH' ) and exit;

Class YesHistory {
	const CPT_NAME = "yes-history";

	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'show_all_by_menu_order' ) );
	}


	public static function register_post_type() {
		$args = array(
			"label"                => "Our History",
			"public"               => false,
			"supports"             => array( "title", "editor", "page-attributes" ),
			"rewrite"              => false,
			"show_ui"              => true,
			"admin_post_sort"      => true,
			"admin_featured_image" => true
		);

		register_post_type( self::CPT_NAME, $args );
	}


	public static function show_all_by_menu_order( $query ) {
		if ( isset( $query->query['post_type'] ) && $query->query['post_type'] === self::CPT_NAME ) {
			$query->set( 'posts_per_page', -1 );
			$query->set( 'orderby', 'menu_order' );
			$query->set( 'order', 'ASC' );
		}
	}
}

YesHistory::init();
