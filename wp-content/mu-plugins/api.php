<?php
/*
Plugin Name: API
Plugin URI:
Description: Provides a shell API system for other Big Fish plugins to extend
Version: 1.0.3
Author: Scott Cariss
Author URI: http://l3rady.com
*/

!defined( 'ABSPATH' ) and exit;

if ( !class_exists( 'BFApi' ) ) {
	Class BFApi {
		private $auth_key;
		private $methods = array();
		private $responses = array();


		public static function instance() {
			static $inst = null;

			if ( $inst === null ) {
				$inst = new BFApi();
			}

			return $inst;
		}


		private function __clone() {
		}


		private function __construct() {
			add_filter( 'bf_api_responses_filter', array( $this, 'addBuiltInResponses' ), 1 );
			add_action( 'plugins_loaded', array( $this, 'loaded' ), 20 );
			add_action( 'wp_ajax_bf_api', array( $this, 'apiCall' ) );
			add_action( 'wp_ajax_nopriv_bf_api', array( $this, 'apiCall' ) );
		}


		public function addBuiltInResponses( $responses ) {
			return array(
				'ok'               => array(
					'code' => 200
				),
				'invalid_method'   => array(
					'code'    => 404,
					'message' => __( 'That API method doesn\'t exist.', 'bfapi' )
				),
				'not_authorised'   => array(
					'code'    => 401,
					'message' => __( 'Not authorised.', 'bfapi' )
				),
				'invalid_argument' => array(
					'code'    => 403,
					'message' => __( 'Invalid arguments.', 'bfapi' )
				)
			);
		}


		public function loaded() {
			$this->auth_key  = apply_filters( 'bf_api_auth_key_filter', md5( AUTH_KEY ) );
			$this->methods   = apply_filters( 'bf_api_methods_filter', $this->methods );
			$this->responses = apply_filters( 'bf_api_responses_filter', $this->responses );
		}


		public function apiCall() {
			$this->checkMethod();

			do_action( 'bf_api_call_action', $this );
			do_action( 'bf_api_call_action_' . $_REQUEST['method'], $this );
		}


		public function authCall() {
			if ( !isset( $_REQUEST['auth'] ) || $_REQUEST['auth'] !== $this->auth_key ) {
				$this->error( 'not_authorised' );
			}
		}


		private function checkMethod() {
			if ( !isset( $_REQUEST['method'] ) || !in_array( $_REQUEST['method'], $this->methods ) ) {
				$this->error( 'invalid_method' );
			}
		}


		public function error( $error ) {
			$content = array( 'error' => __( $this->responses[$error]['message'], 'bfapi' ) );
			$this->response( $error, $content );
		}


		public function response( $response, $content, $continue = false ) {
			@ob_end_clean();
			header( 'Connection: close' );
			ignore_user_abort( true );
			ob_start();
			echo json_encode( $content );
			$size = ob_get_length();
			status_header( $this->responses[$response]['code'] );
			header( 'Content-Length: ' . $size );
			header( 'Content-type: application/json' );
			header( 'Content-Encoding: none\r\n' );
			ob_end_flush();
			flush();
			if ( session_id() ) {
				session_write_close();
			}
			if ( !$continue ) {
				die();
			}
		}
	}

	BFApi::instance();
}