<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: stream
 * Extension:     standard (Core)
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 */
final class AssertClosedResourceFileTest extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$resource = \fopen( __DIR__ . '/Fixtures/test.txt', 'r' );
		\fclose( $resource );

		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$resource = \fopen( __DIR__ . '/Fixtures/test.txt', 'r' );

		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		\fclose( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$resource = \fopen( __DIR__ . '/Fixtures/test.txt', 'r' );

		self::assertIsNotClosedResource( $resource );

		\fclose( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$resource = \fopen( __DIR__ . '/Fixtures/test.txt', 'r' );
		\fclose( $resource );

		$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
	}
}
