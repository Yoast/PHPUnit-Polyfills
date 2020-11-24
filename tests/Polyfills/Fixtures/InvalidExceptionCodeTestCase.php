<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures;

use Exception;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;

/**
 * Fixture to test the exception method polyfills for correctly failing on an invalid argument.
 */
class InvalidExceptionCodeTestCase extends TestCase {

	use ExpectException;

	/**
	 * Test resulting in an "invalid argument type" exception for the expectExceptionCode() call.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	public function test() {
		$this->expectExceptionCode( null );

		throw new Exception( 'A runtime error occurred', 999 );
	}
}
