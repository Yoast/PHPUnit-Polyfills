<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

/**
 * Polyfill the `Assert::assertFileEqualsCanonicalizing()`, `Assert::assertFileEqualsIgnoringCase()`,
 * `Assert::assertStringEqualsFileCanonicalizing()`, `Assert::assertStringEqualsFileIgnoringCase()`,
 * `Assert::assertFileNotEqualsCanonicalizing()`, `Assert::assertFileNotEqualsIgnoringCase()`,
 * `Assert::assertStringNotEqualsFileCanonicalizing()` and `Assert::assertStringNotEqualsFileIgnoringCase()`
 * as alternative to using `Assert::assertFileEquals()` etc. with optional parameters
 *
 * Introduced in PHPUnit 8.5.0.
 * Use of Assert::assertFileEquals() and Assert::assertFileNotEquals() with these optional parameters was
 * deprecated in PHPUnit 8.5.0 and removed in PHPUnit 9.0.0.
 *
 * @link https://github.com/sebastianbergmann/phpunit/issues/3949
 * @link https://github.com/sebastianbergmann/phpunit/issues/3951
 *
 * @since 0.1.0
 */
trait AssertFileEqualsSpecializations {

	/**
	 * Asserts that the contents of one file is equal to the contents of another
	 * file (canonicalizing).
	 *
	 * @param string $expected Path to file with expected content.
	 * @param string $actual   Path to file with actual content.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertFileEqualsCanonicalizing( string $expected, string $actual, string $message = '' ): void {
		static::assertFileEquals( $expected, $actual, $message, true );
	}

	/**
	 * Asserts that the contents of one file is equal to the contents of another
	 * file (ignoring case).
	 *
	 * @param string $expected Path to file with expected content.
	 * @param string $actual   Path to file with actual content.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertFileEqualsIgnoringCase( string $expected, string $actual, string $message = '' ): void {
		static::assertFileEquals( $expected, $actual, $message, false, true );
	}

	/**
	 * Asserts that the contents of one file is not equal to the contents of another
	 * file (canonicalizing).
	 *
	 * @param string $expected Path to file with expected content.
	 * @param string $actual   Path to file with actual content.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertFileNotEqualsCanonicalizing( string $expected, string $actual, string $message = '' ): void {
		static::assertFileNotEquals( $expected, $actual, $message, true );
	}

	/**
	 * Asserts that the contents of one file is not equal to the contents of another
	 * file (ignoring case).
	 *
	 * @param string $expected Path to file with expected content.
	 * @param string $actual   Path to file with actual content.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertFileNotEqualsIgnoringCase( string $expected, string $actual, string $message = '' ): void {
		static::assertFileNotEquals( $expected, $actual, $message, false, true );
	}

	/**
	 * Asserts that the contents of a string is equal to the contents of
	 * a file (canonicalizing).
	 *
	 * @param string $expectedFile Path to file with expected content.
	 * @param string $actualString Actual content.
	 * @param string $message      Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertStringEqualsFileCanonicalizing( string $expectedFile, string $actualString, string $message = '' ): void {
		static::assertStringEqualsFile( $expectedFile, $actualString, $message, true );
	}

	/**
	 * Asserts that the contents of a string is equal to the contents of
	 * a file (ignoring case).
	 *
	 * @param string $expectedFile Path to file with expected content.
	 * @param string $actualString Actual content.
	 * @param string $message      Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertStringEqualsFileIgnoringCase( string $expectedFile, string $actualString, string $message = '' ): void {
		static::assertStringEqualsFile( $expectedFile, $actualString, $message, false, true );
	}

	/**
	 * Asserts that the contents of a string is not equal to the contents of
	 * a file (canonicalizing).
	 *
	 * @param string $expectedFile Path to file with expected content.
	 * @param string $actualString Actual content.
	 * @param string $message      Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertStringNotEqualsFileCanonicalizing( string $expectedFile, string $actualString, string $message = '' ): void {
		static::assertStringNotEqualsFile( $expectedFile, $actualString, $message, true );
	}

	/**
	 * Asserts that the contents of a string is not equal to the contents of
	 * a file (ignoring case).
	 *
	 * @param string $expectedFile Path to file with expected content.
	 * @param string $actualString Actual content.
	 * @param string $message      Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertStringNotEqualsFileIgnoringCase( string $expectedFile, string $actualString, string $message = '' ): void {
		static::assertStringNotEqualsFile( $expectedFile, $actualString, $message, false, true );
	}
}
