<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: curl
 * Extension:     curl
 *
 * Note: the return value of the Curl functions has changed in PHP 8.0 from `resource`
 * to `CurlHandle` (object), which is why the tests will be skipped on PHP >= 8.0.
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 *
 * @requires extension curl
 * @requires PHP < 8.0
 */
final class AssertClosedResourceCurlTest extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$resource = \curl_init( 'http://httpbin.org/anything' );
		\curl_close( $resource );

		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$resource = \curl_init( 'http://httpbin.org/anything' );

		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		\curl_close( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$resource = \curl_init( 'http://httpbin.org/anything' );

		self::assertIsNotClosedResource( $resource );

		\curl_close( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$resource = \curl_init( 'http://httpbin.org/anything' );
		\curl_close( $resource );

		$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
	}
}
