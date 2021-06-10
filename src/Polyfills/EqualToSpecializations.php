<?php


namespace Yoast\PHPUnitPolyfills\Polyfills;

/**
 * Polyfill the Assert::equalToCanonicalizing(), Assert::equalToIgnoringCase() and
 * Assert::equalToWithDelta(), which replace the use of Assert::equalTo()
 * with these optional parameters.
 *
 * Introduced in PHPUnit 9.0.0.
 * Use of Assert::equalTo() with these respective optional parameters was
 * never deprecated but leads to unexpected behaviour as they are ignored in PHPUnit 9.0.0.
 */
trait EqualToSpecializations {

	public static function equalToCanonicalizing( $value ) {
		return static::equalTo( $value, 0.0, 10, true, false );
	}

	public static function equalToIgnoringCase( $value ) {
		return static::equalTo( $value, 0.0, 10, false, true );
	}

	public static function equalToWithDelta( $value, $delta ) {
		return static::equalTo( $value, $delta, 10, false, false );
	}
}
