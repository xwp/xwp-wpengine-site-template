<?php
/**
 * Extend WP Config.
 *
 * @package WPEngineSiteTemplate
 */

// Load Composer autoloader.
require dirname( __DIR__ ) . '/plugins/vendor/autoload.php';

/**
 * Set a high default limit to avoid too many revisions from polluting the database.
 *
 * Posts with extremely high revisions can result in fatal errors or have performance issues.
 *
 * Feel free to adjust this depending on your use cases.
 */
if ( ! defined( 'WP_POST_REVISIONS' ) ) {
	define( 'WP_POST_REVISIONS', 100 );
}

if ( ! defined( 'WP_ENVIRONMENT_TYPE' ) ) {
	if ( isset( $_SERVER['HTTP_HOST'] ) ) {
		if ( strpos( $_SERVER['HTTP_HOST'], 'stg' ) !== false ) {
			define( 'WP_ENVIRONMENT_TYPE', 'staging' );
		} elseif ( strpos( $_SERVER['HTTP_HOST'], 'dev' ) !== false ) {
			define( 'WP_ENVIRONMENT_TYPE', 'development' );
		} elseif ( strpos( $_SERVER['HTTP_HOST'], 'local' ) !== false ) {
			define( 'WP_ENVIRONMENT_TYPE', 'local' );
		} else {
			define( 'WP_ENVIRONMENT_TYPE', 'production' );
		}
	} else {
		// Default to production environment, which is what WordPress/WPE considers each environment to be.
		define( 'WP_ENVIRONMENT_TYPE', 'production' );
	}
}

// Set the default theme for new sites.
if ( ! defined( 'WP_DEFAULT_THEME' ) ) {
	define( 'WP_DEFAULT_THEME', 'twentytwenty' );
}

// Disable file modifications on all environments, except local.
if ( defined( 'WP_ENVIRONMENT_TYPE' ) && WP_ENVIRONMENT_TYPE === 'local' ) {
	if ( ! defined( 'DISALLOW_FILE_MODS' ) ) {
		define( 'DISALLOW_FILE_MODS', true );
	}

	if ( ! defined( 'DISALLOW_FILE_EDIT' ) ) {
		define( 'DISALLOW_FILE_EDIT', true );
	}

	if ( ! defined( 'AUTOMATIC_UPDATER_DISABLED' ) ) {
		define( 'AUTOMATIC_UPDATER_DISABLED', true );
	}

	// Enable offline mode to ensure it doesn't connect to WP.com.
	if ( ! defined( 'JETPACK_DEV_DEBUG' ) ) {
		define( 'JETPACK_DEV_DEBUG', true );
	}
}

/**
 * Disable crawling on non production environments by default.
 */
if ( defined( 'WP_ENVIRONMENT_TYPE' ) && WP_ENVIRONMENT_TYPE !== 'production' ) {
	add_action(
		'send_headers',
		function () {
			header( 'X-Robots-Tag: noindex', true );
		}
	);

	add_filter(
		'pre_option_blog_public',
		function ( $value ) {
			// Adjust only if the blog is set to public.
			if ( 1 === $value ) {
				return 0;
			}

			return $value;
		}
	);
}

/**
 * Set WP_DEBUG to true for all local or non-production environments to ensure
 * _doing_it_wrong() notices displayed. This also changes the error_reporting level to E_ALL.
 *
 * @see https://wordpress.org/support/article/debugging-in-wordpress/#wp_debug
 */
if ( defined( 'WP_ENVIRONMENT_TYPE' ) && WP_ENVIRONMENT_TYPE === 'local' && ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
}
