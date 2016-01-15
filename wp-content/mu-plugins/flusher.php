<?php
/*
Plugin Name: Admin Bar Flusher
Plugin URI: http://www.windett.co.uk
Description: Adds admin bar links for admins to flush rewrite rules and object cache.
Version: 1.1
Author: Scott Cariss
Author URI: http://l3rady.com
*/

!defined( 'ABSPATH' ) and exit;

if ( !class_exists( 'BFFlusher' ) ) {
	/**
	 * Class BFFlusher
	 */
	Class BFFlusher {
		/**
		 * @return BFFlusher
		 */
		public static function instance() {
			static $inst = null;

			if ( $inst === null ) {
				$inst = new BFFlusher();
			}

			return $inst;
		}


		/**
		 * Don't allow cloning of this class
		 */
		private function __clone() {
		}


		/**
		 * Don't allow external new BFFlusher
		 */
		private function __construct() {
			add_action( 'admin_bar_menu', array( $this, 'adminBarMenu' ), 100 ); // Add items to admin bar
			add_action( 'admin_init', array( $this, 'isTriggered' ) ); // Check for flush actions
		}


		public function adminBarMenu() {
			global $wp_admin_bar;

			// Only add to admin bar if user is an administrator
			if ( !current_user_can( 'administrator' ) ) {
				return;
			}

			// Add top level item
			$wp_admin_bar->add_menu(
				array(
					'id'    => 'bf-flusher',
					'meta'  => array(),
					'title' => esc_html__( 'Flusher', 'bfflusher' ),
					'href'  => false
				)
			);

			// Add sub level item to flush permalinks
			$wp_admin_bar->add_menu(
				array(
					'parent' => 'bf-flusher',
					'id'     => 'bf-flusher-permalinks',
					'meta'   => array(),
					'title'  => esc_html__( 'Flush Permalinks', 'bfflusher' ),
					'href'   => wp_nonce_url( admin_url( '?bf-flusher=permalinks' ), 'flush_permalinks' )
				)
			);

			// Add sub level item to flush object cache
			$wp_admin_bar->add_menu(
				array(
					'parent' => 'bf-flusher',
					'id'     => 'bf-flusher-object-cache',
					'meta'   => array(),
					'title'  => esc_html__( 'Flush Object Cache', 'bfflusher' ),
					'href'   => wp_nonce_url( admin_url( '?bf-flusher=object-cache' ), 'flush_object-cache' )
				)
			);
		}


		public function isTriggered() {
			$flusher =& $_REQUEST['bf-flusher'];
			$nonce   =& $_REQUEST['_wpnonce'];

			// Don't do anything if we don't see a flush request or the user is not an administrator
			if ( !isset( $flusher ) || !current_user_can( 'administrator' ) ) {
				return;
			}

			// Verify the nonce security token. If not valid die with permission denied
			if ( !isset( $nonce ) || !wp_verify_nonce( $nonce, 'flush_' . $flusher ) ) {
				wp_die( esc_html__( 'Permission Denied', 'bfflusher' ) );
			}

			// Which flush action are we to perform?
			switch ( $flusher ) {
				case 'permalinks':
					flush_rewrite_rules();
					break;

				case 'object-cache':
					function_exists( 'wp_cache_flush_site' )
						? wp_cache_flush_site()
						: wp_cache_flush();
					break;
			}

			// Safe redirect to the page that the user originally came from.
			wp_safe_redirect( $_SERVER['HTTP_REFERER'] );
			die();
		}
	}


	// Run
	BFFlusher::instance();
}
