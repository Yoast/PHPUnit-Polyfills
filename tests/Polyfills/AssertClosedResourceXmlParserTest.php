<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Yoast\PHPUnitPolyfills\Helpers\ResourceHelper;
use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: xml
 * Extension:     libxml
 *
 * Note: the return value of the XML Parser functions has changed in PHP 8.0 from `resource`
 * to `XMLParser` (object), which is why the tests will be skipped on PHP >= 8.0.
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 *
 * @requires extension libxml
 * @requires PHP < 8.0
 */
final class AssertClosedResourceXmlParserTest extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$resource = \xml_parser_create();
		\xml_parser_free( $resource );

		if ( ResourceHelper::isIncompatiblePHPForLibXMLResources() === false ) {
			$this->assertIsClosedResource( $resource );
			return;
		}

		// Incompatible PHP version. Verify that assertion skipping is advised.
		$this->assertTrue( static::shouldClosedResourceAssertionBeSkipped( $resource ) );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$resource = \xml_parser_create();

		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		\xml_parser_free( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$resource = \xml_parser_create();

		self::assertIsNotClosedResource( $resource );

		\xml_parser_free( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$resource = \xml_parser_create();
		\xml_parser_free( $resource );

		if ( ResourceHelper::isIncompatiblePHPForLibXMLResources() === false ) {
			$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
			return;
		}

		// Incompatible PHP version. Verify that assertion skipping is advised.
		$this->assertTrue( static::shouldClosedResourceAssertionBeSkipped( $resource ) );
	}
}
