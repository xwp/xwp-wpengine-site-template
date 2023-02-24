<?php
/**
 * Example Test.
 *
 * @package WPEngineSiteTemplate
 */

/**
 * Test that the WordPress test suite is working.
 */
class Test_Example extends \WP_UnitTestCase {

	/**
	 * Test that the WordPress test suite is working.
	 *
	 * @return void
	 */
	public function test_actions_exist() {
		$this->assertTrue( function_exists( 'add_action' ) );
	}
}
