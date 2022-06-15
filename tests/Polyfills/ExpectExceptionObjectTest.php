<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Exception;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionObject;

/**
 * Availability test for the function polyfilled by the ExpectExceptionObject trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionObject
 */
final class ExpectExceptionObjectTest extends TestCase {

	use ExpectException; // Needed for PHPUnit < 5.2.0 support.
	use ExpectExceptionObject;

	/**
	 * Verify availability of the expectExceptionObject() method.
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testExpectExceptionObject() {
		$exception = new Exception( 'message', 101 );
		$this->expectExceptionObject( $exception );

		throw new Exception( 'message', 101 );
	}
}
