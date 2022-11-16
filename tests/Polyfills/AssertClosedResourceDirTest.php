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
final class AssertClosedResourceDirTest extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$resource = \opendir( __DIR__ . '/Fixtures/' );
		\closedir( $resource );

		$this->assertFalse( static::shouldClosedResourceAssertionBeSkipped( $resource ) );
		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$resource = \opendir( __DIR__ . '/Fixtures/' );

		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		\closedir( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$resource = \opendir( __DIR__ . '/Fixtures/' );

		$this->assertFalse( static::shouldClosedResourceAssertionBeSkipped( $resource ) );
		self::assertIsNotClosedResource( $resource );

		\closedir( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$resource = \opendir( __DIR__ . '/Fixtures/' );
		\closedir( $resource );

		$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
	}
}
