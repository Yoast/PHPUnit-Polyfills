<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a test error to pass to the test listener.
 */
class TestError extends TestCase {

	/**
	 * Test resulting in an error.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	protected function runTest() {
		throw new Exception();
	}
}
