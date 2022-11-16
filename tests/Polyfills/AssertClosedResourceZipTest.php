<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: zip
 * Extension:     zip
 *
 * Note: the procedural interface of the Zip extension has been deprecated in PHP 8.0.
 * Hence the use of the silence operator with the zip functions.
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 *
 * @requires extension zip
 *
 * @phpcs:disable Generic.PHP.DeprecatedFunctions.Deprecated
 * @phpcs:disable PHPCompatibility.FunctionUse.RemovedFunctions.zip_openDeprecated
 * @phpcs:disable PHPCompatibility.FunctionUse.RemovedFunctions.zip_closeDeprecated
 * @phpcs:disable WordPress.PHP.NoSilencedErrors.Discouraged
 */
final class AssertClosedResourceZipTest extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$resource = @\zip_open( __DIR__ . '/Fixtures/test.zip' );
		@\zip_close( $resource );

		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$resource = @\zip_open( __DIR__ . '/Fixtures/test.zip' );

		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		@\zip_close( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$resource = @\zip_open( __DIR__ . '/Fixtures/test.zip' );

		self::assertIsNotClosedResource( $resource );

		@\zip_close( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$resource = @\zip_open( __DIR__ . '/Fixtures/test.zip' );
		@\zip_close( $resource );

		$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
	}
}
