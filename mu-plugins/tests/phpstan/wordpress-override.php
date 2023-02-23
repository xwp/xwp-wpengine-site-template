<?php
// phpcs:ignoreFile
// See https://github.com/szepeviktor/phpstan-wordpress/issues/42

/**
 * Determines whether current WordPress query has posts to loop over.
 *
 * @phpstan-impure
 *
 * @since 1.5.0
 *
 * @global WP_Query $wp_query WordPress Query object.
 *
 * @return bool True if posts are available, false if end of the loop.
 */
function have_posts() {}

/**
 * have_rows
 *
 * Checks if a field (such as Repeater or Flexible Content) has any rows of data to loop over.
 * This function is intended to be used in conjunction with the_row() to step through available values.
 *
 * @phpstan-impure
 *
 * @date    2/09/13
 * @since   4.3.0
 *
 * @param   string $selector The field name or field key.
 * @param   mixed  $post_id The post ID where the value is saved. Defaults to the current post.
 * @return  bool
 */
function have_rows($selector, $post_id = false ) {}
