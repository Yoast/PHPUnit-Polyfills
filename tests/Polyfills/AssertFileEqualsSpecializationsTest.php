<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertFileEqualsSpecializations;

/**
 * Availability test for the functions polyfilled by the AssertFileEqualsSpecializations trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertFileEqualsSpecializations
 */
#[CoversClass( AssertFileEqualsSpecializations::class )]
final class AssertFileEqualsSpecializationsTest extends TestCase {

	use AssertFileEqualsSpecializations;

	public const PATH_TO_EXPECTED = __DIR__ . '/Fixtures/AssertFileEqualsSpecialization_Expected.txt';

	private const PATH_TO_EQUALS = __DIR__ . '/Fixtures/AssertFileEqualsSpecialization_Equals.txt';

	private const PATH_TO_NOT_EQUALS = __DIR__ . '/Fixtures/AssertFileEqualsSpecialization_NotEquals.txt';

	private const PATH_TO_EQUALS_CI = __DIR__ . '/Fixtures/AssertFileEqualsSpecialization_EqualsCI.txt';

	private const PATH_TO_NOT_EQUALS_CI = __DIR__ . '/Fixtures/AssertFileEqualsSpecialization_NotEqualsCI.txt';

	/**
	 * Verify availability of the assertFileEqualsCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testAssertFileEqualsCanonicalizing() {
		$this->assertFileEqualsCanonicalizing( self::PATH_TO_EXPECTED, self::PATH_TO_EQUALS );
	}

	/**
	 * Verify availability of the assertFileEqualsIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertFileEqualsIgnoringCase() {
		self::assertFileEqualsIgnoringCase( self::PATH_TO_EXPECTED, self::PATH_TO_EQUALS_CI );
	}

	/**
	 * Verify availability of the assertFileNotEqualsCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testAssertFileNotEqualsCanonicalizing() {
		static::assertFileNotEqualsCanonicalizing( self::PATH_TO_EXPECTED, self::PATH_TO_NOT_EQUALS );
	}

	/**
	 * Verify availability of the assertFileNotEqualsIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertFileNotEqualsIgnoringCase() {
		$this->assertFileNotEqualsIgnoringCase( self::PATH_TO_EXPECTED, self::PATH_TO_NOT_EQUALS_CI );
	}

	/**
	 * Verify availability of the assertStringEqualsFileCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testAssertStringEqualsFileCanonicalizing() {
		static::assertStringEqualsFileCanonicalizing( self::PATH_TO_EXPECTED, "testing 123\n" );
	}

	/**
	 * Verify availability of the assertStringEqualsFileIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertStringEqualsFileIgnoringCase() {
		self::assertStringEqualsFileIgnoringCase( self::PATH_TO_EXPECTED, "Testing 123\n" );
	}

	/**
	 * Verify availability of the assertStringNotEqualsFileCanonicalizing() method.
	 *
	 * @return void
	 */
	public function testAssertStringNotEqualsFileCanonicalizing() {
		$this->assertStringNotEqualsFileCanonicalizing( self::PATH_TO_EXPECTED, "test 123\n" );
	}

	/**
	 * Verify availability of the assertStringNotEqualsFileIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertStringNotEqualsFileIgnoringCase() {
		$this->assertStringNotEqualsFileIgnoringCase( self::PATH_TO_EXPECTED, "Test 123\n" );
	}
}
