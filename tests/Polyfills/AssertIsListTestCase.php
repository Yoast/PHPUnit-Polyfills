<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use stdClass;
use Yoast\PHPUnitPolyfills\Autoload;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsList;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * Availability test for the functions polyfilled by the AssertIsList trait.
 */
abstract class AssertIsListTestCase extends TestCase {

	use AssertIsList;
	use ExpectExceptionMessageMatches;

	/**
	 * Verify that the assertIsList() method throws an error when the $array parameter is not an array.
	 *
	 * @dataProvider dataAssertIsListFailsOnInvalidInputType
	 *
	 * @param mixed  $actual The value to test.
	 * @param string $type   The type expected in the failure message.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAssertIsListFailsOnInvalidInputType' )]
	public function testAssertIsListFailsOnInvalidInputType( $actual, $type ) {
		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( '`^Failed asserting that ' . $type . ' is a list`' );

		$this->assertIsList( $actual );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public static function dataAssertIsListFailsOnInvalidInputType() {
		// Only testing closed resource to not leak an open resource.
		$resource = \fopen( __DIR__ . '/Fixtures/test.txt', 'r' );
		\fclose( $resource );

		// The error message for objects was improved in PHPUnit 11.3.1 and this improvement
		// is emulated in the polyfill for PHPUnit < 10.
		$improved_error_message = false;
		if ( \version_compare( Autoload::getPHPUnitVersion(), '10.0.0', '<' )
			|| \version_compare( Autoload::getPHPUnitVersion(), '11.3.1', '>=' )
		) {
			$improved_error_message = true;
		}

		return [
			'null' => [
				'actual' => null,
				'type'   => '(a )?null',
			],
			'boolean' => [
				'actual' => true,
				'type'   => 'a boolean',
			],
			'integer' => [
				'actual' => 10,
				'type'   => 'an integer',
			],
			'float' => [
				'actual' => 5.34,
				'type'   => 'a float',
			],
			'string' => [
				'actual' => 'text',
				'type'   => 'a string',
			],
			'named object' => [
				'actual' => new stdClass(),
				'type'   => ( $improved_error_message === true ) ? 'an instance of class stdClass' : 'an object',
			],
			'anonymous object' => [
				'actual' => new class() {},
				'type'   => ( $improved_error_message === true ) ? 'an instance of anonymous class created at \S+' : 'an object',
			],
			'closed resource' => [
				'actual' => $resource,
				'type'   => ( \PHP_VERSION_ID > 70200 ) ? 'a (value of )?closed resource' : 'a value of unknown type',
			],
		];
	}

	/**
	 * Verify availability and functionality of the assertIsList() method.
	 *
	 * @dataProvider dataAssertIsListPass
	 *
	 * @param array<mixed> $actual The value to test.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAssertIsListPass' )]
	public function testAssertIsListPass( $actual ) {
		$this->assertIsList( $actual );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<array<mixed>>>
	 */
	public static function dataAssertIsListPass() {
		return [
			'empty array'                            => [ [] ],
			'array without keys (integer values)'    => [ [ 0, 1, 2 ] ],
			'array without keys (mixed values)'      => [ [ 'string', 1.5, new stdClass(), [], null ] ],
			'array with consecutive numeric keys (ascending)' => [
				[
					0 => 0,
					1 => 1,
					2 => 2,
				],
			],
			'array with partial keys, starting at 0' => [
				[
					0 => 'apple',
					'orange',
				],
			],
		];
	}

	/**
	 * Verify that the assertIsList() method throws an error when the passed $array is not a list.
	 *
	 * @dataProvider dataAssertIsListFail
	 *
	 * @param array<int|string, int|string> $actual The value to test.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAssertIsListFail' )]
	public function testAssertIsListFail( $actual ) {
		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessage( 'Failed asserting that an array is a list' );

		static::assertIsList( $actual );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<array<int|string, int|string>>>
	 */
	public static function dataAssertIsListFail() {
		return [
			'array with non-consecutive numeric keys' => [
				[
					0 => 0,
					2 => 2,
					3 => 3,
				],
			],
			'array with consecutive numeric keys not starting at 0' => [
				[
					3 => 0,
					4 => 1,
					5 => 2,
				],
			],
			'array with consecutive numeric keys (descending)' => [
				[
					0  => 0,
					-1 => 1,
					-2 => 2,
				],
			],
			'array with string keys' => [
				[
					'a' => 0,
					'b' => 1,
				],
			],
			'array with partial string keys' => [
				[
					'a' => 'apple',
					'orange',
				],
			],
		];
	}

	/**
	 * Verify that the assertIsList() method fails a test with a custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testAssertIsListFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that an array is a list\.`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$array = [
			0 => 0,
			2 => 2,
		];

		$this->assertIsList( $array, 'This assertion failed for reason XYZ' );
	}
}
