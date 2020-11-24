<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "successfull test" to pass to the test listener.
 */
class Success extends TestCase {

	/**
	 * Test resulting in a successfull test.
	 *
	 * @return void
	 */
	protected function runTest() {
		$this->assertTrue( true );
	}
}
