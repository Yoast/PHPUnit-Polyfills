<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Version as PHPUnit_Version;
use stdClass;
use Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ChildValueObject;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectUnion;

/**
 * Availability test for the function polyfilled by the AssertObjectEquals trait.
 *
 * Due to the use of return types in the classes under test (fixtures), these
 * tests can only run on PHP 7.0 and higher.
 *
 * The `AssertObjectEqualsPHPUnitLt940Test` class mirrors this test class
 * and tests the polyfill method for PHP < 7.0.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals
 *
 * @requires PHP 7.0
 */
final class AssertObjectEqualsTest extends TestCase {

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
	 * Verify availability of the assertObjectEquals() method.
	 *
	 * @return void
	 */
	public function testAssertObjectEquals() {
		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'test' );
		$this->assertObjectEquals( $expected, $actual );
	}

	/**
	 * Verify behaviour when passing the $method parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsCustomMethodName() {
		$expected = new ValueObject( 'different name' );
		$actual   = new ValueObject( 'different name' );
		$this->assertObjectEquals( $expected, $actual, 'nonDefaultName' );
	}

	/**
	 * Verify behaviour when $expected is a child of $actual.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsExpectedChildOfActual() {
		$expected = new ChildValueObject( 'inheritance' );
		$actual   = new ValueObject( 'inheritance' );
		$this->assertObjectEquals( $expected, $actual );
	}

	/**
	 * Verify behaviour when $actual is a child of $expected.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsActualChildOfExpected() {
		$expected = new ValueObject( 'inheritance' );
		$actual   = new ChildValueObject( 'inheritance' );
		$this->assertObjectEquals( $expected, $actual );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $expected parameter is not an object.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnExpectedNotObject() {
		$this->expectException( 'TypeError' );

		if ( \PHP_VERSION_ID >= 80000
			&& \version_compare( PHPUnit_Version::id(), '9.4.0', '>=' )
		) {
			$msg = 'assertObjectEquals(): Argument #1 ($expected) must be of type object, string given';
			$this->expectExceptionMessage( $msg );
		}
		else {
			// PHP 5/7 or PHP 8 with the polyfill.
			$pattern = '`^Argument 1 passed to [^\s]*assertObjectEquals\(\) must be an object, string given`';
			$this->expectExceptionMessageMatches( $pattern );
		}

		$actual = new ValueObject( 'test' );
		$this->assertObjectEquals( 'className', $actual );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $actual parameter is not an object.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnActualNotObject() {
		$this->expectException( 'TypeError' );

		if ( \PHP_VERSION_ID >= 80000
			&& \version_compare( PHPUnit_Version::id(), '9.4.0', '>=' )
		) {
			$msg = 'assertObjectEquals(): Argument #2 ($actual) must be of type object, string given';
			$this->expectExceptionMessage( $msg );
		}
		else {
			// PHP 5/7.
			$pattern = '`^Argument 2 passed to [^\s]*assertObjectEquals\(\) must be an object, string given`';
			$this->expectExceptionMessageMatches( $pattern );
		}

		$expected = new ValueObject( 'test' );
		$this->assertObjectEquals( $expected, 'className' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method parameter is not
	 * juggleable to a string.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodNotJuggleableToString() {
		$this->expectException( 'TypeError' );

		if ( \PHP_VERSION_ID >= 80000
			&& \version_compare( PHPUnit_Version::id(), '9.4.0', '>=' )
		) {
			$msg = 'assertObjectEquals(): Argument #3 ($method) must be of type string, array given';
			$this->expectExceptionMessage( $msg );
		}
		else {
			// PHP 5/7.
			$pattern = '`^Argument 3 passed to [^\s]*assertObjectEquals\(\) must be of the type string, array given`';
			$this->expectExceptionMessageMatches( $pattern );
		}

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'test' );
		$this->assertObjectEquals( $expected, $actual, [] );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $actual object
	 * does not contain a method called $method.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodNotDeclared() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::doesNotExist() does not exist.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( 'PHPUnit\Framework\ComparisonMethodDoesNotExistException' ) ) {
			// PHPUnit > 9.4.0.
			$exception = 'PHPUnit\Framework\ComparisonMethodDoesNotExistException';
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'doesNotExist' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method accepts more than one parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodAllowsForMoreParams() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsTwoParams() does not declare exactly one parameter.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( 'PHPUnit\Framework\ComparisonMethodDoesNotDeclareExactlyOneParameterException' ) ) {
			// PHPUnit > 9.4.0.
			$exception = 'PHPUnit\Framework\ComparisonMethodDoesNotDeclareExactlyOneParameterException';
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'equalsTwoParams' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method is not a required parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodParamNotRequired() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsParamNotRequired() does not declare exactly one parameter.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( 'PHPUnit\Framework\ComparisonMethodDoesNotDeclareExactlyOneParameterException' ) ) {
			// PHPUnit > 9.4.0.
			$exception = 'PHPUnit\Framework\ComparisonMethodDoesNotDeclareExactlyOneParameterException';
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'equalsParamNotRequired' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method parameter
	 * does not have a type declaration.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodParamMissingTypeDeclaration() {
		$msg = 'Parameter of comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsParamNoType() does not have a declared type.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( 'PHPUnit\Framework\ComparisonMethodDoesNotDeclareParameterTypeException' ) ) {
			// PHPUnit > 9.4.0.
			$exception = 'PHPUnit\Framework\ComparisonMethodDoesNotDeclareParameterTypeException';
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'test' );
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
		$msg = 'Parameter of comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectUnion::equalsParamUnionType() does not have a declared type.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( 'PHPUnit\Framework\ComparisonMethodDoesNotDeclareParameterTypeException' ) ) {
			// PHPUnit > 9.4.0.
			$exception = 'PHPUnit\Framework\ComparisonMethodDoesNotDeclareParameterTypeException';
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectUnion( 'test' );
		$actual   = new ValueObjectUnion( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'equalsParamUnionType' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method parameter
	 * does not have a class-based type declaration.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodParamNonClassTypeDeclaration() {
		$msg = 'is not an accepted argument type for comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsParamNonClassType().';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( 'PHPUnit\Framework\ComparisonMethodDoesNotAcceptParameterTypeException' ) ) {
			// PHPUnit > 9.4.0.
			$exception = 'PHPUnit\Framework\ComparisonMethodDoesNotAcceptParameterTypeException';
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'equalsParamNonClassType' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the $method parameter
	 * has a class-based type declaration, but for a class which doesn't exist.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodParamNonExistentClassTypeDeclaration() {
		$msg = 'is not an accepted argument type for comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsParamNonExistentClassType().';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( 'PHPUnit\Framework\ComparisonMethodDoesNotAcceptParameterTypeException' ) ) {
			// PHPUnit > 9.4.0.
			$exception = 'PHPUnit\Framework\ComparisonMethodDoesNotAcceptParameterTypeException';
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'test' );
		$this->assertObjectEquals( $expected, $actual, 'equalsParamNonExistentClassType' );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when $expected is not
	 * an instance of the type declared for the $method parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnMethodParamTypeMismatch() {
		$msg = 'is not an accepted argument type for comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equals().';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( 'PHPUnit\Framework\ComparisonMethodDoesNotAcceptParameterTypeException' ) ) {
			// PHPUnit > 9.4.0.
			$exception = 'PHPUnit\Framework\ComparisonMethodDoesNotAcceptParameterTypeException';
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$actual = new ValueObject( 'test' );
		$this->assertObjectEquals( new stdClass(), $actual );
	}

	/**
	 * Verify that the assertObjectEquals() method throws an error when the declared return type/
	 * the return value is not boolean.
	 *
	 * @return void
	 */
	public function testAssertObjectEqualsFailsOnNonBooleanReturnValue() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsNonBooleanReturnType() does not return a boolean value.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( 'PHPUnit\Framework\ComparisonMethodDoesNotDeclareBoolReturnTypeException' ) ) {
			// PHPUnit > 9.4.0.
			$msg       = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsNonBooleanReturnType() does not declare bool return type.';
			$exception = 'PHPUnit\Framework\ComparisonMethodDoesNotDeclareBoolReturnTypeException';
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 100 );
		$actual   = new ValueObject( 100 );
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

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'testing... 1..2..3' );
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

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'testing... 1..2..3' );
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
