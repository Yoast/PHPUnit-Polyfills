<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Version as PHPUnit_Version;
use stdClass;
use Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectNoReturnType;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectUnionNoReturnType;

/**
 * Availability test for the function polyfilled by the AssertObjectEquals trait.
 *
 * This test class should mirror the `AssertObjectEqualsTest`.
 * The difference between the classes is that this class runs the tests using classes
 * (fixtures) in which the comparator method is declared without a return type.
 *
 * This tests that the assertion method is available and fully functional on PHPUnit < 9.4.0,
 * even though using the assertion like this - with a comparator method without return type -
 * would make a test incompatible with the PHPUnit 9.4.0+ native implementation
 * of the assertion.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals
 */
final class AssertObjectEqualsPHPUnitLt940Test extends TestCase {

	use AssertObjectEquals;
	use ExpectException; // Needed for PHPUnit < 5.2.0 support.
	use ExpectExceptionMessageMatches;

	/**
	 * The name of the "comparator method does not comply with requirements" exception as
	 * used by the polyfill.
	 *
	 * @var string
	 */
	const COMPARATOR_EXCEPTION = 'Yoast\PHPUnitPolyfills\Exceptions\InvalidComparisonMethodException';

	/**
	 * Check if these tests can run.
	 *
	 * This checks needs to be done via a version compare instead of using a "requires"
	 * annotation as in older PHPUnit versions, the comparison operators in "requires"
	 * annotations are not yet supported.
	 *
	 * @before
	 *
	 * @return void
	 */
	public function maybeSkipTest() {
		if ( \version_compare( PHPUnit_Version::id(), '9.4.0', '>=' ) ) {
			$this->markTestSkipped( 'This test can not be run with the PHPUnit native implementation of assertObjectEquals()' );
		}
	}

	/**
	 * Verify availability of the assertObjectEquals() method.
	 *
	 * @return void
	 */
	public function testAssertObjectEquals() {
		$expected = new ValueObjectNoReturnType( 'test' );
		$actual   = new ValueObjectNoReturnType( 'test' );
		$this->assertObjectEquals( $expected, $actual );
	}

	/**
	 * Verify behaviour when passing the $method parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsCustomMethodName() {
		$expected = new ValueObjectNoReturnType( 'different name' );
		$actual   = new ValueObjectNoReturnType( 'different name' );
		$this->assertObjectEquals( $expected, $actual, 'nonDefaultName' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $expected parameter is not an object.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnExpectedNotObject() {
		$pattern = '`^Argument 1 passed to [^\s]*assertObjectEquals\(\) must be an object, string given`';

		$this->expectException( 'TypeError' );
		$this->expectExceptionMessageMatches( $pattern );

		$actual = new ValueObjectNoReturnType( 'test' );
		$this->assertObjectEquals( 'className', $actual );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $actual parameter is not an object.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnActualNotObject() {
		$pattern = '`^Argument 2 passed to [^\s]*assertObjectEquals\(\) must be an object, string given`';

		$this->expectException( 'TypeError' );
		$this->expectExceptionMessageMatches( $pattern );

		$expected = new ValueObjectNoReturnType( 'test' );
		$this->assertObjectEquals( $expected, 'className' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method parameter is not
	 * juggleable to a string.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodNotJuggleableToString() {
		$pattern = '`^Argument 3 passed to [^\s]*assertObjectEquals\(\) must be of the type string, array given`';

		$this->expectException( 'TypeError' );
		$this->expectExceptionMessageMatches( $pattern );

		$expected = new ValueObjectNoReturnType( 'test' );
		$actual   = new ValueObjectNoReturnType( 'test' );
		$this->assertObjectEquals( $expected, $actual, [] );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $actual object
	 * does not contain a method called $method.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodNotDeclared() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectNoReturnType::doesNotExist() does not exist.';

		$this->expectException( self::COMPARATOR_EXCEPTION );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectNoReturnType( 'test' );
		$actual   = new ValueObjectNoReturnType( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'doesNotExist' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method accepts more than one parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodAllowsForMoreParams() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectNoReturnType::equalsTwoParams() does not declare exactly one parameter.';

		$this->expectException( self::COMPARATOR_EXCEPTION );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectNoReturnType( 'test' );
		$actual   = new ValueObjectNoReturnType( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'equalsTwoParams' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method is not a required parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodParamNotRequired() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectNoReturnType::equalsParamNotRequired() does not declare exactly one parameter.';

		$this->expectException( self::COMPARATOR_EXCEPTION );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectNoReturnType( 'test' );
		$actual   = new ValueObjectNoReturnType( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'equalsParamNotRequired' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method parameter
	 * does not have a type declaration.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodParamMissingTypeDeclaration() {
		$msg = 'Parameter of comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectNoReturnType::equalsParamNoType() does not have a declared type.';

		$this->expectException( self::COMPARATOR_EXCEPTION );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectNoReturnType( 'test' );
		$actual   = new ValueObjectNoReturnType( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'equalsParamNoType' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method parameter
	 * has a PHP 8.0+ union type declaration.
	 *
	 * @requires PHP 8.0
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodParamHasUnionTypeDeclaration() {
		$msg = 'Parameter of comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectUnionNoReturnType::equalsParamUnionType() does not have a declared type.';

		$this->expectException( self::COMPARATOR_EXCEPTION );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectUnionNoReturnType( 'test' );
		$actual   = new ValueObjectUnionNoReturnType( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'equalsParamUnionType' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method parameter
	 * does not have a class-based type declaration.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodParamNonClassTypeDeclaration() {
		$msg = 'is not an accepted argument type for comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectNoReturnType::equalsParamNonClassType().';
		if ( \PHP_VERSION_ID < 70000 ) {
			$msg = 'Parameter of comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectNoReturnType::equalsParamNonClassType() does not have a declared type.';
		}

		$this->expectException( self::COMPARATOR_EXCEPTION );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectNoReturnType( 'test' );
		$actual   = new ValueObjectNoReturnType( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'equalsParamNonClassType' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method parameter
	 * has a class-based type declaration, but for a class which doesn't exist.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodParamNonExistentClassTypeDeclaration() {
		$msg = 'is not an accepted argument type for comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectNoReturnType::equalsParamNonExistentClassType().';

		$this->expectException( self::COMPARATOR_EXCEPTION );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectNoReturnType( 'test' );
		$actual   = new ValueObjectNoReturnType( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'equalsParamNonExistentClassType' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when $expected is not
	 * an instance of the type declared for the $method parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodParamTypeMismatch() {
		$msg = 'is not an accepted argument type for comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectNoReturnType::equals().';

		$this->expectException( self::COMPARATOR_EXCEPTION );
		$this->expectExceptionMessage( $msg );

		$actual = new ValueObjectNoReturnType( 'test' );
		$this->assertObjectEquals( new stdClass(), $actual );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the declared return type/
	 * the return value is not boolean.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnNonBooleanReturnValue() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectNoReturnType::equalsNonBooleanReturnType() does not return a boolean value.';

		$this->expectException( self::COMPARATOR_EXCEPTION );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectNoReturnType( 100 );
		$actual   = new ValueObjectNoReturnType( 100 );
		$this->assertObjectEquals( $expected, $actual, 'equalsNonBooleanReturnType' );
	}

	/**
	 * Verify that the assertObjectEquals() method fails a test when a call to method
	 * determines that the objects are not equal.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsAsNotEqual() {
		$msg = 'Failed asserting that two objects are equal.';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectNoReturnType( 'test' );
		$actual   = new ValueObjectNoReturnType( 'testing... 1..2..3' );
		$this->assertObjectEquals( $expected, $actual );
	}

	/**
	 * Verify that the assertObjectEquals() method fails a test with a custom failure message, when a call
	 * to the method determines that the objects are not equal and the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsAsNotEqualWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that two objects are equal\.`';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$expected = new ValueObjectNoReturnType( 'test' );
		$actual   = new ValueObjectNoReturnType( 'testing... 1..2..3' );
		$this->assertObjectEquals( $expected, $actual, 'equals', 'This assertion failed for reason XYZ' );
	}

	/**
	 * Helper function: retrieve the name of the "assertion failed" exception to expect (PHPUnit cross-version).
	 *
	 * @return string
	 */
	public function getAssertionFailedExceptionName() {
		$exception = 'PHPUnit\Framework\AssertionFailedError';
		if ( \class_exists( 'PHPUnit_Framework_AssertionFailedError' ) ) {
			// PHPUnit < 6.
			$exception = 'PHPUnit_Framework_AssertionFailedError';
		}

		return $exception;
	}
}
