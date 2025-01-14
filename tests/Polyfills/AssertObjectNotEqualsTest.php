<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\ComparisonMethodDoesNotAcceptParameterTypeException;
use PHPUnit\Framework\ComparisonMethodDoesNotDeclareBoolReturnTypeException;
use PHPUnit\Framework\ComparisonMethodDoesNotDeclareExactlyOneParameterException;
use PHPUnit\Framework\ComparisonMethodDoesNotDeclareParameterTypeException;
use PHPUnit\Framework\ComparisonMethodDoesNotExistException;
use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Version as PHPUnit_Version;
use stdClass;
use TypeError;
use Yoast\PHPUnitPolyfills\Exceptions\InvalidComparisonMethodException;
use Yoast\PHPUnitPolyfills\Helpers\ComparatorValidator;
use Yoast\PHPUnitPolyfills\Polyfills\AssertObjectNotEquals;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ChildValueObject;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectUnion;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectUnionReturnType;

/**
 * Availability test for the function polyfilled by the AssertObjectNotEquals trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertObjectNotEquals
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ComparatorValidator
 */
#[CoversClass( AssertObjectNotEquals::class )]
#[CoversClass( ComparatorValidator::class )]
final class AssertObjectNotEqualsTest extends TestCase {

	use AssertObjectNotEquals;
	use ExpectExceptionMessageMatches;

	/**
	 * The name of the "comparator method does not comply with requirements" exception as
	 * used by the polyfill.
	 *
	 * @var string
	 */
	const COMPARATOR_EXCEPTION = InvalidComparisonMethodException::class;

	/**
	 * Verify availability of the assertObjectNotEquals() method.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEquals() {
		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'different' );
		$this->assertObjectNotEquals( $expected, $actual );
	}

	/**
	 * Verify behaviour when passing the $method parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsCustomMethodName() {
		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'different' );
		$this->assertObjectNotEquals( $expected, $actual, 'nonDefaultName' );
	}

	/**
	 * Verify behaviour when $expected is a child of $actual.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsExpectedChildOfActual() {
		$expected = new ChildValueObject( 'inheritance' );
		$actual   = new ValueObject( 'different' );
		$this->assertObjectNotEquals( $expected, $actual );
	}

	/**
	 * Verify behaviour when $actual is a child of $expected.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsActualChildOfExpected() {
		$expected = new ValueObject( 'inheritance' );
		$actual   = new ChildValueObject( 'different' );
		$this->assertObjectNotEquals( $expected, $actual );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the $expected parameter is not an object.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnExpectedNotObject() {
		$this->expectException( TypeError::class );

		if ( \PHP_VERSION_ID >= 80000
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			$msg = 'assertObjectNotEquals(): Argument #1 ($expected) must be of type object, string given';
			$this->expectExceptionMessage( $msg );
		}
		else {
			// PHP 7 or PHP 8 with the polyfill.
			$pattern = '`^Argument 1 passed to [^\s]*assertObjectNotEquals\(\) must be an object, string given`';
			$this->expectExceptionMessageMatches( $pattern );
		}

		$actual = new ValueObject( 'test' );
		$this->assertObjectNotEquals( 'className', $actual );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the $actual parameter is not an object.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnActualNotObject() {
		$this->expectException( TypeError::class );

		if ( \PHP_VERSION_ID >= 80000
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			$msg = 'assertObjectNotEquals(): Argument #2 ($actual) must be of type object, string given';
			$this->expectExceptionMessage( $msg );
		}
		else {
			// PHP 7.
			$pattern = '`^Argument 2 passed to [^\s]*assertObjectNotEquals\(\) must be an object, string given`';
			$this->expectExceptionMessageMatches( $pattern );
		}

		$expected = new ValueObject( 'test' );
		$this->assertObjectNotEquals( $expected, 'className' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the $method parameter is not
	 * juggleable to a string.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnMethodNotJuggleableToString() {
		$this->expectException( TypeError::class );

		if ( \PHP_VERSION_ID >= 80000
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			$msg = 'assertObjectNotEquals(): Argument #3 ($method) must be of type string, array given';
			$this->expectExceptionMessage( $msg );
		}
		else {
			// PHP 7.
			$pattern = '`^Argument 3 passed to [^\s]*assertObjectNotEquals\(\) must be of the type string, array given`';
			$this->expectExceptionMessageMatches( $pattern );
		}

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'different' );
		$this->assertObjectNotEquals( $expected, $actual, [] );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the $actual object
	 * does not contain a method called $method.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnMethodNotDeclared() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::doesNotExist() does not exist.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotExistException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotExistException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'different' );
		$this->assertObjectNotEquals( $expected, $actual, 'doesNotExist' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when no return type is declared.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnMissingReturnType() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsMissingReturnType() does not declare bool return type.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotDeclareBoolReturnTypeException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotDeclareBoolReturnTypeException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 100 );
		$actual   = new ValueObject( 101 );
		$this->assertObjectNotEquals( $expected, $actual, 'equalsMissingReturnType' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the declared return type in a union, intersection or DNF type.
	 *
	 * @requires PHP 8.0
	 *
	 * @return void
	 */
	#[RequiresPhp( '8.0' )]
	public function testAssertObjectNotEqualsFailsOnNonNamedTypeReturnType() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectUnionReturnType::equalsUnionReturnType() does not declare bool return type.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotDeclareBoolReturnTypeException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotDeclareBoolReturnTypeException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectUnionReturnType( 100 );
		$actual   = new ValueObjectUnionReturnType( 010 );
		$this->assertObjectNotEquals( $expected, $actual, 'equalsUnionReturnType' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the declared return type is nullable.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnNullableReturnType() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsNullableReturnType() does not declare bool return type.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotDeclareBoolReturnTypeException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotDeclareBoolReturnTypeException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 100 );
		$actual   = new ValueObject( 250 );
		$this->assertObjectNotEquals( $expected, $actual, 'equalsNullableReturnType' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the declared return type is not boolean.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnNonBooleanReturnType() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsNonBooleanReturnType() does not declare bool return type.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotDeclareBoolReturnTypeException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotDeclareBoolReturnTypeException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 100 );
		$actual   = new ValueObject( 123 );
		$this->assertObjectNotEquals( $expected, $actual, 'equalsNonBooleanReturnType' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the $method accepts more than one parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnMethodAllowsForMoreParams() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsTwoParams() does not declare exactly one parameter.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotDeclareExactlyOneParameterException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotDeclareExactlyOneParameterException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'different' );
		$this->assertObjectNotEquals( $expected, $actual, 'equalsTwoParams' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the $method is not a required parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnMethodParamNotRequired() {
		$msg = 'Comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsParamNotRequired() does not declare exactly one parameter.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotDeclareExactlyOneParameterException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotDeclareExactlyOneParameterException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'different' );
		$this->assertObjectNotEquals( $expected, $actual, 'equalsParamNotRequired' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the $method parameter
	 * does not have a type declaration.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnMethodParamMissingTypeDeclaration() {
		$msg = 'Parameter of comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsParamNoType() does not have a declared type.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotDeclareParameterTypeException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotDeclareParameterTypeException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'different' );
		$this->assertObjectNotEquals( $expected, $actual, 'equalsParamNoType' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the $method parameter
	 * has a PHP 8.0+ union type declaration.
	 *
	 * @requires PHP 8.0
	 *
	 * @return void
	 */
	#[RequiresPhp( '8.0' )]
	public function testAssertObjectNotEqualsFailsOnMethodParamHasUnionTypeDeclaration() {
		$msg = 'Parameter of comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObjectUnion::equalsParamUnionType() does not have a declared type.';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotDeclareParameterTypeException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotDeclareParameterTypeException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObjectUnion( 'test' );
		$actual   = new ValueObjectUnion( 'different' );
		$this->assertObjectNotEquals( $expected, $actual, 'equalsParamUnionType' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the $method parameter
	 * does not have a class-based type declaration.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnMethodParamNonClassTypeDeclaration() {
		$msg = 'is not an accepted argument type for comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsParamNonClassType().';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotAcceptParameterTypeException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotAcceptParameterTypeException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'different' );
		$this->assertObjectNotEquals( $expected, $actual, 'equalsParamNonClassType' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when the $method parameter
	 * has a class-based type declaration, but for a class which doesn't exist.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnMethodParamNonExistentClassTypeDeclaration() {
		$msg = 'is not an accepted argument type for comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equalsParamNonExistentClassType().';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotAcceptParameterTypeException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotAcceptParameterTypeException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'different' );
		$this->assertObjectNotEquals( $expected, $actual, 'equalsParamNonExistentClassType' );
	}

	/**
	 * Verify that the assertObjectNotEquals() method throws an error when $expected is not
	 * an instance of the type declared for the $method parameter.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnMethodParamTypeMismatch() {
		$msg = 'is not an accepted argument type for comparison method Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ValueObject::equals().';

		$exception = self::COMPARATOR_EXCEPTION;
		if ( \class_exists( ComparisonMethodDoesNotAcceptParameterTypeException::class )
			&& \version_compare( PHPUnit_Version::id(), '11.2.0', '>=' )
		) {
			// PHPUnit >= 11.2: PHPUnit native assertion uses the PHPUnit exceptions.
			$exception = ComparisonMethodDoesNotAcceptParameterTypeException::class;
		}

		$this->expectException( $exception );
		$this->expectExceptionMessage( $msg );

		$actual = new ValueObject( 'test' );
		$this->assertObjectNotEquals( new stdClass(), $actual );
	}

	/**
	 * Verify that the assertObjectNotEquals() method fails a test when a call to method
	 * determines that the objects are not equal.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsOnEqual() {
		$msg = 'Failed asserting that two objects are not equal.';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessage( $msg );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'test' );
		$this->assertObjectNotEquals( $expected, $actual );
	}

	/**
	 * Verify that the assertObjectNotEquals() method fails a test with a custom failure message, when a call
	 * to the method determines that the objects are not equal and the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testAssertObjectNotEqualsFailsAsNotEqualWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that two objects are not equal\.`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$expected = new ValueObject( 'test' );
		$actual   = new ValueObject( 'test' );
		$this->assertObjectNotEquals( $expected, $actual, 'equals', 'This assertion failed for reason XYZ' );
	}
}
