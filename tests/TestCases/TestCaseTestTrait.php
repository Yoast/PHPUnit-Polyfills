<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestCases;

use Exception;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertFileEqualsSpecializationsTest;

/**
 * Tests for the TestCase setups.
 */
trait TestCaseTestTrait {

	/**
	 * Data provider for the testHaveFixtureMethodsBeenTriggered() test.
	 *
	 * @return array[]
	 */
	public function dataHaveFixtureMethodsBeenTriggered() {
		return [
			[ 1, 1, 0, 1, 0 ],
			[ 1, 2, 1, 2, 1 ],
			[ 1, 3, 2, 3, 2 ],
		];
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [1].
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testAvailabilityExpectExceptionObjectTrait() {
		$exception = new Exception( 'message', 101 );
		$this->expectExceptionObject( $exception );

		throw new Exception( 'message', 101 );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [2].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertIsTypeTrait() {
		self::assertIsInt( self::$beforeClass );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [3].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertStringContainsTrait() {
		$this->assertStringContainsString( 'foo', 'foobar' );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [4].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertEqualsSpecializationsTrait() {
		static::assertEqualsIgnoringCase( 'a', 'A' );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [5].
	 *
	 * @return void
	 */
	public function testAvailabilityExpectPHPExceptionTrait() {
		$this->expectDeprecation();

		\trigger_error( 'foo', \E_USER_DEPRECATED );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [6].
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testAvailabilityExpectExceptionMessageMatchesTrait() {
		$this->expectException( Exception::class );
		$this->expectExceptionMessageMatches( '`^a poly[a-z]+ [a-zA-Z0-9_]+ me(s){2}age$`i' );

		throw new Exception( 'A polymorphic exception message' );
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [7].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertFileEqualsSpecializationsTrait() {
		self::assertStringEqualsFileIgnoringCase(
			\dirname( __DIR__ ) . '/Polyfills' . AssertFileEqualsSpecializationsTest::PATH_TO_EXPECTED,
			"Testing 123\n"
		);
	}

	/**
	 * Test availability of trait polyfilled PHPUnit methods [8].
	 *
	 * @return void
	 */
	public function testAvailabilityAssertionRenamesTrait() {
		$this->assertMatchesRegularExpression( '/foo/', 'foobar' );
	}
}
