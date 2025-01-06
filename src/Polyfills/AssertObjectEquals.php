<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

use TypeError;
use Yoast\PHPUnitPolyfills\Exceptions\InvalidComparisonMethodException;
use Yoast\PHPUnitPolyfills\Helpers\ComparatorValidator;

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
 *
 * @since 1.0.0
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
