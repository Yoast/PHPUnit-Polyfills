<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

/**
 * Polyfill the Assert::assertArrayIsEqualToArrayOnlyConsideringListOfKeys(),
 * Assert::assertArrayIsEqualToArrayIgnoringListOfKeys(),
 * Assert::assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys(),
 * and Assert::assertArrayIsIdenticalToArrayIgnoringListOfKeys() methods.
 *
 * Introduced in PHPUnit 11.0.0.
 *
 * This functionality resembles the functionality previously offered by the `Assert::assertArraySubset()`
 * assertion, which was removed in PHPUnit 9.0.0, but with higher precision.
 *
 * Refactoring tests which still use `Assert::assertArraySubset()` to use the new assertions should be
 * considered as an upgrade path.
 *
 * @link https://github.com/sebastianbergmann/phpunit/pull/5600
 * @link https://github.com/sebastianbergmann/phpunit/pull/5716 Included in PHPUnit 11.0.4.
 * @link https://github.com/sebastianbergmann/phpunit/pull/5729 Included in PHPUnit 11.0.6.
 *
 * @since 3.0.0
 */
trait AssertArrayWithListKeys {

	/**
	 * Asserts that two arrays are equal while only considering array elements for which the keys have been specified.
	 *
	 * {@internal As the array type declarations don't lead to type juggling, even without strict_types,
	 * it is safe to let PHP handle the parameter validation.}
	 *
	 * @param array<mixed>      $expected           Expected value.
	 * @param array<mixed>      $actual             The variable to test.
	 * @param array<int|string> $keysToBeConsidered The array keys to take into account.
	 * @param string            $message            Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertArrayIsEqualToArrayOnlyConsideringListOfKeys( array $expected, array $actual, array $keysToBeConsidered, string $message = '' ): void {
		$filteredExpected = [];
		foreach ( $keysToBeConsidered as $key ) {
			if ( isset( $expected[ $key ] ) ) {
				$filteredExpected[ $key ] = $expected[ $key ];
			}
		}

		$filteredActual = [];
		foreach ( $keysToBeConsidered as $key ) {
			if ( isset( $actual[ $key ] ) ) {
				$filteredActual[ $key ] = $actual[ $key ];
			}
		}

		static::assertEquals( $filteredExpected, $filteredActual, $message );
	}

	/**
	 * Asserts that two arrays are equal while ignoring array elements for which the keys have been specified.
	 *
	 * {@internal As the array type declarations don't lead to type juggling, even without strict_types,
	 * it is safe to let PHP handle the parameter validation.}
	 *
	 * @param array<mixed>      $expected        Expected value.
	 * @param array<mixed>      $actual          The variable to test.
	 * @param array<int|string> $keysToBeIgnored The array keys to ignore.
	 * @param string            $message         Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertArrayIsEqualToArrayIgnoringListOfKeys( array $expected, array $actual, array $keysToBeIgnored, string $message = '' ): void {
		foreach ( $keysToBeIgnored as $key ) {
			unset( $expected[ $key ], $actual[ $key ] );
		}

		static::assertEquals( $expected, $actual, $message );
	}

	/**
	 * Asserts that two arrays are identical while only considering array elements for which the keys have been specified.
	 *
	 * {@internal As the array type declarations don't lead to type juggling, even without strict_types,
	 * it is safe to let PHP handle the parameter validation.}
	 *
	 * @param array<mixed>      $expected           Expected value.
	 * @param array<mixed>      $actual             The variable to test.
	 * @param array<int|string> $keysToBeConsidered The array keys to take into account.
	 * @param string            $message            Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertArrayIsIdenticalToArrayOnlyConsideringListOfKeys( array $expected, array $actual, array $keysToBeConsidered, string $message = '' ): void {
		$keysToBeConsidered = \array_combine( $keysToBeConsidered, $keysToBeConsidered );
		$expected           = \array_intersect_key( $expected, $keysToBeConsidered );
		$actual             = \array_intersect_key( $actual, $keysToBeConsidered );

		static::assertSame( $expected, $actual, $message );
	}

	/**
	 * Asserts that two arrays are identical while ignoring array elements for which the keys have been specified.
	 *
	 * {@internal As the array type declarations don't lead to type juggling, even without strict_types,
	 * it is safe to let PHP handle the parameter validation.}
	 *
	 * @param array<mixed>      $expected        Expected value.
	 * @param array<mixed>      $actual          The variable to test.
	 * @param array<int|string> $keysToBeIgnored The array keys to ignore.
	 * @param string            $message         Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertArrayIsIdenticalToArrayIgnoringListOfKeys( array $expected, array $actual, array $keysToBeIgnored, string $message = '' ): void {
		foreach ( $keysToBeIgnored as $key ) {
			unset( $expected[ $key ], $actual[ $key ] );
		}

		static::assertSame( $expected, $actual, $message );
	}
}
