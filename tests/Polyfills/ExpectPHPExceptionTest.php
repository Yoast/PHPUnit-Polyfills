<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectPHPException;

/**
 * Availability test for the functions polyfilled by the ExpectPHPException trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\ExpectPHPException
 */
final class ExpectPHPExceptionTest extends TestCase {

	use ExpectException; // Needed for PHPUnit < 5.2.0 support.
	use ExpectPHPException;

	/**
	 * Verify availability of the expectDeprecation*() methods.
	 *
	 * @return void
	 */
	public function testDeprecationCanBeExpected() {
		$this->expectDeprecation();
		$this->expectDeprecationMessage( 'foo' );
		$this->expectDeprecationMessageMatches( '/foo/' );

		\trigger_error( 'foo', \E_USER_DEPRECATED );
	}

	/**
	 * Verify availability of the expectNotice*() methods.
	 *
	 * @return void
	 */
	public function testNoticeCanBeExpected() {
		$this->expectNotice();
		$this->expectNoticeMessage( 'foo' );
		$this->expectNoticeMessageMatches( '/foo/' );

		\trigger_error( 'foo', \E_USER_NOTICE );
	}

	/**
	 * Verify availability of the expectWarning*() methods.
	 *
	 * @return void
	 */
	public function testWarningCanBeExpected() {
		$this->expectWarning();
		$this->expectWarningMessage( 'foo' );
		$this->expectWarningMessageMatches( '/foo/' );

		\trigger_error( 'foo', \E_USER_WARNING );
	}

	/**
	 * Verify availability of the expectError*() methods.
	 *
	 * @requires PHP < 9.0
	 *
	 * @return void
	 */
	public function testErrorCanBeExpected() {
		$this->expectError();
		$this->expectErrorMessage( 'foo' );
		$this->expectErrorMessageMatches( '/foo/' );

		if ( \PHP_VERSION_ID < 80400 ) {
			\trigger_error( 'foo', \E_USER_ERROR );
		}
		else {
			// PHP 8.4 deprecates passing `E_USER_ERROR` to `trigger_error()`.
			// Silence the deprecation notice (but not the error itself).
			// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
			@\trigger_error( 'foo', \E_USER_ERROR );
		}
	}
}
