<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_AssertionFailedError;
use stdClass;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsList;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * Availability test for the functions polyfilled by the AssertIsList trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertIsList
 */
class AssertIsListTest extends TestCase {

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
	public function testAssertIsListFailsOnInvalidInputType( $actual, $type ) {
		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( '`^Failed asserting that ' . $type . ' is a list`' );

		$this->assertIsList( $actual );
	}

	/**
	 * Data provider.
	 *
	 * @return array
	 */
	public static function dataAssertIsListFailsOnInvalidInputType() {
		// Only testing closed resource to not leak an open resource.
		$resource = \fopen( __DIR__ . '/Fixtures/test.txt', 'r' );
		\fclose( $resource );

		return [
			'null' => [
				'actual' => null,
				'type'   => 'null',
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
			'object' => [
				'actual' => new stdClass(),
				'type'   => 'an object',
			],
			'closed resource' => [
				'actual' => $resource,
				'type'   => ( \PHP_VERSION_ID > 70200 ) ? 'a closed resource' : 'a value of unknown type',
			],
		];
	}

	/**
	 * Verify availability and functionality of the assertIsList() method.
	 *
	 * @dataProvider dataAssertIsListPass
	 *
	 * @param array $actual The value to test.
	 *
	 * @return void
	 */
	public function testAssertIsListPass( $actual ) {
		$this->assertIsList( $actual );
	}

	/**
	 * Data provider.
	 *
	 * @return array
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
	 * @param array $actual The value to test.
	 *
	 * @return void
	 */
	public function testAssertIsListFail( $actual ) {
		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessage( 'Failed asserting that an array is a list' );

		static::assertIsList( $actual );
	}

	/**
	 * Data provider.
	 *
	 * @return array
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

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$array = [
			0 => 0,
			2 => 2,
		];

		$this->assertIsList( $array, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Helper function: retrieve the name of the "assertion failed" exception to expect (PHPUnit cross-version).
	 *
	 * @return string
	 */
	public function getAssertionFailedExceptionName() {
		$exception = AssertionFailedError::class;
		if ( \class_exists( PHPUnit_Framework_AssertionFailedError::class ) ) {
			// PHPUnit < 6.
			$exception = PHPUnit_Framework_AssertionFailedError::class;
		}

		return $exception;
	}
}
