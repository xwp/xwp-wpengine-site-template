<?php
/**
 * Config file used only during local development.
 *
 * phpcs:disable WordPress.WP.CapitalPDangit.Misspelled, WordPress.WP.GlobalVariablesOverride.Prohibited
 */

define( 'DB_NAME', 'wordpress' );
define( 'DB_USER', 'wordpress' );
define( 'DB_PASSWORD', 'wordpress' );
define( 'DB_HOST', 'db' );

define( 'DB_CHARSET', 'utf8' );
define( 'DB_COLLATE', '' );

define( 'WP_DEBUG', true );
define( 'WP_DEBUG_DISPLAY', true );

// Keep the wp-contents outside of WP core directory.
define( 'WP_CONTENT_DIR', __DIR__ . '/wp-content' );

// Ensure object-cache.php knows where to load the assets from.
if ( ! defined( 'WPMU_PLUGIN_DIR' ) && defined( 'WP_CONTENT_DIR' ) ) {
	define( 'WPMU_PLUGIN_DIR', WP_CONTENT_DIR . '/mu-plugins' );
}

// Respond as if we were on HTTPS.
if ( isset( $_SERVER['HTTP_X_FORWARDED_PROTO'] ) && 'https' === $_SERVER['HTTP_X_FORWARDED_PROTO'] ) {
	$_SERVER['HTTPS'] = 'on';
}

define( 'WP_ALLOW_MULTISITE', true );
define( 'MULTISITE', true );
define( 'SUBDOMAIN_INSTALL', true );
$base = '/';
define( 'DOMAIN_CURRENT_SITE', 'local.wpengine.test' );
define( 'PATH_CURRENT_SITE', '/' );
define( 'SITE_ID_CURRENT_SITE', 1 );
define( 'BLOG_ID_CURRENT_SITE', 1 );

// Define our custom Memcached server for object caching.
$memcached_servers = [
	'default' => [
		'memcached:11211',
	],
];

$table_prefix = 'wp_';

require_once ABSPATH . 'wp-settings.php';
