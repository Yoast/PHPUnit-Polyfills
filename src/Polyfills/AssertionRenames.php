<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

/**
 * Polyfill various assertions renamed for readability.
 *
 * Introduced in PHPUnit 9.1.0.
 * The old names were deprecated in PHPUnit 9.1.0 and (will be) removed in PHPUnit 10.0.0.
 *
 * @link https://github.com/sebastianbergmann/phpunit/issues/4061
 * @link https://github.com/sebastianbergmann/phpunit/issues/4062
 * @link https://github.com/sebastianbergmann/phpunit/issues/4063
 * @link https://github.com/sebastianbergmann/phpunit/issues/4064
 * @link https://github.com/sebastianbergmann/phpunit/issues/4065
 * @link https://github.com/sebastianbergmann/phpunit/issues/4066
 * @link https://github.com/sebastianbergmann/phpunit/issues/4067
 * @link https://github.com/sebastianbergmann/phpunit/issues/4068
 * @link https://github.com/sebastianbergmann/phpunit/issues/4069
 * @link https://github.com/sebastianbergmann/phpunit/issues/4070
 * @link https://github.com/sebastianbergmann/phpunit/issues/4071
 * @link https://github.com/sebastianbergmann/phpunit/issues/4072
 * @link https://github.com/sebastianbergmann/phpunit/issues/4073
 * @link https://github.com/sebastianbergmann/phpunit/issues/4074
 * @link https://github.com/sebastianbergmann/phpunit/issues/4075
 * @link https://github.com/sebastianbergmann/phpunit/issues/4076
 * @link https://github.com/sebastianbergmann/phpunit/issues/4077
 * @link https://github.com/sebastianbergmann/phpunit/issues/4078
 * @link https://github.com/sebastianbergmann/phpunit/issues/4079
 * @link https://github.com/sebastianbergmann/phpunit/issues/4080
 * @link https://github.com/sebastianbergmann/phpunit/issues/4081
 * @link https://github.com/sebastianbergmann/phpunit/issues/4082
 * @link https://github.com/sebastianbergmann/phpunit/issues/4083
 * @link https://github.com/sebastianbergmann/phpunit/issues/4084
 * @link https://github.com/sebastianbergmann/phpunit/issues/4085
 * @link https://github.com/sebastianbergmann/phpunit/issues/4086
 * @link https://github.com/sebastianbergmann/phpunit/issues/4087
 * @link https://github.com/sebastianbergmann/phpunit/issues/4088
 * @link https://github.com/sebastianbergmann/phpunit/issues/4089
 * @link https://github.com/sebastianbergmann/phpunit/issues/4090
 *
 * @since 0.1.0
 */
trait AssertionRenames {

	/**
	 * Asserts that a file/dir exists and is not readable.
	 *
	 * @param string $filename Path to the file/directory.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertIsNotReadable( string $filename, string $message = '' ): void {
		static::assertNotIsReadable( $filename, $message );
	}

	/**
	 * Asserts that a file/dir exists and is not writable.
	 *
	 * @param string $filename Path to the file/directory.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertIsNotWritable( string $filename, string $message = '' ): void {
		static::assertNotIsWritable( $filename, $message );
	}

	/**
	 * Asserts that a directory does not exist.
	 *
	 * @param string $directory Path to the directory.
	 * @param string $message   Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertDirectoryDoesNotExist( string $directory, string $message = '' ): void {
		static::assertDirectoryNotExists( $directory, $message );
	}

	/**
	 * Asserts that a directory exists and is not readable.
	 *
	 * @param string $directory Path to the directory.
	 * @param string $message   Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertDirectoryIsNotReadable( string $directory, string $message = '' ): void {
		static::assertDirectoryNotIsReadable( $directory, $message );
	}

	/**
	 * Asserts that a directory exists and is not writable.
	 *
	 * @param string $directory Path to the directory.
	 * @param string $message   Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertDirectoryIsNotWritable( string $directory, string $message = '' ): void {
		static::assertDirectoryNotIsWritable( $directory, $message );
	}

	/**
	 * Asserts that a file does not exist.
	 *
	 * @param string $filename Path to the file.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertFileDoesNotExist( string $filename, string $message = '' ): void {
		static::assertFileNotExists( $filename, $message );
	}

	/**
	 * Asserts that a file exists and is not readable.
	 *
	 * @param string $file    Path to the file.
	 * @param string $message Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertFileIsNotReadable( string $file, string $message = '' ): void {
		static::assertFileNotIsReadable( $file, $message );
	}

	/**
	 * Asserts that a file exists and is not writable.
	 *
	 * @param string $file    Path to the file.
	 * @param string $message Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertFileIsNotWritable( string $file, string $message = '' ): void {
		static::assertFileNotIsWritable( $file, $message );
	}

	/**
	 * Asserts that a string matches a given regular expression.
	 *
	 * @param string $pattern Regular expression pattern.
	 * @param string $string  String to match against the regular expression.
	 * @param string $message Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertMatchesRegularExpression( string $pattern, string $string, string $message = '' ): void {
		static::assertRegExp( $pattern, $string, $message );
	}

	/**
	 * Asserts that a string does not match a given regular expression.
	 *
	 * @param string $pattern Regular expression pattern.
	 * @param string $string  String to match against the regular expression.
	 * @param string $message Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertDoesNotMatchRegularExpression( string $pattern, string $string, string $message = '' ): void {
		static::assertNotRegExp( $pattern, $string, $message );
	}
}
