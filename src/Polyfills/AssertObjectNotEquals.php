<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

use TypeError;
use Yoast\PHPUnitPolyfills\Exceptions\InvalidComparisonMethodException;
use Yoast\PHPUnitPolyfills\Helpers\ComparatorValidator;

/**
 * Polyfill the Assert::assertObjectNotEquals() method.
 *
 * Introduced in PHPUnit 11.2.0.
 *
 * The polyfill implementation closely matches the PHPUnit native implementation with the exception
 * of the thrown exceptions.
 *
 * @link https://github.com/sebastianbergmann/phpunit/issues/5811
 * @link https://github.com/sebastianbergmann/phpunit/commit/8e3b7c18506312df0676f2e079c414cc56b49f69
 *
 * @since 3.0.0
 */
trait AssertObjectNotEquals {

	/**
	 * Asserts that two objects are considered _not_ equal based on a custom object comparison
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
	final public static function assertObjectNotEquals( $expected, $actual, string $method = 'equals', string $message = '' ): void {
		/*
		 * Parameter input validation.
		 * In PHPUnit this is done via PHP native type declarations. Emulating this for the polyfill.
		 */
		if ( \is_object( $expected ) === false ) {
			throw new TypeError(
				\sprintf(
					'Argument 1 passed to assertObjectNotEquals() must be an object, %s given',
					\gettype( $expected )
				)
			);
		}

		if ( \is_object( $actual ) === false ) {
			throw new TypeError(
				\sprintf(
					'Argument 2 passed to assertObjectNotEquals() must be an object, %s given',
					\gettype( $actual )
				)
			);
		}

		/*
		 * Validate the comparator method requirements.
		 *
		 * If the method does not validate, an InvalidComparisonMethodException is thrown,
		 * which will cause the test to error out.
		 */
		try {
			ComparatorValidator::isValid( $expected, $actual, $method );
		} catch ( InvalidComparisonMethodException $e ) {
			// Rethrow to ensure a stack trace shows the exception comes from this method, not the helper.
			throw $e;
		}

		/*
		 * Execute the comparator method.
		 */
		$result = $actual->{$method}( $expected );

		$msg = \sprintf(
			'Failed asserting that two objects are not equal. The objects are equal according to %s::%s()',
			\get_class( $actual ),
			$method
		);

		if ( $message !== '' ) {
			$msg = $message . \PHP_EOL . $msg;
		}

		static::assertFalse( $result, $msg );
	}
}
