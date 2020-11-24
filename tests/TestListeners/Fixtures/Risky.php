<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "risky test" to pass to the test listener.
 */
class Risky extends TestCase {

	/**
	 * Test resulting in a test marked as risky.
	 *
	 * @return void
	 */
	protected function runTest() {
		$this->markAsRisky();
	}
}
