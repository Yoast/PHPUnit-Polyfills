<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Exception;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation;

/**
 * Availability test for the function polyfilled by the ExpectUserDeprecation trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation
 */
#[CoversClass( ExpectUserDeprecation::class )]
final class ExpectUserDeprecationTest extends TestCase {

	use ExpectUserDeprecation;

	/**
	 * Verify availability of the ExpectUserDeprecation() method.
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 * /
	public function testExpectExceptionMessageMatches() {
		$this->expectExceptionMessageMatches( '`^a poly[a-z]+ [a-zA-Z0-9_]+ me(s){2}age$`i' );

		throw new Exception( 'A polymorphic exception message' );
	}
	*/
}
