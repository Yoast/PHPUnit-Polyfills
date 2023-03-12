<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use stdClass;
use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 */
final class AssertClosedResourceNotResourceTest extends TestCase {

	use AssertClosedResource;
	use ExpectException; // Needed for PHPUnit < 5.2.0 support.
	use ExpectExceptionMessageMatches;

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a resource.
	 *
	 * @dataProvider dataNotResource
	 *
	 * @param mixed $value The value to test.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResource( $value ) {
		$pattern = '`^Failed asserting that .+? is of type ["]?resource \(closed\)["]?`s';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertIsClosedResource( $value );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that .+? is of type ["]?resource \(closed\)["]?`s';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertIsClosedResource( 'text string', 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method passes the test when the variable
	 * passed is not a resource.
	 *
	 * @dataProvider dataNotResource
	 *
	 * @param mixed $value The value to test.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResource( $value ) {
		self::assertIsNotClosedResource( $value );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that .+? not of type ["]?resource \(closed\)["]?`s';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$resource = \opendir( __DIR__ . '/Fixtures/' );
		\closedir( $resource );

		$this->assertIsNotClosedResource( $resource, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify that the shouldClosedResourceAssertionBeSkipped() method returns true for non-resources.
	 *
	 * @dataProvider dataNotResource
	 *
	 * @param mixed $value The value to test.
	 *
	 * @return void
	 */
	public function testShouldClosedResourceAssertionBeSkipped( $value ) {
		$this->assertFalse( self::shouldClosedResourceAssertionBeSkipped( $value ) );
	}

	/**
	 * Data provider
	 *
	 * @return array
	 */
	public static function dataNotResource() {
		return [
			'null'            => [ null ],
			'false'           => [ false ],
			'true'            => [ true ],
			'int'             => [ 1024 ],
			'float'           => [ -78.72836 ],
			'string'          => [ 'text string' ],
			'array-empty'     => [ [] ],
			'array-not-empty' => [ [ 'key' => 'value' ] ],
			'object'          => [ new stdClass() ],
		];
	}

	/**
	 * Helper function: retrieve the name of the "assertion failed" exception to expect (PHPUnit cross-version).
	 *
	 * @return string
	 */
	public function getAssertionFailedExceptionName() {
		$exception = 'PHPUnit\Framework\AssertionFailedError';
		if ( \class_exists( 'PHPUnit_Framework_AssertionFailedError' ) ) {
			// PHPUnit < 6.
			$exception = 'PHPUnit_Framework_AssertionFailedError';
		}

		return $exception;
	}
}
