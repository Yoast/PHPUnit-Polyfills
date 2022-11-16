<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\EqualToSpecializations;

/**
 * Availability test for the functions polyfilled by the EqualToSpecializations trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\EqualToSpecializations
 */
final class EqualToSpecializationsTest extends TestCase {

	use EqualToSpecializations;

	/**
	 * Verify availability of the equalToWithDelta() method.
	 *
	 * @return void
	 */
	public function testEqualToWithDelta() {
		$this->assertThat( 2.5, $this->equalToWithDelta( 2.3, 0.5 ) );
	}

	/**
	 * Verify availability of the equalToCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testEqualToCanonicalizing() {
		self::assertThat( [ 2, 3, 1 ], static::equalToCanonicalizing( [ 3, 2, 1 ] ) );
	}

	/**
	 * Verify availability of the equalIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testEqualToIgnoringCase() {
		self::assertThat( 'A', self::equalToIgnoringCase( 'a' ) );
	}

	/**
	 * Verify ability of the equalToWithDelta() method to correctly fail a comparison.
	 *
	 * @return void
	 */
	public function testEqualToWithDeltaNegative() {
		self::assertThat( 3.5, $this->logicalNot( $this->equalToWithDelta( 2.3, 0.5 ) ) );
	}

	/**
	 * Verify ability of the equalToCanonicalizing() method to correctly fail a comparison.
	 *
	 * @return void
	 */
	public function testEqualToCanonicalizingNegative() {
		static::assertThat( [ 2, 3, 1 ], $this->logicalNot( static::equalToCanonicalizing( [ 4, 2, 1 ] ) ) );
	}

	/**
	 * Verify ability of the equalToIgnoringCaseNegative() method to correctly fail a comparison.
	 *
	 * @return void
	 */
	public function testEqualToIgnoringCaseNegative() {
		self::assertThat( 'A', $this->logicalNot( $this->equalToIgnoringCase( 'b' ) ) );
	}
}
