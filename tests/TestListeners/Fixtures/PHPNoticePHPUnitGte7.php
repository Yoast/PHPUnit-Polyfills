<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a test error to pass to the test listener.
 *
 * @requires PHPUnit 7.0
 */
class PHPNoticePHPUnitGte7 extends TestCase {

	/**
	 * Test resulting in a PHP notice.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	protected function testForListener() {
		// Triggers a notice in all supported PHP versions.
		\date_default_timezone_set( 'unknown' );
	}
}
