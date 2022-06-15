<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertNumericType;

/**
 * Availability test for the functions polyfilled by the AssertNumericType trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertNumericType
 */
final class AssertNumericTypeTest extends TestCase {

	use AssertNumericType;

	/**
	 * Verify availability of the assertFinite() method.
	 *
	 * @return void
	 */
	public function testAssertFinite() {
		$this->assertFinite( 1 );
	}

	/**
	 * Verify availability of the assertInfinite() method.
	 *
	 * @return void
	 */
	public function testAssertInfinite() {
		$this->assertInfinite( \log( 0 ) );
	}

	/**
	 * Verify availability of the assertNan() method.
	 *
	 * @return void
	 */
	public function testAssertNan() {
		self::assertNan( \acos( 8 ) );
	}
}
