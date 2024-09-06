<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation;

/**
 * Availability test for the functions polyfilled by the ExpectUserDeprecation trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation
 */
#[CoversClass( ExpectUserDeprecation::class )]
final class ExpectUserDeprecationTest extends TestCase {

	use ExpectUserDeprecation;

	/**
	 * Verify availability of the expectUserDeprecationMessage() method.
	 *
	 * @return void
	 */
	#[IgnoreDeprecations]
	public function testUserDeprecationMessageCanBeExpected() {
		$this->expectUserDeprecationMessage( 'foo' );

		\trigger_error( 'foo', \E_USER_DEPRECATED );
	}

	/**
	 * Verify availability of the expectUserDeprecationMessageMatches() method.
	 *
	 * @return void
	 */
	#[IgnoreDeprecations]
	public function testUserDeprecationMessageMatchCanBeExpected() {
		$this->expectUserDeprecationMessageMatches( '/foo/' );

		\trigger_error( 'foo bar', \E_USER_DEPRECATED );
	}
}
