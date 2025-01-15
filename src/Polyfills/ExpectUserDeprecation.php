<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

use PHPUnit\Framework\Error\Deprecated;
use PHPUnit\Framework\TestCase;

/**
 * Polyfill the TestCase::expectUserDeprecationMessage() and the TestCase::expectUserDeprecationMessageMatches() methods.
 *
 * Introduced in PHPUnit 11.0.0.
 *
 * Note: PHPUnit 10 is not and will not be supported for these polyfills.
 *
 * @link https://github.com/sebastianbergmann/phpunit/pull/5605
 *
 * @since 3.0.0
 */
trait ExpectUserDeprecation {

	/**
	 * Set expectation for the message when receiving a user defined deprecation notice.
	 *
	 * @param string $expectedUserDeprecationMessage The message to expect.
	 *
	 * @return void
	 */
	final protected function expectUserDeprecationMessage( string $expectedUserDeprecationMessage ): void {
		if ( \method_exists( TestCase::class, 'expectDeprecationMessage' ) ) {
			// PHPUnit 8.4.0 - 9.x.
			$this->expectDeprecation();
			$this->expectDeprecationMessage( $expectedUserDeprecationMessage );
			return;
		}

		// PHPUnit < 8.4.0.
		$this->expectException( Deprecated::class );
		$this->expectExceptionMessage( $expectedUserDeprecationMessage );
	}

	/**
	 * Set expectation for the message when receiving a user defined deprecation notice (regex based).
	 *
	 * @param string $expectedUserDeprecationMessageRegularExpression A regular expression which must match the message.
	 *
	 * @return void
	 */
	final protected function expectUserDeprecationMessageMatches( string $expectedUserDeprecationMessageRegularExpression ): void {
		if ( \method_exists( TestCase::class, 'expectDeprecationMessageMatches' ) ) {
			// PHPUnit 8.4.0 - 9.x.
			$this->expectDeprecation();
			$this->expectDeprecationMessageMatches( $expectedUserDeprecationMessageRegularExpression );
			return;
		}

		// PHPUnit < 8.4.0.
		$this->expectException( Deprecated::class );
		$this->expectExceptionMessageRegExp( $expectedUserDeprecationMessageRegularExpression );
	}
}
