<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

use Yoast\PHPUnitPolyfills\Helpers\ResourceHelper;

/**
 * Polyfill the Assert::assertIsClosedResource() and Assert::assertIsNotClosedResource() methods.
 *
 * Introduced in PHPUnit 9.3.0.
 *
 * @link https://github.com/sebastianbergmann/phpunit/issues/4276
 * @link https://github.com/sebastianbergmann/phpunit/pull/4365
 */
trait AssertClosedResource {

	/**
	 * Asserts that a variable is of type resource and is closed.
	 *
	 * @param mixed  $actual  The variable to test.
	 * @param string $message Optional failure message to display.
	 *
	 * @return void
	 */
	public static function assertIsClosedResource( $actual, $message = '' ) {
		if ( $message === '' ) {
			$message = \sprintf( 'Failed asserting that %s is of type "resource (closed)"', \var_export( $actual, true ) );
		}

		static::assertTrue( ResourceHelper::isClosedResource( $actual ), $message );
	}

	/**
	 * Asserts that a variable is not of type resource or is an open resource.
	 *
	 * @param mixed  $actual  The variable to test.
	 * @param string $message Optional failure message to display.
	 *
	 * @return void
	 */
	public static function assertIsNotClosedResource( $actual, $message = '' ) {
		if ( $message === '' ) {
			$message = \sprintf( 'Failed asserting that %s is not of type "resource (closed)"', \var_export( $actual, true ) );
		}

		static::assertFalse( ResourceHelper::isClosedResource( $actual ), $message );
	}
}
