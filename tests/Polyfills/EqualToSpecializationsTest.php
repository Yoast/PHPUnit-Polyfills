<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\EqualToSpecializations;

/**
 * Availability test for the functions polyfilled by the EqualToSpecializations trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\EqualToSpecializations
 */
class EqualToSpecializationsTest extends TestCase {

	use EqualToSpecializations;

	/**
	 * Verify availability of the equalToWithDelta() method.
	 *
	 * @return void
	 */
	public function testEqualToWithDelta() {
		Assert::assertThat( 2.5, $this->equalToWithDelta( 2.3, 0.5 ) );
	}

	/**
	 * Verify availability of the equalToCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testEqualToCanonicalizing() {
		Assert::assertThat( [ 2, 3, 1 ], $this->equalToCanonicalizing( [ 3, 2, 1 ] ) );
	}

	/**
	 * Verify availability of the equalIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testEqualToIgnoringCase() {
		Assert::assertThat( 'A', $this->equalToIgnoringCase( 'a' ) );
	}

	/**
	 * Verify availability of the equalToWithDelta() method to correctly fail a comparison.
	 *
	 * @return void
	 */
	public function testEqualToWithDeltaNegative() {
		Assert::assertThat( 3.5, $this->logicalNot( $this->equalToWithDelta( 2.3, 0.5 ) ) );
	}

	/**
	 * Verify availability of the equalToCanonicalizing() method to correctly fail a comparison.
	 *
	 * @return void
	 */
	public function testEqualToCanonicalizingNegative() {
		Assert::assertThat( [ 2, 3, 1 ], $this->logicalNot( $this->equalToCanonicalizing( [ 4, 2, 1 ] ) ) );
	}

	/**
	 * Verify availability of the equalToIgnoringCaseNegative() method to correctly fail a comparison.
	 *
	 * @return void
	 */
	public function testEqualToIgnoringCaseNegative() {
		Assert::assertThat( 'A', $this->logicalNot( $this->equalToIgnoringCase( 'b' ) ) );
	}
}
