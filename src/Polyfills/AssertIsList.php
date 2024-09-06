<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

use PHPUnit\Framework\Assert;
use ReflectionObject;

/**
 * Polyfill the Assert::assertIsList() method.
 *
 * Introduced in PHPUnit 10.0.0.
 *
 * @link https://github.com/sebastianbergmann/phpunit/pull/4818
 *
 * @since 2.0.0
 */
trait AssertIsList {

	/**
	 * Asserts that an array is list.
	 *
	 * @param mixed  $array   The value to test.
	 * @param string $message Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertIsList( $array, $message = '' ) {
		$msg = self::assertIsListFailureDescription( $array );
		if ( $message !== '' ) {
			$msg = $message . \PHP_EOL . $msg;
		}

		if ( \is_array( $array ) === false ) {
			if ( \method_exists( Assert::class, 'assertIsArray' ) ) {
				static::assertIsArray( $array, $msg );
				return;
			}

			static::assertInternalType( 'array', $array, $msg );
			return;
		}

		if ( $array === [] ) {
			static::assertSame( $array, $array, $msg );
			return;
		}

		if ( \function_exists( 'array_is_list' ) ) {
			// phpcs:ignore PHPCompatibility.FunctionUse.NewFunctions.array_is_listFound -- PHP 8.1+.
			static::assertTrue( \array_is_list( $array ), $msg );
			return;
		}

		$expected = \range( 0, ( \count( $array ) - 1 ) );

		static::assertSame( $expected, \array_keys( $array ), $msg );
	}

	/**
	 * Returns the description of the failure.
	 *
	 * @param mixed $value The value under test.
	 *
	 * @return string
	 */
	private static function assertIsListFailureDescription( $value ) {
		$message = 'Failed asserting that %s is a list.';

		if ( \is_object( $value ) ) {
			// Improved error message as per upstream since PHPUnit 11.3.1.
			$reflector   = new ReflectionObject( $value );
			$description = 'an instance of class ' . $reflector->getName();

			if ( $reflector->isAnonymous() ) {
				$name   = \str_replace( 'class@anonymous', '', $reflector->getName() );
				$length = \strpos( $name, '$' );
				if ( \is_int( $length ) ) {
					$name = \substr( $name, 0, $length );
				}

				$description = 'an instance of anonymous class created at ' . $name;
			}

			return \sprintf( $message, $description );
		}

		$type = \strtolower( \gettype( $value ) );

		switch ( $type ) {
			case 'double':
				$description = 'a float';
				break;

			case 'resource (closed)':
				$description = 'a closed resource';
				break;

			case 'array':
			case 'integer':
				$description = 'an ' . $type;
				break;

			case 'boolean':
			case 'closed resource':
			case 'float':
			case 'resource':
			case 'string':
				$description = 'a ' . $type;
				break;

			case 'null':
				$description = 'null';
				break;

			default:
				$description = 'a value of ' . $type;
				break;
		}

		return \sprintf( $message, $description );
	}
}
