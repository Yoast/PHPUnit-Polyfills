<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

use ReflectionNamedType;
use ReflectionObject;
use ReflectionType;
use TypeError;
use Yoast\PHPUnitPolyfills\Exceptions\InvalidComparisonMethodException;

/**
 * Polyfill the Assert::assertObjectEquals() methods.
 *
 * Introduced in PHPUnit 9.4.0.
 *
 * The polyfill implementation closely matches the PHPUnit native implementation with the exception
 * of the thrown exceptions.
 *
 * @link https://github.com/sebastianbergmann/phpunit/issues/4467
 * @link https://github.com/sebastianbergmann/phpunit/issues/4707
 * @link https://github.com/sebastianbergmann/phpunit/commit/1dba8c3a4b2dd04a3ff1869f75daaeb6757a14ee
 * @link https://github.com/sebastianbergmann/phpunit/commit/6099c5eefccfda860c889f575d58b5fe6cc10c83
 */
trait AssertObjectEquals {

	/**
	 * Asserts that two objects are considered equal based on a custom object comparison
	 * using a comparator method in the target object.
	 *
	 * The custom comparator method is expected to have the following method
	 * signature: `equals(self $other): bool` (or similar with a different method name).
	 *
	 * Basically, the assertion checks the following:
	 * - A method with name $method must exist on the $actual object.
	 * - The method must accept exactly one argument and this argument must be required.
	 * - This parameter must have a classname-based declared type.
	 * - The $expected object must be compatible with this declared type.
	 * - The method must have a declared bool return type.
	 *
	 * @param object $expected Expected value.
	 * @param object $actual   The value to test.
	 * @param string $method   The name of the comparator method within the object.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 *
	 * @throws TypeError                        When any of the passed arguments do not meet the required type.
	 * @throws InvalidComparisonMethodException When the comparator method does not comply with the requirements.
	 */
	final public static function assertObjectEquals( $expected, $actual, $method = 'equals', $message = '' ) {
		/*
		 * Parameter input validation.
		 * In PHPUnit this is done via PHP native type declarations. Emulating this for the polyfill.
		 */
		if ( \is_object( $expected ) === false ) {
			throw new TypeError(
				\sprintf(
					'Argument 1 passed to assertObjectEquals() must be an object, %s given',
					\gettype( $expected )
				)
			);
		}

		if ( \is_object( $actual ) === false ) {
			throw new TypeError(
				\sprintf(
					'Argument 2 passed to assertObjectEquals() must be an object, %s given',
					\gettype( $actual )
				)
			);
		}

		if ( \is_scalar( $method ) === false ) {
			throw new TypeError(
				\sprintf(
					'Argument 3 passed to assertObjectEquals() must be of the type string, %s given',
					\gettype( $method )
				)
			);
		}
		else {
			$method = (string) $method;
		}

		/*
		 * Comparator method validation.
		 */
		$reflObject = new ReflectionObject( $actual );

		if ( $reflObject->hasMethod( $method ) === false ) {
			throw new InvalidComparisonMethodException(
				\sprintf(
					'Comparison method %s::%s() does not exist.',
					\get_class( $actual ),
					$method
				)
			);
		}

		$reflMethod = $reflObject->getMethod( $method );

		/*
		 * Comparator method return type requirements validation.
		 */
		$returnTypeError = \sprintf(
			'Comparison method %s::%s() does not declare bool return type.',
			\get_class( $actual ),
			$method
		);

		if ( $reflMethod->hasReturnType() === false ) {
			throw new InvalidComparisonMethodException( $returnTypeError );
		}

		$returnType = $reflMethod->getReturnType();

		if ( \class_exists( 'ReflectionNamedType' ) ) {
			// PHP >= 7.1: guard against union/intersection return types.
			if ( ( $returnType instanceof ReflectionNamedType ) === false ) {
				throw new InvalidComparisonMethodException( $returnTypeError );
			}
		}
		elseif ( ( $returnType instanceof ReflectionType ) === false ) {
			/*
			 * PHP 7.0.
			 * Checking for `ReflectionType` will not throw an error on union types,
			 * but then again union types are not supported on PHP 7.0.
			 */
			throw new InvalidComparisonMethodException( $returnTypeError );
		}

		if ( $returnType->allowsNull() === true ) {
			throw new InvalidComparisonMethodException( $returnTypeError );
		}

		if ( \method_exists( $returnType, 'getName' ) ) {
			// PHP 7.1+.
			if ( $returnType->getName() !== 'bool' ) {
				throw new InvalidComparisonMethodException( $returnTypeError );
			}
		}
		elseif ( (string) $returnType !== 'bool' ) {
			// PHP 7.0.
			throw new InvalidComparisonMethodException( $returnTypeError );
		}

		/*
		 * Comparator method parameter requirements validation.
		 */
		if ( $reflMethod->getNumberOfParameters() !== 1
			|| $reflMethod->getNumberOfRequiredParameters() !== 1
		) {
			throw new InvalidComparisonMethodException(
				\sprintf(
					'Comparison method %s::%s() does not declare exactly one parameter.',
					\get_class( $actual ),
					$method
				)
			);
		}

		$noDeclaredTypeError = \sprintf(
			'Parameter of comparison method %s::%s() does not have a declared type.',
			\get_class( $actual ),
			$method
		);

		$notAcceptableTypeError = \sprintf(
			'%s is not an accepted argument type for comparison method %s::%s().',
			\get_class( $expected ),
			\get_class( $actual ),
			$method
		);

		$reflParameter = $reflMethod->getParameters()[0];

		$hasType = $reflParameter->hasType();
		if ( $hasType === false ) {
			throw new InvalidComparisonMethodException( $noDeclaredTypeError );
		}

		$type = $reflParameter->getType();
		if ( \class_exists( 'ReflectionNamedType' ) ) {
			// PHP >= 7.1.
			if ( ( $type instanceof ReflectionNamedType ) === false ) {
				throw new InvalidComparisonMethodException( $noDeclaredTypeError );
			}

			$typeName = $type->getName();
		}
		else {
			/*
			 * PHP 7.0.
			 * Checking for `ReflectionType` will not throw an error on union types,
			 * but then again union types are not supported on PHP 7.0.
			 */
			if ( ( $type instanceof ReflectionType ) === false ) {
				throw new InvalidComparisonMethodException( $noDeclaredTypeError );
			}

			$typeName = (string) $type;
		}

		/*
		 * Validate that the $expected object complies with the declared parameter type.
		 */
		if ( $typeName === 'self' ) {
			$typeName = \get_class( $actual );
		}

		if ( ( $expected instanceof $typeName ) === false ) {
			throw new InvalidComparisonMethodException( $notAcceptableTypeError );
		}

		/*
		 * Execute the comparator method.
		 */
		$result = $actual->{$method}( $expected );

		$msg = \sprintf(
			'Failed asserting that two objects are equal. The objects are not equal according to %s::%s()',
			\get_class( $actual ),
			$method
		);

		if ( $message !== '' ) {
			$msg = $message . \PHP_EOL . $msg;
		}

		static::assertTrue( $result, $msg );
	}
}
