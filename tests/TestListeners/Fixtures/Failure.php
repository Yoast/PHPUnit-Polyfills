<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "failed test" to pass to the test listener.
 */
class Failure extends TestCase {

	/**
	 * Test resulting in a failed test.
	 *
	 * @return void
	 */
	protected function runTest() {
		$this->fail();
	}
}
