<?php
/**
 * Include the object cache plugin.
 *
 * Used on local only.
 *
 * @package Memcached
 */

if ( file_exists( __DIR__ . '/mu-plugins/memcached/object-cache.php' ) && class_exists( 'Memcache' ) ) {
	require_once __DIR__ . '/mu-plugins/memcached/object-cache.php';
}
