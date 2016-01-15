<?php
/*
Plugin Name: Admin Screen Post Sort
Plugin URI:
Description: Allows WP post types to be ordered by a drag and drop interface in the post list screen when the post type is added through this plugins filter.
Author: Scott Cariss
Version: 1.2.4
Author URI: http://l3rady.com
*/

// Not WordPress? Stop!
!defined( 'ABSPATH' ) and exit;

if ( !class_exists( 'BigFishAdminScreenPostSort' ) ) {
	Class BigFishAdminScreenPostSort {
		private $post_types = array();


		public static function instance() {
			static $inst = null;

			if ( $inst === null ) {
				$inst = new BigFishAdminScreenPostSort();
			}

			return $inst;
		}


		private function __clone() {
			// Clone not allowed
		}


		private function __construct() {
			add_action( 'registered_post_type', array( $this, 'checkRegisteredPostType' ), 10, 2 );
			add_action( 'admin_init', array( $this, 'integrateWith' ) );
			add_filter( 'bf_api_methods_filter', array( $this, 'addApiMethods' ) );
			add_action( 'bf_api_call_action_bfasps_do_sort', array( $this, 'ajaxSubmitNewOrder' ) );
		}


		public function checkRegisteredPostType( $post_type, $args ) {
			if ( !isset( $args->admin_post_sort ) || !$args->admin_post_sort || $args->hierarchical ) {
				return;
			}

			$this->post_types[] = $post_type;
		}


		public function integrateWith() {
			$this->post_types = apply_filters( 'bfasps_posts_to_filter', $this->post_types );

			if ( empty( $this->post_types ) ) {
				return;
			}

			add_action( 'load-edit.php', array( $this, 'shouldLoadAssets' ) );
		}


		public function addApiMethods( $methods ) {
			return array_merge( $methods, array( 'bfasps_do_sort' ) );
		}


		public function shouldLoadAssets() {
			if ( !isset( $_GET['post_type'] ) || !in_array( $_GET['post_type'], $this->post_types ) ) {
				return;
			}

			add_action( 'pre_get_posts', array( $this, 'orderCptsByMenuOrder' ) );

			add_action( 'admin_print_styles', array( $this, 'adminCss' ) );
			add_action( 'admin_print_scripts', function () {
				wp_enqueue_script( 'jquery-ui-sortable' );
			} );
			add_action( 'admin_print_footer_scripts', array( $this, 'adminJs' ) );

			foreach ( $this->post_types as $post_type ) {
				add_filter( 'manage_edit-' . $post_type . '_columns', array( $this, 'addSortableColumn' ) );
				add_action( 'manage_' . $post_type . '_posts_custom_column', array( $this, 'addSortableColumnImage' ), 10, 2 );
				add_filter( 'manage_edit-' . $post_type . '_sortable_columns', '__return_empty_array' );
			}
		}


		/**
		 * @param $q WP_Query
		 */
		public function orderCptsByMenuOrder( $q ) {
			if ( !$q->is_main_query() ) {
				return;
			}

			$q->set( 'orderby', 'menu_order' );
			$q->set( 'order', 'ASC' );
			$q->set( 'posts_per_page', 99999999 );
		}


		public function adminCss() {
			?>
			<style>
				.widefat .column-bfasps_sort {
					width: 3em;
				}

				.widefat .column-bfasps_sort .bfasps_drag_handle {
					cursor: move;
					padding-top: 0.5em;
				}

				.widefat .column-bfasps_sort .bfasps_drag_handle:before {
					color: #ccc;
					font-family: 'dashicons';
					font-size: 2.5em;
					content: '\f214';
				}
			</style>
		<?php
		}


		public function adminJs() {
			?>
			<script>
				jQuery(function ($) {
					$('table.widefat').sortable(
						{
							update     : function (event, ui) {
								var
									table = $('table.widefat'),
									cpt_order = table.sortable('serialize'),
									rows = table.find('tbody tr')
									;

								rows.removeClass('alternate');
								table.find('tbody tr:even').addClass('alternate');

								$.post(
									ajaxurl + '?action=bf_api&method=bfasps_do_sort&post_type=' + typenow,
									cpt_order,
									function (returned_data) {
									}
								);
							},
							items      : 'tbody tr',
							axis       : 'y',
							containment: 'table.widefat tbody',
							cursor     : 'move',
							cancel     : 'tr.inline-edit-slides',
							handle     : '.column-bfasps_sort .bfasps_drag_handle'
						}
					)
				});
			</script>
		<?php
		}


		public function addSortableColumn( $columns ) {
			return $this->arrayInsert( $columns, array( 'bfasps_sort' => __( 'Order', 'bfasps' ) ), 1 );
		}


		public function addSortableColumnImage( $column, $post_id ) {
			switch ( $column ) {
				case 'bfasps_sort':
					echo '<div class=\'bfasps_drag_handle\' title=\'' . esc_html__( 'Drag to order', 'bfasps' ) . '\'></div>';
					break;
			}
		}


		/**
		 * @param $api BFApi
		 */
		public function ajaxSubmitNewOrder( $api ) {
			global $wpdb;

			$post_type =& $_GET['post_type'];
			$posts     =& $_POST['post'];

			if ( !isset( $post_type ) || !isset( $posts ) || !is_array( $posts ) || !in_array( $post_type, $this->post_types ) ) {
				$api->error( 'invalid_argument' );
			}

			foreach ( $posts as $post ) {
				if ( !current_user_can( 'edit_post', $post ) ) {
					$api->error( 'not_authorised' );
				}
			}

			$api->response( 'ok', $posts, true );

			foreach ( $posts as $i => $post ) {
				wp_update_post(
					array(
						'ID'         => $post,
						'menu_order' => $i
					)
				);
			}
		}


		public function arrayInsert( $array, $var, $position ) {
			$before = array_slice( $array, 0, $position );
			$after  = array_slice( $array, $position );
			$return = array_merge( $before, (array) $var );
			return array_merge( $return, $after );
		}
	}


	BigFishAdminScreenPostSort::instance();
}