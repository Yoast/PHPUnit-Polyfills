<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertFileEqualsSpecializations;

/**
 * Availability test for the functions polyfilled by the AssertFileEqualsSpecializations trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertFileEqualsSpecializations
 */
final class AssertFileEqualsSpecializationsTest extends TestCase {

	use AssertFileEqualsSpecializations;

	const PATH_TO_EXPECTED = '/Fixtures/AssertFileEqualsSpecialization_Expected.txt';

	const PATH_TO_EQUALS = '/Fixtures/AssertFileEqualsSpecialization_Equals.txt';

	const PATH_TO_NOT_EQUALS = '/Fixtures/AssertFileEqualsSpecialization_NotEquals.txt';

	const PATH_TO_EQUALS_CI = '/Fixtures/AssertFileEqualsSpecialization_EqualsCI.txt';

	const PATH_TO_NOT_EQUALS_CI = '/Fixtures/AssertFileEqualsSpecialization_NotEqualsCI.txt';

	/**
	 * Verify availability of the assertFileEqualsCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testAssertFileEqualsCanonicalizing() {
		$expected = __DIR__ . self::PATH_TO_EXPECTED;
		$input    = __DIR__ . self::PATH_TO_EQUALS;
		$this->assertFileEqualsCanonicalizing( $expected, $input );
	}

	/**
	 * Verify availability of the assertFileEqualsIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertFileEqualsIgnoringCase() {
		$expected = __DIR__ . self::PATH_TO_EXPECTED;
		$input    = __DIR__ . self::PATH_TO_EQUALS_CI;
		self::assertFileEqualsIgnoringCase( $expected, $input );
	}

	/**
	 * Verify availability of the assertFileNotEqualsCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testAssertFileNotEqualsCanonicalizing() {
		$expected = __DIR__ . self::PATH_TO_EXPECTED;
		$input    = __DIR__ . self::PATH_TO_NOT_EQUALS;
		static::assertFileNotEqualsCanonicalizing( $expected, $input );
	}

	/**
	 * Verify availability of the assertFileNotEqualsIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertFileNotEqualsIgnoringCase() {
		$expected = __DIR__ . self::PATH_TO_EXPECTED;
		$input    = __DIR__ . self::PATH_TO_NOT_EQUALS_CI;
		$this->assertFileNotEqualsIgnoringCase( $expected, $input );
	}

	/**
	 * Verify availability of the assertStringEqualsFileCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testAssertStringEqualsFileCanonicalizing() {
		static::assertStringEqualsFileCanonicalizing( __DIR__ . self::PATH_TO_EXPECTED, "testing 123\n" );
	}

	/**
	 * Verify availability of the assertStringEqualsFileIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertStringEqualsFileIgnoringCase() {
		self::assertStringEqualsFileIgnoringCase( __DIR__ . self::PATH_TO_EXPECTED, "Testing 123\n" );
	}

	/**
	 * Verify availability of the assertStringNotEqualsFileCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testAssertStringNotEqualsFileCanonicalizing() {
		$this->assertStringNotEqualsFileCanonicalizing( __DIR__ . self::PATH_TO_EXPECTED, "test 123\n" );
	}

	/**
	 * Verify availability of the assertStringNotEqualsFileIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertStringNotEqualsFileIgnoringCase() {
		$this->assertStringNotEqualsFileIgnoringCase( __DIR__ . self::PATH_TO_EXPECTED, "Test 123\n" );
	}
}
