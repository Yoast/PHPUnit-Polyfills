<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Version as PHPUnit_Version;
use stdClass;
use TypeError;
use Yoast\PHPUnitPolyfills\Polyfills\AssertArrayWithListKeys;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * Availability test for the functions polyfilled by the AssertArrayWithListKeys trait.
 *
 * @phpcs:disable WordPress.Arrays.ArrayDeclarationSpacing.AssociativeArrayFound -- For readability of the tests.
 */
abstract class AssertArrayWithListKeysTestCase extends TestCase {

	use AssertArrayWithListKeys;
	use ExpectExceptionMessageMatches;

	/**
	 * Verify that the methods throw an error when the $expected parameter is not an array.
	 *
	 * @dataProvider dataAllMethodsAllNonArrayTypes
	 *
	 * @param string $method Name of the assertion method to test.
	 * @param mixed  $input  Non-array value.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAllMethodsAllNonArrayTypes' )]
	public function testAssertionFailsOnInvalidInputTypeForExpected( $method, $input ) {
		$this->expectException( TypeError::class );

		if ( \PHP_VERSION_ID >= 80000 ) {
			$msg = '::' . $method . '(): Argument #1 ($expected) must be of type array, ';
			$this->expectExceptionMessage( $msg );
		}
		else {
			// PHP 7.
			$pattern = '`^Argument 1 passed to [^\s]*::' . $method . '\(\) must be of the type array, `';
			$this->expectExceptionMessageMatches( $pattern );
		}

		$this->$method( $input, [], [] );
	}

	/**
	 * Verify that the methods throw an error when the $actual parameter is not an array.
	 *
	 * @dataProvider dataAllMethodsAllNonArrayTypes
	 *
	 * @param string $method Name of the assertion method to test.
	 * @param mixed  $input  Non-array value.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAllMethodsAllNonArrayTypes' )]
	public function testAssertionFailsOnInvalidInputTypeForActual( $method, $input ) {
		$this->expectException( TypeError::class );

		if ( \PHP_VERSION_ID >= 80000 ) {
			$msg = '::' . $method . '(): Argument #2 ($actual) must be of type array, ';
			$this->expectExceptionMessage( $msg );
		}
		else {
			// PHP 7.
			$pattern = '`^Argument 2 passed to [^\s]*::' . $method . '\(\) must be of the type array, `';
			$this->expectExceptionMessageMatches( $pattern );
		}

		static::$method( [], $input, [] );
	}

	/**
	 * Verify that the methods throw an error when the $keysToBeConsidered/$keysToBeIgnored parameter is not an array.
	 *
	 * @dataProvider dataAllMethodsAllNonArrayTypes
	 *
	 * @param string $method Name of the assertion method to test.
	 * @param mixed  $input  Non-array value.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAllMethodsAllNonArrayTypes' )]
	public function testAssertionFailsOnInvalidInputTypeForKeys( $method, $input ) {
		$this->expectException( TypeError::class );

		if ( \PHP_VERSION_ID >= 80000 ) {
			$pattern = '`::' . $method . '\(\): Argument #3 \(\$keysToBe(Considered|Ignored)\) must be of type array, `';
		}
		else {
			// PHP 7.
			$pattern = '`^Argument 3 passed to [^\s]*::' . $method . '\(\) must be of the type array, `';
		}

		$this->expectExceptionMessageMatches( $pattern );

		self::$method( [], [], $input );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<mixed>>
	 */
	public static function dataAllMethodsAllNonArrayTypes() {
		// Only testing closed resource to not leak an open resource.
		$resource = \fopen( __DIR__ . '/Fixtures/test.txt', 'r' );
		\fclose( $resource );

		$types = [
			'null'            => null,
			'boolean'         => true,
			'integer'         => 10,
			'float'           => 5.34,
			'string'          => 'text',
			'object'          => new stdClass(),
			'closed resource' => $resource,
		];

		$data    = [];
		$methods = self::dataAllMethods();
		foreach ( $methods as $key => $unused ) {
			foreach ( $types as $name => $value ) {
				$data[ $key . ' with ' . $name ] = [
					$key,
					$value,
				];
			}
		}

		return $data;
	}

	/**
	 * Basic availability/functionality test for the assertArrayIsEqualToArrayOnlyConsideringListOfKeys() method.
	 *
	 * @return void
	 */
	public function testAssertArrayIsEqualToArrayOnlyConsideringListOfKeys() {
		$expected = [ 'a' => 'b', 'b' => 'c', 0 => 1, 1 => 2 ];
		$actual   = [ 'a' => 'b', 'b' => 'b', 0 => 1, 1 => 3 ];

		$this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 'a', 0 ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 'b' ] );
	}

	/**
	 * Basic availability/functionality test for the assertArrayIsEqualToArrayIgnoringListOfKeys() method.
	 *
	 * @return void
	 */
	public function testAssertArrayIsEqualToArrayIgnoringListOfKeys() {
		$expected = [ 'a' => 'b', 'b' => 'c', 0 => 1, 1 => 2 ];
		$actual   = [ 'a' => 'b', 'b' => 'b', 0 => 1, 1 => 3 ];

		$this->assertArrayIsEqualToArrayIgnoringListOfKeys( $expected, $actual, [ 'b', 1 ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsEqualToArrayIgnoringListOfKeys( $expected, $actual, [ 'b' ] );
	}

	/**
	 * Basic availability/functionality test for the assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys() method.
	 *
	 * @return void
	 */
	public function testAssertArrayIsIdenticalToArrayOnlyConsideringListOfKeys() {
		$expected = [ 'a' => 'b', 'b' => 'c', 0 => 1, 1 => 2 ];
		$actual   = [ 'a' => 'b', 'b' => 'b', 0 => 1, 1 => 3 ];

		$this->assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 'a', 0 ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 'b' ] );
	}

	/**
	 * Basic availability/functionality test for the assertArrayIsIdenticalToArrayIgnoringListOfKeys() method.
	 *
	 * @return void
	 */
	public function testAssertArrayIsIdenticalToArrayIgnoringListOfKeys() {
		$expected = [ 'a' => 'b', 'b' => 'c', 0 => 1, 1 => 2 ];
		$actual   = [ 'a' => 'b', 'b' => 'b', 0 => 1, 1 => 3 ];

		$this->assertArrayIsIdenticalToArrayIgnoringListOfKeys( $expected, $actual, [ 'b', 1 ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsIdenticalToArrayIgnoringListOfKeys( $expected, $actual, [ 'b' ] );
	}

	/**
	 * Verify that the assertArrayIsEqualToArrayOnlyConsideringListOfKeys() method handles the keys
	 * passed in $keysToBeConsidered the same way as PHP handles array keys.
	 *
	 * @link https://github.com/sebastianbergmann/phpunit/pull/5716
	 *
	 * @return void
	 */
	public function testAssertArrayIsEqualToArrayOnlyConsideringListOfKeysInterpretsKeysSameAsPHPBug5716() {
		if ( \version_compare( PHPUnit_Version::id(), '11.0.0', '>=' )
			&& \version_compare( PHPUnit_Version::id(), '11.0.4', '<' )
		) {
			// This bug was fixed in PHPUnit 11.0.4.
			$this->markTestSkipped( 'Skipping test on PHPUnit versions which contained bug #5716' );
		}

		// Effective keys: int 0, int 1, int 2, string '3.0'.
		$expected = [ 0 => 1, '1' => 2, 2.0 => 3, '3.0' => 4 ];
		$actual   = [ 0 => 1, '1' => 2, 2.0 => 2, '3.0' => 4 ];

		$this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 0, '1', '3.0' ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys( $expected, $actual, [ '1', 2.0, '3.0' ] );
	}

	/**
	 * Verify that the assertArrayIsEqualToArrayIgnoringListOfKeys() method handles the keys
	 * passed in $keysToBeIgnored the same way as PHP handles array keys.
	 *
	 * @return void
	 */
	public function testAssertArrayIsEqualToArrayIgnoringListOfKeysInterpretsKeysSameAsPHP() {
		// Effective keys: int 0, int 1, int 2, string '3.0'.
		$expected = [ 0 => 1, '1' => 2, 2.0 => 3, '3.0' => 4 ];
		$actual   = [ 0 => 1, '1' => 2, 2.0 => 2, '3.0' => 4 ];

		$this->assertArrayIsEqualToArrayIgnoringListOfKeys( $expected, $actual, [ 2.0 ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsEqualToArrayIgnoringListOfKeys( $expected, $actual, [ '1' ] );
	}

	/**
	 * Verify that the assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys() method handles the keys
	 * passed in $keysToBeConsidered the same way as PHP handles array keys.
	 *
	 * @link https://github.com/sebastianbergmann/phpunit/pull/5716
	 *
	 * @return void
	 */
	public function testAssertArrayIsIdenticalToArrayOnlyConsideringListOfKeysInterpretsKeysSameAsPHPBug5716() {
		if ( \version_compare( PHPUnit_Version::id(), '11.0.0', '>=' )
			&& \version_compare( PHPUnit_Version::id(), '11.0.4', '<' )
		) {
			// This bug was fixed in PHPUnit 11.0.4.
			$this->markTestSkipped( 'Skipping test on PHPUnit versions which contained bug #5716' );
		}
		// Effective keys: int 0, int 1, int 2, string '3.0'.
		$expected = [ 0 => 1, '1' => 2, 2.0 => 3, '3.0' => 4 ];
		$actual   = [ 0 => 1, '1' => 2, 2.0 => 2, '3.0' => 4 ];

		$this->assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 0, '1', '3.0' ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys( $expected, $actual, [ '1', 2.0, '3.0' ] );
	}

	/**
	 * Verify that the assertArrayIsIdenticalToArrayIgnoringListOfKeys() method handles the keys
	 * passed in $keysToBeIgnored the same way as PHP handles array keys.
	 *
	 * @return void
	 */
	public function testAssertArrayIsIdenticalToArrayIgnoringListOfKeysInterpretsKeysSameAsPHP() {
		// Effective keys: int 0, int 1, int 2, string '3.0'.
		$expected = [ 0 => 1, '1' => 2, 2.0 => 3, '3.0' => 4 ];
		$actual   = [ 0 => 1, '1' => 2, 2.0 => 2, '3.0' => 4 ];

		$this->assertArrayIsIdenticalToArrayIgnoringListOfKeys( $expected, $actual, [ 2.0 ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsIdenticalToArrayIgnoringListOfKeys( $expected, $actual, [ '1' ] );
	}

	/**
	 * Verify the assertArrayIsEqualToArrayOnlyConsideringListOfKeys() method compares empty arrays as equal.
	 *
	 * @return void
	 */
	public function testAssertArrayIsEqualToArrayOnlyConsideringListOfKeysWhenActualIsEmptyArray() {
		$expected = [ 'a' => 'b', 1 => 2 ];
		$actual   = [];

		$this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 'b', 0 ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 'a' ] );
	}

	/**
	 * Verify the assertArrayIsEqualToArrayIgnoringListOfKeys() method compares empty arrays as equal.
	 *
	 * @return void
	 */
	public function testAssertArrayIsEqualToArrayIgnoringListOfKeysWhenActualIsEmptyArray() {
		$expected = [ 'a' => 'b', 1 => 2 ];
		$actual   = [];

		$this->assertArrayIsEqualToArrayIgnoringListOfKeys( $expected, $actual, [ 'a', 1 ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsEqualToArrayIgnoringListOfKeys( $expected, $actual, [ 'b' ] );
	}

	/**
	 * Verify the assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys() method compares empty arrays as equal.
	 *
	 * @return void
	 */
	public function testAssertArrayIsIdenticalToArrayOnlyConsideringListOfKeysWhenExpectedIsEmptyArray() {
		$expected = [];
		$actual   = [ 'a' => 'b', 1 => 2 ];

		$this->assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 'b', 0 ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 1 ] );
	}

	/**
	 * Verify the assertArrayIsIdenticalToArrayIgnoringListOfKeys() method compares empty arrays as equal.
	 *
	 * @return void
	 */
	public function testAssertArrayIsIdenticalToArrayIgnoringListOfKeysWhenExpectedIsEmptyArray() {
		$expected = [];
		$actual   = [ 'a' => 'b', 1 => 2 ];

		$this->assertArrayIsIdenticalToArrayIgnoringListOfKeys( $expected, $actual, [ 'a', 1 ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsIdenticalToArrayIgnoringListOfKeys( $expected, $actual, [ '0' ] );
	}

	/**
	 * Verify the assertArrayIsEqualToArrayOnlyConsideringListOfKeys() method compares empty arrays as equal.
	 *
	 * @return void
	 */
	public function testAssertArrayIsEqualToArrayOnlyConsideringListOfKeysWhenListIsEmptyArray() {
		$expected = [ 'a' => 'b', 1 => 2 ];
		$actual   = [ 'a' => 'b', 1 => 2 ];

		$this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys( $expected, $actual, [] );
	}

	/**
	 * Verify the assertArrayIsEqualToArrayIgnoringListOfKeys() method compares empty arrays as equal.
	 *
	 * @return void
	 */
	public function testAssertArrayIsEqualToArrayIgnoringListOfKeysWhenListIsEmptyArray() {
		$expected = [ 'a' => 'b', 1 => 2 ];
		$actual   = [ 'a' => 'b', 1 => 2 ];

		$this->assertArrayIsEqualToArrayIgnoringListOfKeys( $expected, $actual, [] );
	}

	/**
	 * Verify the assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys() method compares empty arrays as equal.
	 *
	 * @return void
	 */
	public function testAssertArrayIsIdenticalToArrayOnlyConsideringListOfKeysWhenListIsEmptyArray() {
		$expected = [ 'a' => 'b', 1 => 2 ];
		$actual   = [ 'a' => 'b', 1 => 2 ];

		$this->assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys( $expected, $actual, [] );
	}

	/**
	 * Verify the assertArrayIsIdenticalToArrayIgnoringListOfKeys() method compares empty arrays as equal.
	 *
	 * @return void
	 */
	public function testAssertArrayIsIdenticalToArrayIgnoringListOfKeysWhenListIsEmptyArray() {
		$expected = [ 'a' => 'b', 1 => 2 ];
		$actual   = [ 'a' => 'b', 1 => 2 ];

		$this->assertArrayIsIdenticalToArrayIgnoringListOfKeys( $expected, $actual, [] );
	}

	/**
	 * Verify handling when arrays are equal, but not identical.
	 *
	 * @link https://github.com/sebastianbergmann/phpunit/pull/5729
	 *
	 * @return void
	 */
	public function testAssertArrayIsEqualButNotIdenticalToArrayOnlyConsideringListOfKeys() {
		$expected = [ 'a' => 'b', 'b' => 'c', 0 => 1, 1 => 2 ];
		$actual   = [ 0 => 1, 1 => 3, 'a' => 'b', 'b' => 'b' ];

		$this->assertArrayIsEqualToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 'a', 0 ] );

		if ( \version_compare( PHPUnit_Version::id(), '11.0.4', '>=' )
			&& \version_compare( PHPUnit_Version::id(), '11.0.6', '<' )
		) {
			// This bug only exists in PHPUnit 11.0.4 and 11.0.5.
			$this->markTestSkipped( 'Skipping test on PHPUnit versions which contained bug #5729' );
		}

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys( $expected, $actual, [ 'a', 0 ] );
	}

	/**
	 * Verify handling when arrays are equal, but not identical.
	 *
	 * @return void
	 */
	public function testAssertArrayIsEqualButNotIdenticalToArrayIgnoringListOfKeys() {
		$expected = [ 'a' => 'b', 'b' => 'c', 0 => 1, 1 => 2 ];
		$actual   = [ 0 => 1, 1 => 3, 'a' => 'b', 'b' => 'b' ];

		$this->assertArrayIsEqualToArrayIgnoringListOfKeys( $expected, $actual, [ 'b', '1' ] );

		$this->expectException( AssertionFailedError::class );

		$this->assertArrayIsIdenticalToArrayIgnoringListOfKeys( $expected, $actual, [ 'b', '1' ] );
	}

	/**
	 * Verify that the methods fail a test with a custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @dataProvider dataAllMethods
	 *
	 * @param string $method Name of the assertion method to test.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAllMethods' )]
	public function testAssertionFailsWithCustomMessage( $method ) {
		$pattern = '`^This assertion failed for reason XYZ\s+(?:Failed asserting that two arrays are (?:equal|identical)\.|Failed asserting that Array &0)`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->$method( [ 'key' => 10 ], [ 1, 2, 3 ], [ 'key' ], 'This assertion failed for reason XYZ' );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string>>
	 */
	public static function dataAllMethods() {
		$methods = [
			'assertArrayIsEqualToArrayOnlyConsideringListOfKeys',
			'assertArrayIsEqualToArrayIgnoringListOfKeys',
			'assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys',
			'assertArrayIsIdenticalToArrayIgnoringListOfKeys',
		];

		$data = [];
		foreach ( $methods as $method ) {
			$data[ $method ] = [ $method ];
		}

		return $data;
	}
}
