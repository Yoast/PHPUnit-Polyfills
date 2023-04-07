<?php

namespace Yoast\PHPUnitPolyfills\Tests\EndToEnd\Fixtures\Tests;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a test error to pass to the test listener.
 */
class ErrorTest extends TestCase {

	/**
	 * Test resulting in an error.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	public function testError() {
		throw new Exception();
	}
}
