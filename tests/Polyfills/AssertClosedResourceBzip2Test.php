<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: bzip2
 * Extension:     bz2
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 *
 * @requires extension bz2
 */
final class AssertClosedResourceBzip2Test extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$resource = \bzopen( __DIR__ . '/Fixtures/test.tar.bz2', 'r' );
		\bzclose( $resource );

		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$resource = \bzopen( __DIR__ . '/Fixtures/test.tar.bz2', 'r' );

		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		\bzclose( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$resource = \bzopen( __DIR__ . '/Fixtures/test.tar.bz2', 'r' );

		self::assertIsNotClosedResource( $resource );

		\bzclose( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$resource = \bzopen( __DIR__ . '/Fixtures/test.tar.bz2', 'r' );
		\bzclose( $resource );

		$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
	}
}
