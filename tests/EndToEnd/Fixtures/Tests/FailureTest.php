<?php

namespace Yoast\PHPUnitPolyfills\Tests\EndToEnd\Fixtures\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "failed test" to pass to the test listener.
 */
class FailureTest extends TestCase {

	/**
	 * Test resulting in a failed test.
	 *
	 * @return void
	 */
	public function testFailure() {
		$this->fail();
	}
}
