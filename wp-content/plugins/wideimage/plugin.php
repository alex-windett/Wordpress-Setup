<?php
/*
Plugin Name: WideImage
Plugin URI:
Description:
Version: 0.2.1
Author: Scott Cariss
Author URI: http://l3rady.com
*/

!defined( 'ABSPATH' ) and exit;

if ( !class_exists( 'BFWideImage' ) ) {
	Class BFWideImage {
		const CACHE_GROUP  = 'bfwi';
		const BROKEN_IMAGE = 'http://placehold.it/%1$dx%2$d&text=%3$s';

		private $wide_image_dir;
		private $wide_image_url;
		private $allowed_img_ext = array( 'gif', 'png', 'jpg', 'jpeg' );


		public static function instance() {
			static $inst = null;

			if ( $inst === null ) {
				$inst = new BFWideImage();
			}

			return $inst;
		}


		private function __clone() {
		}


		private function __construct() {
			$this->wide_image_dir = WP_CONTENT_DIR . DIRECTORY_SEPARATOR . 'wideimage' . DIRECTORY_SEPARATOR;
			$this->wide_image_url = trailingslashit( WP_CONTENT_URL ) . 'wideimage/';

			add_filter( 'bfwi_image_exists_filter', array( $this, 'imageExistsFilter' ), 10, 2 );
		}


		public function timthumbReplacement( $image_src, $width, $height, $zoom_crop = 1 ) {
			$ext = $this->getImageExt( $image_src );

			if ( !$ext ) {
				return false;
			}

			$key    = $this->makeKey( 'timthumbReplacement', $image_src, $width, $height, $zoom_crop ) . '.' . $ext;
			$exists = $this->doesImageExistsAlready( $key );

			if ( $exists ) {
				return apply_filters( 'bfwi_image_url_filter', $this->wide_image_url . $key, $key );
			}

			try {
				/**
				 * @var $img WideImage_Image
				 */
				$img = WideImage::load( $image_src );

				switch( $zoom_crop ) {

					case 0:
						$img = $img->resize( $width, $height, 'fill' );
						break;

					case 2:
					case 3:
						$img = $img->resize( $width, $height, 'inside' );
						break;

					default:
						$img = $img->resize( $width, $height, 'outside' );
						break;
				}

				if ( $width !== null && $height !== null ) {
					if( $zoom_crop !== 2 ) {
						$img = $img->crop( 'center', 'center', $width, $height );
					}

					if( $zoom_crop === 2 ) {
						$white = $img->allocateColor( 255, 255, 255 );
						$img   = $img->resizeCanvas( $width, $height, 'center', 'center', $white );
					}
				}

				return $this->saveImage( $img, $key, $ext );
			} catch ( Exception $e ) {
				return false;
			}
		}


		public function doesImageExistsAlready( $key ) {
			$cache_key     = 'image_exists:' . $key;
			$found         = false;
			$cached_exists = wp_cache_get( $cache_key, self::CACHE_GROUP, false, $found );

			if ( $found ) {
				return $cached_exists;
			}

			if ( apply_filters( 'bfwi_image_exists_filter', false, $key ) ) {
				wp_cache_set( $cache_key, true, self::CACHE_GROUP );
				return true;
			}

			wp_cache_set( $cache_key, false, self::CACHE_GROUP );
			return false;
		}


		private function getImageExt( $image_src ) {
			$found      = false;
			$key        = 'imageExt:' . $image_src;
			$cached_ext = wp_cache_get( $key, self::CACHE_GROUP, false, $found );

			if ( $found !== false ) {
				return $cached_ext;
			}

			$image_src_info = pathinfo( $image_src );

			if ( $image_src_info && isset( $image_src_info['extension'] ) ) {
				$ext = strtolower( $image_src_info['extension'] );

				if ( in_array( $ext, $this->allowed_img_ext ) ) {
					wp_cache_set( $key, $ext, self::CACHE_GROUP );

					return $ext;
				}

				wp_cache_set( $key, false, self::CACHE_GROUP );
				return false;
			}

			$img_as_string = @file_get_contents( $image_src );

			if ( !$img_as_string ) {
				wp_cache_set( $key, false, self::CACHE_GROUP );
				return false;
			}

			$image_meta = @getimagesizefromstring( $img_as_string );

			if ( !$image_meta || empty( $image_meta['mime'] ) ) {
				wp_cache_set( $key, false, self::CACHE_GROUP );
				return false;
			}

			$ext = explode( '/', $image_meta['mime'] );

			if ( in_array( $ext[1], $this->allowed_img_ext ) ) {
				wp_cache_set( $key, $ext[1], self::CACHE_GROUP );

				return $ext[1];
			}

			wp_cache_set( $key, false, self::CACHE_GROUP );
			return false;
		}


		private function makeKey() {
			return md5( implode( ':', func_get_args() ) );
		}


		public function imageExistsFilter( $exists, $key ) {
			unset( $exists );
			return file_exists( $this->wide_image_dir . $key );
		}


		/**
		 * @param WideImage_Image $img
		 * @param string          $key
		 * @param string          $ext
		 *
		 * @return string
		 */
		private function saveImage( $img, $key, $ext ) {
			$path = apply_filters( 'bfwi_change_save_path_filter', $this->wide_image_dir . $key, $key );
			if ( $ext === 'jpg' || $ext === 'jpeg' ) {
				$img->saveToFile( $path, 90 );
			}
			else {
				$img->saveToFile( $path );
			}

			do_action( 'bfwi_img_saved_action', $key, $path );
			wp_cache_set( 'image_exists:' . $key, true, self::CACHE_GROUP );
			return apply_filters( 'bfwi_image_url_filter', $this->wide_image_url . $key, $key );
		}


		/**
		 * @return string
		 */
		public function getWideImageDir() {
			return $this->wide_image_dir;
		}

		/**
		 * @return string
		 */
		public function getWideImageUrl() {
			return $this->wide_image_url;
		}
	}
}


if ( !function_exists( 'timthumb' ) ) {
	function timthumb( $image_src, $width = 0, $height = 0, $zoom_crop = 1, $sharpen = 0, $filter = 0 ) {
		unset( $sharpen );
		unset( $filter );

		$width  = max( 0, intval( $width ) );
		$height = max( 0, intval( $height ) );

		if ( $width === 0 ) {
			$width = null;
		}

		if ( $height === 0 ) {
			$height = null;
		}

		return BFWideImage::instance()->timthumbReplacement( $image_src, $width, $height, $zoom_crop );
	}
}


// This function was introduced in  >= PHP 5.4.
if ( !function_exists( 'getimagesizefromstring' ) ) {
	function getimagesizefromstring( $string_data ) {
		$uri = 'data://application/octet-stream;base64,' . base64_encode( $string_data );
		return getimagesize( $uri );
	}
}

include( 'wideimage/WideImage.php' );