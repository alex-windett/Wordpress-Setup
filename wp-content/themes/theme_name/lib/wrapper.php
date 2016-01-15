<?php
namespace PD\ThemeFramework\Wrapper;

function template_path() {
	return ThemeFrameworkWrapping::$main_template;
}

function hold_template() {
	ob_start();
	include( template_path() );
	$contents = ob_get_contents();
	ob_end_clean();
	return $contents;
}

function sidebar_path() {
	return new ThemeFrameworkWrapping( 'templates/sidebar.php' );
}


class ThemeFrameworkWrapping {
	// Stores the full path to the main template file
	public static $main_template;
	// Basename of template file
	public $slug;
	// Array of templates
	public $templates;
	// Stores the base name of the template file; e.g. 'page' for 'page.php' etc.
	public static $base;

	public function __construct( $template = 'base.php' ) {
		$this->slug      = basename( $template, '.php' );
		$this->templates = array( $template );

		if ( self::$base ) {
			$str = substr( $template, 0, -4 );
			array_unshift( $this->templates, sprintf( $str . '-%s.php', self::$base ) );
		}
	}

	public function __toString() {
		$this->templates = apply_filters( 'fishbones/wrap_' . $this->slug, $this->templates );
		return locate_template( $this->templates );
	}

	public static function wrap( $main ) {
		// Check for other filters returning null
		if ( !is_string( $main ) ) {
			return $main;
		}

		self::$main_template = $main;
		self::$base          = basename( self::$main_template, '.php' );

		if ( self::$base === 'index' ) {
			self::$base = false;
		}

		return new ThemeFrameworkWrapping();
	}
}


add_filter( 'template_include', array( __NAMESPACE__ . '\\ThemeFrameworkWrapping', 'wrap' ), 99 );