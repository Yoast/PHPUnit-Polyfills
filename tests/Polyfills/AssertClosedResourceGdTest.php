<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: gd
 * Extension:     gd
 *
 * Note: the return value of the GD functions has changed in PHP 8.0 from `resource`
 * to `GdImage` (object), which is why the tests will be skipped on PHP >= 8.0.
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 *
 * @requires extension gd
 * @requires PHP < 8.0
 */
final class AssertClosedResourceGdTest extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$resource = \imagecreate( 1, 1 );
		\imagedestroy( $resource );

		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$resource = \imagecreate( 1, 1 );

		$this->assertFalse( static::shouldClosedResourceAssertionBeSkipped( $resource ) );
		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		\imagedestroy( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$resource = \imagecreate( 1, 1 );

		self::assertIsNotClosedResource( $resource );

		\imagedestroy( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$resource = \imagecreate( 1, 1 );
		\imagedestroy( $resource );

		$this->assertFalse( static::shouldClosedResourceAssertionBeSkipped( $resource ) );
		$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
	}
}
