<?php

namespace Yoast\PHPUnitPolyfills\Tests\Helpers;

use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\Tests\Helpers\Fixtures\ClassWithProperties;

/**
 * Test the helper methods in the AssertAttributeHelper trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\AssertAttributeHelper
 */
final class AssertAttributesHelperTest extends TestCase {

	/**
	 * Instance of the ClassWithProperties class.
	 *
	 * @var ClassWithProperties
	 */
	private $instance;

	/**
	 * Set up the class under test.
	 *
	 * @return void
	 */
	protected function set_up() {
		$this->instance = new ClassWithProperties();
	}

	/**
	 * Test retrieving information on the public property in its original state.
	 *
	 * @return void
	 */
	public function testOriginalStatePublicProperty() {
		$this->assertNull( $this->instance->public_prop );
		$this->assertNull( $this->getPropertyValue( $this->instance, 'public_prop' ) );
		$this->assertTrue( $this->getProperty( $this->instance, 'public_prop' )->isDefault() );
	}

	/**
	 * Test retrieving information on the protected property in its original state.
	 *
	 * @return void
	 */
	public function testOriginalStateProtectedProperty() {
		$this->assertNull( self::getPropertyValue( $this->instance, 'protected_prop' ) );
		$this->assertTrue( $this->getProperty( $this->instance, 'protected_prop' )->isDefault() );
	}

	/**
	 * Test retrieving information on the private property in its original state.
	 *
	 * @return void
	 */
	public function testOriginalStatePrivateProperty() {
		$this->assertFalse( $this->getPropertyValue( $this->instance, 'private_prop' ) );
		$this->assertTrue( static::getProperty( $this->instance, 'private_prop' )->isDefault() );
	}

	/**
	 * Test receiving an exception for a non-existent dynamic property.
	 *
	 * @return void
	 */
	public function testOriginalStateDynamicProperty() {
		$this->expectException( '\ReflectionException' );

		$this->getPropertyValue( $this->instance, 'dynamic' );
	}

	/**
	 * Test retrieving information on the public property once it has been set.
	 *
	 * @return void
	 */
	public function testPropertyValueOnceSetPublicProperty() {
		$this->instance->setProperties();

		$this->assertSame( 'public', $this->instance->public_prop );
		$this->assertSame( 'public', $this->getPropertyValue( $this->instance, 'public_prop' ) );
	}

	/**
	 * Test retrieving information on the protected property once it has been set.
	 *
	 * @return void
	 */
	public function testPropertyValueOnceSetProtectedProperty() {
		$this->instance->setProperties();

		$this->assertSame( 100, $this->getPropertyValue( $this->instance, 'protected_prop' ) );
	}

	/**
	 * Test retrieving information on the private property once it has been set.
	 *
	 * @return void
	 */
	public function testPropertyValueOnceSetPrivateProperty() {
		$this->instance->setProperties();

		$this->assertTrue( $this->getPropertyValue( $this->instance, 'private_prop' ) );
	}

	/**
	 * Test retrieving information on the dynamic property once it has been set.
	 *
	 * @return void
	 */
	public function testPropertyValueOnceSetDynamicProperty() {
		$this->instance->setProperties();

		$this->assertInstanceOf(
			'\Yoast\PHPUnitPolyfills\Tests\Helpers\Fixtures\ClassWithProperties',
			$this->getPropertyValue( $this->instance, 'dynamic' )
		);
		$this->assertFalse( $this->getProperty( $this->instance, 'dynamic' )->isDefault() );
	}
}
