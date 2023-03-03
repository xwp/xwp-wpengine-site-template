<?php
/**
 * Bootstrap all must-use plugins.
 *
 * @package WPEngineSiteTemplate
 */

/**
 * List all the must-use (MU) plugins to be loaded for this site
 * relative to this directory root.
 *
 * @var array
 */
$mu_plugin_files = [
	// 'example-plugin/plugin.php',
];

foreach ( $mu_plugin_files as $mu_plugin_file ) {
	$mu_plugin_file_path = sprintf( '%s/%s', __DIR__, $mu_plugin_file );

	if ( file_exists( $mu_plugin_file_path ) ) {
		require_once $mu_plugin_file_path;
	}
}
