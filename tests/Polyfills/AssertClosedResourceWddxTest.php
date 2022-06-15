<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: wddx
 * Extension:     wddx
 *
 * Note: this extension was removed in PHP 7.4.
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 *
 * @requires extension wddx
 * @requires PHP < 7.4
 *
 * @phpcs:disable PHPCompatibility.Extensions.RemovedExtensions.wddxRemoved
 * @phpcs:disable PHPCompatibility.FunctionUse.RemovedFunctions.wddx_packet_startRemoved
 * @phpcs:disable PHPCompatibility.FunctionUse.RemovedFunctions.wddx_packet_endRemoved
 */
final class AssertClosedResourceWddxTest extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$resource = \wddx_packet_start();
		\wddx_packet_end( $resource );

		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$resource = \wddx_packet_start();

		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		\wddx_packet_end( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$resource = \wddx_packet_start();

		self::assertIsNotClosedResource( $resource );

		\wddx_packet_end( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$resource = \wddx_packet_start();
		\wddx_packet_end( $resource );

		$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
	}
}
