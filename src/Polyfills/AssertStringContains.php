<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

/**
 * Polyfill the Assert::assertStringContainsString() et al methods, which replace the use of
 * Assert::assertContains() and Assert::assertNotContains() with string haystacks.
 *
 * Introduced in PHPUnit 7.5.0.
 * Use of Assert::assertContains() and Assert::assertNotContains() with string haystacks was
 * deprecated in PHPUnit 7.5.0 and removed in PHPUnit 9.0.0.
 *
 * @link https://github.com/sebastianbergmann/phpunit/issues/3422
 */
trait AssertStringContains {

	/**
	 * Asserts that a string haystack contains a needle.
	 *
	 * @param string $needle   The string to search for.
	 * @param string $haystack The string to treat as the haystack.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 */
	public static function assertStringContainsString( $needle, $haystack, $message = '' ) {
		// Replicate fix added to PHPUnit 6.4.2.
		if ( self::needsEmptyStringFix( $needle, false ) ) {
			self::markTestSkipped( 'Asserting a string contains an empty string, which always "exists" in any other string.');
		}

		static::assertContains( $needle, $haystack, $message );
	}

	/**
	 * Asserts that a string haystack contains a needle (case-insensitive).
	 *
	 * @param string $needle   The string to search for.
	 * @param string $haystack The string to treat as the haystack.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 */
	public static function assertStringContainsStringIgnoringCase( $needle, $haystack, $message = '' ) {
		// Replicate fix added to PHPUnit 6.4.2.
		if ( self::needsEmptyStringFix( $needle, false ) ) {
			self::markTestSkipped( 'Asserting a string contains an empty string, which always "exists" in any other string.');
		}

		static::assertContains( $needle, $haystack, $message, true );
	}

	/**
	 * Asserts that a string haystack does NOT contain a needle.
	 *
	 * @param string $needle   The string to search for.
	 * @param string $haystack The string to treat as the haystack.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 */
	public static function assertStringNotContainsString( $needle, $haystack, $message = '' ) {
		// Replicate fix added to PHPUnit 6.4.2.
		if ( self::needsEmptyStringFix( $needle, true ) ) {
			self::markTestSkipped( 'Asserting a string contains an empty string, which always "exists" in any other string.');
		}

		static::assertNotContains( $needle, $haystack, $message );
	}

	/**
	 * Asserts that a string haystack does NOT contain a needle (case-insensitive).
	 *
	 * @param string $needle   The string to search for.
	 * @param string $haystack The string to treat as the haystack.
	 * @param string $message  Optional failure message to display.
	 *
	 * @return void
	 */
	public static function assertStringNotContainsStringIgnoringCase( $needle, $haystack, $message = '' ) {
		// Replicate fix added to PHPUnit 6.4.2.
		if ( self::needsEmptyStringFix( $needle, true ) ) {
			self::markTestSkipped( 'Asserting a string contains an empty string, which always "exists" in any other string.');
		}

		static::assertNotContains( $needle, $haystack, $message, true );
	}

	/**
	 * Decide if a fix for an empty needle string is needed.
	 *
	 * PHPUnit 6.4.2 added a fix to gracefully handle the case when an empty string was passed to
	 * `assertStringContainsString()` and variant assertions. Versions earlier than that gave a "mb_strpos(): Empty
	 * delimiter" error instead.
	 *
	 * If the needle string is empty, and the PHPUnit version is found to be lower than 6.4.2, or 6.4.2 or above and
	 * part of a NotContains assertion, then return true, which will result in tests marked as skipped.
	 *
	 * To not have tests marked as skipped, test authors should ensure the needle string
	 * passed to the assertion is not empty.
	 *
	 * @param string $needle_string String that should be looked for in haystack string.
	 * @param bool   $is_negative   Whether assertion is negative i.e. NotContains
	 *
	 * @return bool True unless the needle string is empty, or PHPUnit is 6.4.2 or later, or
	 *              PHPUnit version can't be identified.
	 */
	protected static function needsEmptyStringFix( $needle_string, $is_negative ) {
		if ( '' !== $needle_string ) {
			return false;
		}

		$phpunit_version = '';
		if ( class_exists( 'PHPUnit\Runner\Version' ) ) {
			$phpunit_version = \PHPUnit\Runner\Version::id();
		} elseif ( class_exists( 'PHPUnit_Runner_Version' ) ) {
			$phpunit_version = \PHPUnit_Runner_Version::id();
		}

		// If the version can't be identified, assume everything is good.
		if ( '' === $phpunit_version ) {
			return false;
		}

		if ( ! $is_negative && version_compare( $phpunit_version, '6.4.2', '>=' ) ) {
			return false;
		}

		return true;
	}
}
