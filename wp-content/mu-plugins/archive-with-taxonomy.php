<?php
/*
Plugin Name: Team CPT
Plugin URI: http://www.windett.com
Description: Adds CPT for Team
Version: 1.0
Author: Alex
Author URI:
*/

defined( 'ABSPATH' ) or exit;


Class YesTeam {
	const CPT_NAME = 'yes-team';
	const CATEGORY_NAME = 'yes-team-cat';


	public static function init() {
		add_action( 'init', array( __CLASS__, 'register_post_type' ) );
		add_action( 'init', array( __CLASS__, 'register_taxonomy' ) );
		add_action( 'pre_get_posts', array( __CLASS__, 'show_all_by_menu_order' ) );
	}


	public static function register_post_type() {
		$args = array(
			'label'    => 'Team',
			'public'   => true,
			'has_archive' => 'about-us/our-team',
			'supports' => array( 'title', 'editor', 'thumbnail' ),
			'rewrite'  => array(
				'slug'       => 'about-us/our-team/member',
				'with_front' => false,
				'pages'      => false
			),
			'admin_post_sort' => true
		);

		register_post_type( self::CPT_NAME, $args );
	}

	public static function register_taxonomy() {
		$args = array(
			'label'             => 'Affiliation',
			'hierarchical'      => true,
			'show_admin_column' => true,
			'rewrite'           => array(
				'slug'       => 'about-us/our-team/affiliation',
				'with_front' => false,
			),
		);

		register_taxonomy( self::CATEGORY_NAME, self::CPT_NAME, $args );
	}

	public static function show_all_by_menu_order( $q ) {
		if ( !$q->is_main_query() || !isset( $q->query['post_type'] ) || $q->query['post_type'] !== self::CPT_NAME ) {
			return;
		}

		$q->set( 'orderby', 'menu_order' );
		$q->set( 'order', 'ASC' );
		$q->set( 'posts_per_page', -1 );
	}
}


YesTeam::init();
