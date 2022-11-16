<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: finfo
 * Extension:     finfo
 *
 * Note: the return value of the Enchant functions has changed in PHP 8.1 from `resource`
 * to `finfo` (object), which is why the tests will be skipped on PHP >= 8.1.
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 *
 * @requires extension finfo
 * @requires PHP < 8.1
 */
final class AssertClosedResourceFinfoTest extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$resource = \finfo_open();
		\finfo_close( $resource );

		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$resource = \finfo_open();

		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		\finfo_close( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$resource = \finfo_open();

		self::assertIsNotClosedResource( $resource );

		\finfo_close( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$resource = \finfo_open();
		\finfo_close( $resource );

		$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
	}
}
