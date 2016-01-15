<?php
/**
 * Fixes PHP Storm Code warnings etc
 *
 * @var $wpdb            wpdb
 * @var $wp              wp
 * @var $wp_admin_bar    WP_Admin_Bar
 * @var $wp_filesystem   WP_Filesystem_Base
 * @var $wp_object_cache WP_Object_Cache
 */
global $wpdb, $wp, $wp_admin_bar, $wp_filesystem, $wp_object_cache;

if ( file_exists( $_SERVER['DOCUMENT_ROOT'] . '/config-local.php' ) ) {
	include( $_SERVER['DOCUMENT_ROOT'] . '/config-local.php' );
}


if ( !defined( 'WP_SITEURL' ) ) {
	define( 'WP_SITEURL', 'XXXXXXX' );
}
if ( !defined( 'WP_HOME' ) ) {
	define( 'WP_HOME', 'XXXXXXX');
}

if ( !defined( 'WP_CONTENT_DIR' ) ) {
	define( 'WP_CONTENT_DIR', $_SERVER['DOCUMENT_ROOT'] . '/wp-content' );
}

if ( !defined( 'WP_CONTENT_URL' ) ) {
	define( 'WP_CONTENT_URL', 'http://' . $_SERVER['SERVER_NAME'] . '/wp-content' );
}


if ( !defined( 'WP_DEFAULT_THEME' ) ) {
	define( 'WP_DEFAULT_THEME', 'XXXXXXX' );
}

/* DATABASE */
if ( !defined( 'DB_TABLE_PREFIX' ) ) {
	define( 'DB_TABLE_PREFIX', 'wp_' );
}
if ( !defined( 'DB_HOST' ) ) {
	define( 'DB_HOST', 'XXXXXXX' );
}
if ( !defined( 'DB_NAME' ) ) {
	define( 'DB_NAME', 'XXXXXXX' );
}
if ( !defined( 'DB_USER' ) ) {
	define( 'DB_USER', 'XXXXXXX' );
}
if ( !defined( 'DB_PASSWORD' ) ) {
	define( 'DB_PASSWORD', 'XXXXXXX' );
}
if ( !defined( 'DB_CHARSET' ) ) {
	define( 'DB_CHARSET', 'utf8' );
}
if ( !defined( 'DB_COLLATE' ) ) {
	define( 'DB_COLLATE', '' );
}


/* KEYS */
if ( !defined( 'AUTH_KEY' ) ) {
	define( 'AUTH_KEY', 'Q-({mx)4JeBx6]BdC--ahY(wO;dc3z/=Q=k/BqD$~f-B^1r`l}CmiaDIC@nm^xO_' );
}
if ( !defined( 'SECURE_AUTH_KEY' ) ) {
	define( 'SECURE_AUTH_KEY', '[IcS)n>JKooo`)@q*#M%B@elL0>{!=Y=eNj{qS*W=ivW%kt>jOXIp5lPmTnLsT|T' );
}
if ( !defined( 'LOGGED_IN_KEY' ) ) {
	define( 'LOGGED_IN_KEY', 'd--3YK^+XRL,UASbVBcc1pFR:l: %q`{MRN|V_F#&lMN-#G]-m4$l+:Efsx?*G<7' );
}
if ( !defined( 'NONCE_KEY' ) ) {
	define( 'NONCE_KEY', '}+F]U0G)1Cyo4c++c~7^$Yy`|wr|1F(n+DW?O<]lY F<V2/OlC0&%+zK>{g<n1IC' );
}
if ( !defined( 'AUTH_SALT' ) ) {
	define( 'AUTH_SALT', '+LS-@AXW~WY>gm:Qdt:xoxDr%DPl1Y$+/Pd_)+lW#@ P6g&!%[%X79N4p2||@4d4' );
}
if ( !defined( 'SECURE_AUTH_SALT' ) ) {
	define( 'SECURE_AUTH_SALT', '{o(hH&nPR<.|W%/>l/|<z%{@]?OUzuMvHG;k|vy)%%0$[ |mN+0JZD;G2e0|D8y.' );
}
if ( !defined( 'LOGGED_IN_SALT' ) ) {
	define( 'LOGGED_IN_SALT', 'FBW{)T;g!J2k-+8_9xO/aP`-G=wCDKT>eiMef}>72l&Zq97:R.mp5?<mM/rN2{Dj' );
}
if ( !defined( 'NONCE_SALT' ) ) {
	define( 'NONCE_SALT', '$B)r,*=Aj/tbW{Zb9;@ggfM:<gR=<hIWN^89b2y*tR?4</=}H`=|*q_YKdJFlmd|' );
}

if ( !defined( 'CAN_UPDATE' ) ) {
	define( 'CAN_UPDATE', FALSE );
}

if ( !defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', FALSE );
}

if ( !defined( 'WPLANG' ) ) {
	define( 'WPLANG', '' );
}

if ( !defined( 'DISALLOW_FILE_EDIT' ) ) {
	define( 'DISALLOW_FILE_EDIT', TRUE );
}

if ( !defined( 'AUTOMATIC_UPDATER_DISABLED' ) ) {
	define( 'AUTOMATIC_UPDATER_DISABLED', TRUE );
}

if( !defined( 'COOKIE_DOMAIN' ) ) {
	define( 'COOKIE_DOMAIN', '.' . preg_replace( '/^www\./', '', $_SERVER[ 'SERVER_NAME' ] ) );
}

if ( !defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/wp/' );
}

$table_prefix = DB_TABLE_PREFIX;

require_once( ABSPATH . 'wp-settings.php' );
