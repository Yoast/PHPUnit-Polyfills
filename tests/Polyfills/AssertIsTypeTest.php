<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use stdClass;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;

/**
 * Availability test for the functions polyfilled by the AssertIsType trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertIsType
 */
final class AssertIsTypeTest extends TestCase {

	use AssertIsType;

	/**
	 * Verify availability of the assertIsArray() method.
	 *
	 * @return void
	 */
	public function testAssertIsArray() {
		$this->assertIsArray( [ 1, 2, 3 ] );
	}

	/**
	 * Verify availability of the assertIsBool() method.
	 *
	 * @return void
	 */
	public function testAssertIsBool() {
		$this->assertIsBool( true );
	}

	/**
	 * Verify availability of the assertIsFloat() method.
	 *
	 * @return void
	 */
	public function testAssertIsFloat() {
		self::assertIsFloat( 1.2 );
	}

	/**
	 * Verify availability of the assertIsInt() method.
	 *
	 * @return void
	 */
	public function testAssertIsInt() {
		$this->assertIsInt( 10 );
	}

	/**
	 * Verify availability of the assertIsNumeric() method.
	 *
	 * @return void
	 */
	public function testAssertIsNumeric() {
		self::assertIsNumeric( '1.3e2' );
	}

	/**
	 * Verify availability of the assertIsObject() method.
	 *
	 * @return void
	 */
	public function testAssertIsObject() {
		$this->assertIsObject( new stdClass() );
	}

	/**
	 * Verify availability of the assertIsResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsResource() {
		// TODO: needs checking if this is still a resource in PHP 8!
		$resource = \opendir( __DIR__ );
		$this->assertIsResource( $resource );
		\closedir( $resource );
	}

	/**
	 * Verify availability of the assertIsArray() method.
	 *
	 * @return void
	 */
	public function testAssertIsString() {
		self::assertIsString( 'test' );
	}

	/**
	 * Verify availability of the assertIsScalar() method.
	 *
	 * @return void
	 */
	public function testAssertIsScalar() {
		self::assertIsScalar( false );
	}

	/**
	 * Verify availability of the assertIsCallable() method.
	 *
	 * @return void
	 */
	public function testAssertIsCallable() {
		$this->assertIsCallable( 'strpos' );
	}

	/**
	 * Verify availability of the assertIsIterable() method.
	 *
	 * @return void
	 */
	public function testAssertIsIterable() {
		$this->assertIsIterable( [ 1, 2, 3 ] );
	}

	/**
	 * Verify availability of the assertIsNotArray() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotArray() {
		self::assertIsNotArray( true );
	}

	/**
	 * Verify availability of the assertIsNotBool() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotBool() {
		self::assertIsNotBool( null );
	}

	/**
	 * Verify availability of the assertIsNotFloat() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotFloat() {
		$this->assertIsNotFloat( false );
	}

	/**
	 * Verify availability of the assertIsNotInt() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotInt() {
		$this->assertIsNotInt( false );
	}

	/**
	 * Verify availability of the assertIsNotNumeric() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotNumeric() {
		self::assertIsNotNumeric( false );
	}

	/**
	 * Verify availability of the assertIsNotObject() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotObject() {
		self::assertIsNotObject( false );
	}

	/**
	 * Verify availability of the assertIsNotResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotResource() {
		$this->assertIsNotResource( false );
	}

	/**
	 * Verify availability of the assertIsNotString() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotString() {
		$this->assertIsNotString( false );
	}

	/**
	 * Verify availability of the assertIsNotScalar() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotScalar() {
		self::assertIsNotScalar( [ 1, 2, 3 ] );
	}

	/**
	 * Verify availability of the assertIsNotCallable() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotCallable() {
		self::assertIsNotCallable( null );
	}

	/**
	 * Verify availability of the assertIsNotIterable() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotIterable() {
		$this->assertIsNotIterable( false );
	}
}
