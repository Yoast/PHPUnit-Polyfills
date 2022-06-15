<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: zlib
 * Extension:     zlib
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 *
 * @requires extension zlib
 */
final class AssertClosedResourceZlibTest extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$resource = \gzopen( __DIR__ . '/Fixtures/test.tar.gz', 'r' );
		\gzclose( $resource );

		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$resource = \gzopen( __DIR__ . '/Fixtures/test.tar.gz', 'r' );

		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		\gzclose( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$resource = \gzopen( __DIR__ . '/Fixtures/test.tar.gz', 'r' );

		self::assertIsNotClosedResource( $resource );

		\gzclose( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$resource = \gzopen( __DIR__ . '/Fixtures/test.tar.gz', 'r' );
		\gzclose( $resource );

		$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
	}
}
