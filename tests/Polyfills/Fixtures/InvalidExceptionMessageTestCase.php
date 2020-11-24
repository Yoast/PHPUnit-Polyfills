<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures;

use Exception;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * Fixture to test the exception method polyfills for correctly failing on an invalid argument.
 */
class InvalidExceptionMessageTestCase extends TestCase {

	use ExpectException;

	/**
	 * Test resulting in an "invalid argument type" exception for the expectExceptionMessage() call.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	public function test() {
		$this->expectExceptionMessage( [ 1, 2, 3 ] );

		throw new Exception( 'A runtime error occurred', 999 );
	}
}
