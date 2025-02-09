<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: gd
 * Extension:     gd
 */
abstract class AssertClosedResourceGdTestCase extends AssertClosedResourceTestCase {

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
