<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures;

use Exception;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * Fixture to test the exception method polyfills for correctly failing when expectations
 * have been set for both the message as well as the code.
 */
class ThrowExceptionTestCase extends TestCase {

	// Needed for PHPUnit 4.x.
	use ExpectException;

	/**
	 * Test resulting in an exception.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	public function test() {
		throw new Exception( 'A runtime error occurred', 999 );
	}
}
