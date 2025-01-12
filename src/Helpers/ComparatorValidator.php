<?php

namespace Yoast\PHPUnitPolyfills\Helpers;

use ReflectionNamedType;
use ReflectionObject;
use Yoast\PHPUnitPolyfills\Exceptions\InvalidComparisonMethodException;

/**
 * Helper functions for validating a comparator method complies with the requirements set by PHPUnit.
 *
 * ---------------------------------------------------------------------------------------------
 * This class is only intended for internal use by PHPUnit Polyfills and is not part of the public API.
 * This also means that it has no promise of backward compatibility.
 *
 * End-users should use the {@see \Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals} and/or the
 * {@see \Yoast\PHPUnitPolyfills\Polyfills\AssertObjectNotEquals} trait instead.
 * ---------------------------------------------------------------------------------------------
 *
 * @internal
 *
 * @since 3.0.0
 */
final class ComparatorValidator {

	/**
	 * Asserts that a custom object comparison method complies with the requirements set by PHPUnit.
	 *
	 * The custom comparator method is expected to have the following method
	 * signature: `equals(self $other): bool` (or similar with a different method name).
	 *
	 * Basically, this method checks the following:
	 * - A method with name $method must exist on the $actual object.
	 * - The method must accept exactly one argument and this argument must be required.
	 * - This parameter must have a classname-based declared type.
	 * - The $expected object must be compatible with this declared type.
	 * - The method must have a declared bool return type.
	 *
	 * {@internal Type validation for the parameters should be done in the calling function.}
	 *
	 * @param object $expected Expected value.
	 *                         This object should comply with the type requirement set by the parameter type
	 *                         of the comparator method on $actual.
	 * @param object $actual   The object on which the comparator method should exist.
	 * @param string $method   The name of the comparator method expected within the object.
	 *
	 * @return void
	 *
	 * @throws InvalidComparisonMethodException When the comparator method does not comply with the requirements.
	 */
	public static function isValid( $expected, $actual, string $method = 'equals' ): void {
		/*
		 * Verify the method exists.
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

		if ( ( $returnType instanceof ReflectionNamedType ) === false ) {
			throw new InvalidComparisonMethodException( $returnTypeError );
		}

		if ( $returnType->allowsNull() === true ) {
			throw new InvalidComparisonMethodException( $returnTypeError );
		}

		if ( $returnType->getName() !== 'bool' ) {
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
		if ( ( $type instanceof ReflectionNamedType ) === false ) {
			throw new InvalidComparisonMethodException( $noDeclaredTypeError );
		}

		$typeName = $type->getName();

		/*
		 * Validate that the $expected object complies with the declared parameter type.
		 */
		if ( $typeName === 'self' ) {
			$typeName = \get_class( $actual );
		}

		if ( ( $expected instanceof $typeName ) === false ) {
			throw new InvalidComparisonMethodException( $notAcceptableTypeError );
		}
	}
}
