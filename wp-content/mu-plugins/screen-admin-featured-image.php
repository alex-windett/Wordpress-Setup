<?php
/*
Plugin Name: Admin Screen Featured Image
Plugin URI:
Description: Allows WP post types to add a featured image column to the admin screen
Author: Scott Cariss
Version: 1.0
Author URI: http://l3rady.com
*/

// Not WordPress? Stop!
defined( 'ABSPATH' ) or exit;

if ( !class_exists( 'BigFishAdminScreenFeaturedImage' ) ) {
	Class BigFishAdminScreenFeaturedImage {
		private $post_types = array();

		public static function instance() {
			static $inst = null;

			if ( $inst === null ) {
				$inst = new BigFishAdminScreenFeaturedImage();
			}

			return $inst;
		}


		private function __clone() {
			// Clone not allowed
		}


		private function __construct() {
			add_action( 'registered_post_type', array( $this, 'checkRegisteredPostType' ), 10, 2 );
			add_action( 'admin_init', array( $this, 'integrateWith' ) );
		}


		public function checkRegisteredPostType( $post_type, $args ) {
			if ( !isset( $args->admin_featured_image ) || !$args->admin_featured_image ) {
				return;
			}

			if ( !post_type_supports( $post_type, 'thumbnail' ) ) {
				return;
			}

			$this->post_types[] = $post_type;
		}


		public function integrateWith() {
			$this->post_types = apply_filters( 'bfasfi_posts_to_filter', $this->post_types );

			if ( empty( $this->post_types ) ) {
				return;
			}

			add_action( 'load-edit.php', array( $this, 'shouldLoadAssets' ) );
		}


		public function shouldLoadAssets() {
			if ( !isset( $_GET['post_type'] ) || !in_array( $_GET['post_type'], $this->post_types ) ) {
				return;
			}

			foreach ( $this->post_types as $post_type ) {
				add_filter( 'manage_edit-' . $post_type . '_columns', array( $this, 'addFeaturedImageColumn' ), 999999 );
				add_action( 'manage_' . $post_type . '_posts_custom_column', array( $this, 'addFeaturedImageColumnContent' ), 10, 2 );
			}
		}


		public function addFeaturedImageColumn( $columns ) {
			return $this->arrayInsert( $columns, array( 'bfasfi_image' => __( 'Image', 'bfasfi' ) ), 2 );
		}


		public function addFeaturedImageColumnContent( $column, $post_id ) {
			switch ( $column ) {
				case 'bfasfi_image':
					if ( has_post_thumbnail( $post_id ) ) {
						echo '<a href=\'' . get_edit_post_link( $post_id ) . '\'>' . get_the_post_thumbnail( $post_id, array( 75, 75 ) ) . '</a>';
					}
					else {
						esc_html_e( 'No Image', 'bfasfi' );
					}
					break;
			}
		}


		public function arrayInsert( $array, $var, $position ) {
			$before = array_slice( $array, 0, $position );
			$after  = array_slice( $array, $position );
			$return = array_merge( $before, (array) $var );
			return array_merge( $return, $after );
		}
	}


	BigFishAdminScreenFeaturedImage::instance();
}
