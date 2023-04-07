<?php

namespace Yoast\PHPUnitPolyfills\Tests\EndToEnd\Fixtures\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "risky test" to pass to the test listener.
 */
class RiskyTest extends TestCase {

	/**
	 * Test resulting in a test marked as risky.
	 *
	 * @return void
	 */
	public function testRisky() {
		$this->markAsRisky();
	}
}
