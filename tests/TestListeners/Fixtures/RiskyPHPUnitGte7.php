<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "risky test" to pass to the test listener.
 *
 * @requires PHPUnit 7.0
 */
class RiskyPHPUnitGte7 extends TestCase {

	/**
	 * Test resulting in a test marked as risky.
	 *
	 * @return void
	 */
	protected function testForListener() {
		$this->markAsRisky();
	}
}
