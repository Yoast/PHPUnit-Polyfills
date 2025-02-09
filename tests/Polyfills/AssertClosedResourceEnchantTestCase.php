<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: enchant_broker
 * Extension:     enchant
 *
 * @phpcs:disable Generic.PHP.DeprecatedFunctions.Deprecated
 * @phpcs:disable PHPCompatibility.FunctionUse.RemovedFunctions.enchant_broker_freeDeprecated
 */
abstract class AssertClosedResourceEnchantTestCase extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$resource = \enchant_broker_init();
		\enchant_broker_free( $resource );

		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$resource = \enchant_broker_init();

		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		\enchant_broker_free( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$resource = \enchant_broker_init();

		self::assertIsNotClosedResource( $resource );

		\enchant_broker_free( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$resource = \enchant_broker_init();
		\enchant_broker_free( $resource );

		$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
	}
}
