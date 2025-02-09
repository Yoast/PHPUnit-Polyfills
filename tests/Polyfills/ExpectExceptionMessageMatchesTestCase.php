<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Exception;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * Availability test for the function polyfilled by the ExpectExceptionMessageMatches trait.
 */
abstract class ExpectExceptionMessageMatchesTestCase extends TestCase {

	use ExpectExceptionMessageMatches;

	/**
	 * Verify availability of the expectExceptionMessageMatches() method.
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testExpectExceptionMessageMatches() {
		$this->expectExceptionMessageMatches( '`^a poly[a-z]+ [a-zA-Z0-9_]+ me(s){2}age$`i' );

		throw new Exception( 'A polymorphic exception message' );
	}
}
