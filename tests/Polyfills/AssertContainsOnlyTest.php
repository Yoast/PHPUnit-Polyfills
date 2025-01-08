<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use DateTime;
use EmptyIterator;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Attributes\AfterClass;
use PHPUnit\Framework\Attributes\BeforeClass;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yoast\PHPUnitPolyfills\Polyfills\AssertContainsOnly;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * Tests for the functions polyfilled by the AssertContainsOnly trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertContainsOnly
 */
#[CoversClass( AssertContainsOnly::class )]
final class AssertContainsOnlyTest extends TestCase {

	use AssertContainsOnly;
	use ExpectExceptionMessageMatches;

	/**
	 * Resource for use in the tests.
	 *
	 * @var resource
	 */
	private static $openResource;

	/**
	 * Closed resource for use in the tests.
	 *
	 * @var resource
	 */
	private static $closedResource;

	/**
	 * Create some resources for use in the tests.
	 *
	 * @beforeClass
	 *
	 * @return void
	 */
	#[BeforeClass]
	public static function prepareResource() {
		self::$openResource = \opendir( __DIR__ );

		self::$closedResource = \opendir( __DIR__ );
		\closedir( self::$closedResource );
	}

	/**
	 * Clean up the previously created and still open resource.
	 *
	 * @afterClass
	 *
	 * @return void
	 */
	#[AfterClass]
	public static function closeResource() {
		\closedir( self::$openResource );
	}

	/**
	 * Data provider.
	 *
	 * @return array<mixed>
	 */
	public static function dataMixedValues() {
		return [
			'Array with a mix of values' => [
				[
					null,
					false,
					10,
					4.34,
					'string',
					'is_callable',
					[ 'not', 'empty' ],
					new stdClass(),
				],
			],
		];
	}

	/**
	 * Verify the assertContainsNotOnlyInstancesOf() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyInstancesOfSucceeds( $haystack ) {
		$this->assertContainsNotOnlyInstancesOf( stdClass::class, $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyInstancesOf() method fails on invalid input.
	 *
	 * @return void
	 */
	public function testAssertContainsNotOnlyInstancesOfFails() {
		$pattern = '`(\]|\)) does not contain only values of type "stdClass"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$haystack = [
			new stdClass( 1, 2, 3 ),
			new stdClass(),
			new stdClass( 'foo' ),
		];

		self::assertContainsNotOnlyInstancesOf( stdClass::class, $haystack );
	}

	/**
	 * Verify the assertContainsOnlyArray() method succeeds for valid input.
	 *
	 * @dataProvider dataOnlyArray
	 *
	 * @param array<int|string> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyArray' )]
	public function testAssertContainsOnlyArraySucceeds( $haystack ) {
		self::assertContainsOnlyArray( $haystack );
	}

	/**
	 * Verify the assertContainsOnlyArray() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyArrayFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "array"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		static::assertContainsOnlyArray( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyArray() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyArraySucceeds( $haystack ) {
		static::assertContainsNotOnlyArray( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyArray() method fails on invalid input.
	 *
	 * @dataProvider dataOnlyArray
	 *
	 * @param array<int|string> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyArray' )]
	public function testAssertContainsNotOnlyArrayFails( $haystack ) {
		$pattern = '`(\]|\)) does not contain only values of type "array"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsNotOnlyArray( $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<array<int|string>>
	 */
	public static function dataOnlyArray() {
		return [
			'Array containing only arrays' => [
				[
					[],
					[ 1, 2, 3 ],
					[ 'foo' => 'bar' ],
				],
			],
		];
	}

	/**
	 * Verify the assertContainsOnlyBool() method succeeds for valid input.
	 *
	 * @dataProvider dataOnlyBool
	 *
	 * @param array<bool> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyBool' )]
	public function testAssertContainsOnlyBoolSucceeds( $haystack ) {
		$this->assertContainsOnlyBool( $haystack );
	}

	/**
	 * Verify the assertContainsOnlyBool() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyBoolFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "bool"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsOnlyBool( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyBool() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyBoolSucceeds( $haystack ) {
		$this->assertContainsNotOnlyBool( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyBool() method fails on invalid input.
	 *
	 * @dataProvider dataOnlyBool
	 *
	 * @param array<bool> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyBool' )]
	public function testAssertContainsNotOnlyBoolFails( $haystack ) {
		$pattern = '`(\]|\)) does not contain only values of type "bool"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		static::assertContainsNotOnlyBool( $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<array<bool>>
	 */
	public static function dataOnlyBool() {
		return [
			'Array containing only booleans' => [
				[
					0     => false,
					1     => true,
					'foo' => true,
				],
			],
		];
	}

	/**
	 * Verify the assertContainsOnlyCallable() method succeeds for valid input.
	 *
	 * @dataProvider dataOnlyCallable
	 *
	 * @param array<callable> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyCallable' )]
	public function testAssertContainsOnlyCallableSucceeds( $haystack ) {
		$this->assertContainsOnlyCallable( $haystack );
	}

	/**
	 * Verify the assertContainsOnlyCallable() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyCallableFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "callable"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsOnlyCallable( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyCallable() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyCallableSucceeds( $haystack ) {
		$this->assertContainsNotOnlyCallable( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyCallable() method fails on invalid input.
	 *
	 * @dataProvider dataOnlyCallable
	 *
	 * @param array<callable> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyCallable' )]
	public function testAssertContainsNotOnlyCallableFails( $haystack ) {
		$pattern = '`(\]|\)) does not contain only values of type "callable"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsNotOnlyCallable( $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<array<callable>>
	 */
	public static function dataOnlyCallable() {
		return [
			'Array containing only callables' => [
				[
					'is_string',
					[ self::class, 'dummyCallable' ],
				],
			],
		];
	}

	/**
	 * Dummy method to have a callable method available.
	 *
	 * @return void
	 */
	public static function dummyCallable() {
		// Nothing to see here.
	}

	/**
	 * Verify the assertContainsOnlyFloat() method succeeds for valid input.
	 *
	 * @dataProvider dataOnlyFloat
	 *
	 * @param array<float> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyFloat' )]
	public function testAssertContainsOnlyFloatSucceeds( $haystack ) {
		self::assertContainsOnlyFloat( $haystack );
	}

	/**
	 * Verify the assertContainsOnlyFloat() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyFloatFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "float"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsOnlyFloat( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyFloat() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyFloatSucceeds( $haystack ) {
		$this->assertContainsNotOnlyFloat( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyFloat() method fails on invalid input.
	 *
	 * @dataProvider dataOnlyFloat
	 *
	 * @param array<float> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyFloat' )]
	public function testAssertContainsNotOnlyFloatFails( $haystack ) {
		$pattern = '`(\]|\)) does not contain only values of type "float"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsNotOnlyFloat( $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<array<float>>
	 */
	public static function dataOnlyFloat() {
		return [
			'Array containing only floats' => [
				[
					0.0,
					3.5,
					-0.5645,
					8E7,
				],
			],
		];
	}

	/**
	 * Verify the assertContainsOnlyInt() method succeeds for valid input.
	 *
	 * @dataProvider dataOnlyInt
	 *
	 * @param array<int> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyInt' )]
	public function testAssertContainsOnlyIntSucceeds( $haystack ) {
		$this->assertContainsOnlyInt( $haystack );
	}

	/**
	 * Verify the assertContainsOnlyInt() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyIntFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "int"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsOnlyInt( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyInt() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyIntSucceeds( $haystack ) {
		$this->assertContainsNotOnlyInt( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyInt() method fails on invalid input.
	 *
	 * @dataProvider dataOnlyInt
	 *
	 * @param array<int> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyInt' )]
	public function testAssertContainsNotOnlyIntFails( $haystack ) {
		$pattern = '`(\]|\)) does not contain only values of type "int"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertContainsNotOnlyInt( $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<array<int>>
	 */
	public static function dataOnlyInt() {
		return [
			'Array containing only integers' => [
				[
					0,
					10,
					-2,
					0b010100,
					0x7AB,
					\PHP_INT_MAX,
				],
			],
		];
	}

	/**
	 * Verify the assertContainsOnlyIterable() method succeeds for valid input.
	 *
	 * @dataProvider dataOnlyIterable
	 *
	 * @param array<iterable<mixed>> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyIterable' )]
	public function testAssertContainsOnlyIterableSucceeds( $haystack ) {
		$this->assertContainsOnlyIterable( $haystack );
	}

	/**
	 * Verify the assertContainsOnlyIterable() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyIterableFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "iterable"\.`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertContainsOnlyIterable( $haystack );
	}

	/**
	 * Verify that the assertContainsOnlyIterable() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyIterableFailsWithCustomMessage( $haystack ) {
		$pattern = '`^This assertion failed for reason XYZ\R`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertContainsOnlyIterable( $haystack, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify the assertContainsNotOnlyIterable() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyIterableSucceeds( $haystack ) {
		$this->assertContainsNotOnlyIterable( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyIterable() method fails on invalid input.
	 *
	 * @dataProvider dataOnlyIterable
	 *
	 * @param array<iterable<mixed>> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyIterable' )]
	public function testAssertContainsNotOnlyIterableFails( $haystack ) {
		$pattern = '`(\]|\)) does not contain only values of type "iterable"\.`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		static::assertContainsNotOnlyIterable( $haystack );
	}

	/**
	 * Verify that the assertContainsNotOnlyIterable() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @dataProvider dataOnlyIterable
	 *
	 * @param array<iterable<mixed>> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyIterable' )]
	public function testAssertContainsNotOnlyIterableFailsWithCustomMessage( $haystack ) {
		$pattern = '`^This assertion failed for reason XYZ\R`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsNotOnlyIterable( $haystack, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Data provider.
	 *
	 * @return array<array<iterable<mixed>>>
	 */
	public static function dataOnlyIterable() {
		return [
			'Array containing only iterables' => [
				[
					[],
					[ 1, 2, 3 ],
					[ 'foo' => 'bar' ],
					new EmptyIterator(),
				],
			],
		];
	}

	/**
	 * Verify the assertContainsOnlyNull() method succeeds for valid input.
	 *
	 * @dataProvider dataOnlyNull
	 *
	 * @param array<null> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyNull' )]
	public function testAssertContainsOnlyNullSucceeds( $haystack ) {
		self::assertContainsOnlyNull( $haystack );
	}

	/**
	 * Verify the assertContainsOnlyNull() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyNullFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "null"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsOnlyNull( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyNull() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyNullSucceeds( $haystack ) {
		$this->assertContainsNotOnlyNull( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyNull() method fails on invalid input.
	 *
	 * @dataProvider dataOnlyNull
	 *
	 * @param array<null> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyNull' )]
	public function testAssertContainsNotOnlyNullFails( $haystack ) {
		$pattern = '`(\]|\)) does not contain only values of type "null"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsNotOnlyNull( $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<array<null>>
	 */
	public static function dataOnlyNull() {
		return [
			'Array containing only nulls' => [
				[
					null,
					null,
				],
			],
		];
	}

	/**
	 * Verify the assertContainsOnlyNumeric() method succeeds for valid input.
	 *
	 * @dataProvider dataOnlyNumeric
	 *
	 * @param array<int|float|string> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyNumeric' )]
	public function testAssertContainsOnlyNumericSucceeds( $haystack ) {
		self::assertContainsOnlyNumeric( $haystack );
	}

	/**
	 * Verify the assertContainsOnlyNumeric() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyNumericFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "numeric"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		static::assertContainsOnlyNumeric( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyNumeric() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyNumericSucceeds( $haystack ) {
		$this->assertContainsNotOnlyNumeric( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyNumeric() method fails on invalid input.
	 *
	 * @dataProvider dataOnlyNumeric
	 *
	 * @param array<int|float|string> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyNumeric' )]
	public function testAssertContainsNotOnlyNumericFails( $haystack ) {
		$pattern = '`(\]|\)) does not contain only values of type "numeric"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsNotOnlyNumeric( $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<array<int|float|string>>
	 */
	public static function dataOnlyNumeric() {
		return [
			'Array containing only numerics' => [
				[
					'0',
					'12344',
					0,
					1235,
					0.0,
					-12.4,
				],
			],
		];
	}

	/**
	 * Verify the assertContainsOnlyObject() method succeeds for valid input.
	 *
	 * @dataProvider dataOnlyObject
	 *
	 * @param array<object> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyObject' )]
	public function testAssertContainsOnlyObjectSucceeds( $haystack ) {
		$this->assertContainsOnlyObject( $haystack );
	}

	/**
	 * Verify the assertContainsOnlyObject() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyObjectFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "object"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsOnlyObject( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyObject() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyObjectSucceeds( $haystack ) {
		$this->assertContainsNotOnlyObject( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyObject() method fails on invalid input.
	 *
	 * @dataProvider dataOnlyObject
	 *
	 * @param array<object> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyObject' )]
	public function testAssertContainsNotOnlyObjectFails( $haystack ) {
		$pattern = '`(\]|\)) does not contain only values of type "object"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsNotOnlyObject( $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<array<object>>
	 */
	public static function dataOnlyObject() {
		return [
			'Array containing only objects' => [
				[
					new stdClass(),
					new EmptyIterator(),
					new DateTime(),
				],
			],
		];
	}

	/**
	 * Verify the assertContainsOnlyResource() method succeeds for valid input.
	 *
	 * @return void
	 */
	public function testAssertContainsOnlyResourceSucceeds() {
		$this->assertContainsOnlyResource( [ self::$openResource, self::$closedResource ] );
	}

	/**
	 * Verify the assertContainsOnlyResource() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyResourceFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "resource"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsOnlyResource( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyResource() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyResourceSucceeds( $haystack ) {
		static::assertContainsNotOnlyResource( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyResource() method fails on invalid input.
	 *
	 * @return void
	 */
	public function testAssertContainsNotOnlyResourceFails() {
		$pattern = '`(\]|\)) does not contain only values of type "resource"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertContainsNotOnlyResource( [ self::$openResource, self::$closedResource ] );
	}

	/**
	 * Verify the assertContainsOnlyClosedResource() method succeeds for valid input.
	 *
	 * @return void
	 */
	public function testAssertContainsOnlyClosedResourceSucceeds() {
		$this->assertContainsOnlyClosedResource( [ self::$closedResource ] );
	}

	/**
	 * Verify the assertContainsOnlyClosedResource() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyClosedResourceFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "resource \(closed\)"\.`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsOnlyClosedResource( $haystack );
	}

	/**
	 * Verify that the assertContainsOnlyClosedResource() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyClosedResourceFailsWithCustomMessage( $haystack ) {
		$pattern = '`^This assertion failed for reason XYZ\R`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertContainsOnlyClosedResource( $haystack, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify the assertContainsNotOnlyClosedResource() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyClosedResourceSucceeds( $haystack ) {
		self::assertContainsNotOnlyClosedResource( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyClosedResource() method fails on invalid input.
	 *
	 * @return void
	 */
	public function testAssertContainsNotOnlyClosedResourceFails() {
		$pattern = '`(\]|\)) does not contain only values of type "resource \(closed\)"\.`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsNotOnlyClosedResource( [ self::$closedResource ] );
	}

	/**
	 * Verify that the assertContainsNotOnlyClosedResource() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testAssertContainsNotOnlyClosedResourceFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\R`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsNotOnlyClosedResource( [ self::$closedResource ], 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify the assertContainsOnlyScalar() method succeeds for valid input.
	 *
	 * @dataProvider dataOnlyScalar
	 *
	 * @param array<scalar> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyScalar' )]
	public function testAssertContainsOnlyScalarSucceeds( $haystack ) {
		self::assertContainsOnlyScalar( $haystack );
	}

	/**
	 * Verify the assertContainsOnlyScalar() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyScalarFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "scalar"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertContainsOnlyScalar( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyScalar() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyScalarSucceeds( $haystack ) {
		static::assertContainsNotOnlyScalar( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyScalar() method fails on invalid input.
	 *
	 * @dataProvider dataOnlyScalar
	 *
	 * @param array<scalar> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyScalar' )]
	public function testAssertContainsNotOnlyScalarFails( $haystack ) {
		$pattern = '`(\]|\)) does not contain only values of type "scalar"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertContainsNotOnlyScalar( $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<array<scalar>>
	 */
	public static function dataOnlyScalar() {
		return [
			'Array containing only scalars' => [
				[
					'string',
					true,
					10,
					-1.3,
					'',
					0,
				],
			],
		];
	}

	/**
	 * Verify the assertContainsOnlyString() method succeeds for valid input.
	 *
	 * @dataProvider dataOnlyString
	 *
	 * @param array<string> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyString' )]
	public function testAssertContainsOnlyStringSucceeds( $haystack ) {
		static::assertContainsOnlyString( $haystack );
	}

	/**
	 * Verify the assertContainsOnlyString() method fails on invalid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsOnlyStringFails( $haystack ) {
		$pattern = '`(\]|\)) contains only values of type "string"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertContainsOnlyString( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyString() method succeeds for valid input.
	 *
	 * @dataProvider dataMixedValues
	 *
	 * @param array<mixed> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataMixedValues' )]
	public function testAssertContainsNotOnlyStringSucceeds( $haystack ) {
		$this->assertContainsNotOnlyString( $haystack );
	}

	/**
	 * Verify the assertContainsNotOnlyString() method fails on invalid input.
	 *
	 * @dataProvider dataOnlyString
	 *
	 * @param array<string> $haystack Haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataOnlyString' )]
	public function testAssertContainsNotOnlyStringFails( $haystack ) {
		$pattern = '`(\]|\)) does not contain only values of type "string"\.$`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertContainsNotOnlyString( $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<array<string>>
	 */
	public static function dataOnlyString() {
		return [
			'Array containing only strings' => [
				[
					'',
					'foo',
					'bar',
					'baz',
				],
			],
		];
	}
}
