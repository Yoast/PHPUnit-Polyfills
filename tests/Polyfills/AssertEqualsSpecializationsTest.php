<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertEqualsSpecializations;

/**
 * Availability test for the functions polyfilled by the AssertEqualsSpecializations trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertEqualsSpecializations
 */
final class AssertEqualsSpecializationsTest extends TestCase {

	use AssertEqualsSpecializations;

	/**
	 * Verify availability of the assertEqualsCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testAssertEqualsCanonicalizing() {
		self::assertEqualsCanonicalizing( [ 3, 2, 1 ], [ 2, 3, 1 ] );
	}

	/**
	 * Verify availability of the assertEqualsIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertEqualsIgnoringCase() {
		static::assertEqualsIgnoringCase( 'a', 'A' );
	}

	/**
	 * Verify availability of the assertEqualsWithDelta() method.
	 *
	 * @return void
	 */
	public function testAssertEqualsWithDelta() {
		$this->assertEqualsWithDelta( 2.3, 2.5, 0.5 );
	}

	/**
	 * Verify availability of the assertNotEqualsCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testAssertNotEqualsCanonicalizing() {
		$this->assertNotEqualsCanonicalizing( [ 3, 2, 1 ], [ 2, 3, 4 ] );
	}

	/**
	 * Verify availability of the assertNotEqualsIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertNotEqualsIgnoringCase() {
		static::assertNotEqualsIgnoringCase( 'a', 'B' );
	}

	/**
	 * Verify availability of the assertNotEqualsWithDelta() method.
	 *
	 * @return void
	 */
	public function testAssertNotEqualsWithDelta() {
		self::assertNotEqualsWithDelta( 2.3, 3.5, 0.5 );
	}
}
