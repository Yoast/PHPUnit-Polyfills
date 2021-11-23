<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "successfull test" to pass to the test listener.
 *
 * @requires PHPUnit 7.0
 */
class SuccessPHPUnitGte7 extends TestCase {

	/**
	 * Test resulting in a successfull test.
	 *
	 * @return void
	 */
	protected function testForListener() {
		$this->assertTrue( true );
	}
}
