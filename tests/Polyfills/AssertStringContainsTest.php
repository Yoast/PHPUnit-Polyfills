<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * Availability test for the functions polyfilled by the AssertStringContains trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains
 */
final class AssertStringContainsTest extends TestCase {

	use AssertStringContains;
	use ExpectException; // Needed for PHPUnit < 5.2.0 support.
	use ExpectExceptionMessageMatches;

	/**
	 * Verify availability of the assertStringContainsString() method.
	 *
	 * @return void
	 */
	public function testAssertStringContainsString() {
		$this->assertStringContainsString( 'foo', 'foobar' );
	}

	/**
	 * Verify availability of the assertStringContainsStringIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertStringContainsStringIgnoringCase() {
		self::assertStringContainsStringIgnoringCase( 'Foo', 'foobar' );
	}

	/**
	 * Verify availability of the assertStringNotContainsString() method.
	 *
	 * @return void
	 */
	public function testAssertStringNotContainsString() {
		self::assertStringNotContainsString( 'Foo', 'foobar' );
	}

	/**
	 * Verify availability of the assertStringNotContainsStringIgnoringCase() method.
	 *
	 * @return void
	 */
	public function testAssertStringNotContainsStringIgnoringCase() {
		$this->assertStringNotContainsStringIgnoringCase( 'Baz', 'foobar' );
	}

	/**
	 * Verify that the assertStringContainsString() method does not throw a mb_strpos()
	 * PHP error when passed an empty $needle.
	 *
	 * This was possible due to a bug which existed in PHPUnit < 6.4.2.
	 *
	 * @link https://github.com/Yoast/PHPUnit-Polyfills/issues/17
	 * @link https://github.com/sebastianbergmann/phpunit/pull/2778/
	 *
	 * @dataProvider dataHaystacks
	 *
	 * @param string $haystack Haystack.
	 *
	 * @return void
	 */
	public function testAssertStringContainsStringEmptyNeedle( $haystack ) {
		$this->assertStringContainsString( '', $haystack );
	}

	/**
	 * Verify that the assertStringContainsStringIgnoringCase() method does not throw
	 * a mb_strpos() PHP error when passed an empty $needle.
	 *
	 * This was possible due to a bug which existed in PHPUnit < 6.4.2.
	 *
	 * @link https://github.com/Yoast/PHPUnit-Polyfills/issues/17
	 * @link https://github.com/sebastianbergmann/phpunit/pull/2778/
	 *
	 * @return void
	 */
	public function testAssertStringContainsStringIgnoringCaseEmptyNeedle() {
		self::assertStringContainsStringIgnoringCase( '', 'foobar' );
	}

	/**
	 * Verify that the assertStringNotContainsString() method does not throw a mb_strpos()
	 * PHP error when passed an empty $needle.
	 *
	 * This was possible due to a bug which existed in PHPUnit < 6.4.2.
	 *
	 * @link https://github.com/Yoast/PHPUnit-Polyfills/issues/17
	 * @link https://github.com/sebastianbergmann/phpunit/pull/2778/
	 *
	 * @dataProvider dataHaystacks
	 *
	 * @param string $haystack Haystack.
	 *
	 * @return void
	 */
	public function testAssertStringNotContainsStringEmptyNeedle( $haystack ) {
		$msg = "Failed asserting that '{$haystack}' does not contain \"\".";

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessage( $msg );

		self::assertStringNotContainsString( '', $haystack );
	}

	/**
	 * Verify that the assertStringNotContainsStringIgnoringCase() method does not throw a mb_strpos()
	 * PHP error when passed an empty $needle.
	 *
	 * This was possible due to a bug which existed in PHPUnit < 6.4.2.
	 *
	 * @link https://github.com/Yoast/PHPUnit-Polyfills/issues/17
	 * @link https://github.com/sebastianbergmann/phpunit/pull/2778/
	 *
	 * @return void
	 */
	public function testAssertStringNotContainsStringIgnoringCaseEmptyNeedle() {
		$msg = 'Failed asserting that \'text with whitespace\' does not contain "".';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessage( $msg );

		$this->assertStringNotContainsStringIgnoringCase( '', 'text with whitespace' );
	}

	/**
	 * Data provider.
	 *
	 * @see testAssertStringContainsStringEmptyNeedle()    For the array format.
	 * @see testAssertStringNotContainsStringEmptyNeedle() For the array format.
	 *
	 * @return array
	 */
	public static function dataHaystacks() {
		return [
			'foobar as haystack' => [ 'foobar' ],
			'empty haystack'     => [ '' ],
		];
	}

	/**
	 * Verify that the assertStringNotContainsString() method fails a test with a custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testAssertStringNotContainsStringFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that \'.+?\' does not contain ""\.`s';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertStringNotContainsString( '', 'something', 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify that the assertStringNotContainsStringIgnoringCase() method fails a test with a custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testssertStringNotContainsStringIgnoringCaseFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that \'.+?\' does not contain ""\.`s';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertStringNotContainsStringIgnoringCase( '', 'something', 'This assertion failed for reason XYZ' );
	}

	/**
	 * Helper function: retrieve the name of the "assertion failed" exception to expect (PHPUnit cross-version).
	 *
	 * @return string
	 */
	public function getAssertionFailedExceptionName() {
		$exception = 'PHPUnit\Framework\AssertionFailedError';
		if ( \class_exists( 'PHPUnit_Framework_AssertionFailedError' ) ) {
			// PHPUnit < 6.
			$exception = 'PHPUnit_Framework_AssertionFailedError';
		}

		return $exception;
	}
}
