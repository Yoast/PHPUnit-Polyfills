<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * Availability test for the functions polyfilled by the AssertStringContains trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains
 */
#[CoversClass( AssertStringContains::class )]
final class AssertStringContainsTest extends TestCase {

	use AssertStringContains;
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
	#[DataProvider( 'dataHaystacks' )]
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
	#[DataProvider( 'dataHaystacks' )]
	public function testAssertStringNotContainsStringEmptyNeedle( $haystack ) {
		$pattern = "`^Failed asserting that '{$haystack}'( \[[^\]]+\]\(length: [0-9]+\))? does not contain \"\"( \[[^\]]+\]\(length: [0-9]+\))?\.`";

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

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
		$pattern = '`^Failed asserting that \'text with whitespace\'( \[[^\]]+\]\(length: [0-9]+\))? does not contain ""( \[[^\]]+\]\(length: [0-9]+\))?.`';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertStringNotContainsStringIgnoringCase( '', 'text with whitespace' );
	}

	/**
	 * Data provider.
	 *
	 * @see testAssertStringContainsStringEmptyNeedle()    For the array format.
	 * @see testAssertStringNotContainsStringEmptyNeedle() For the array format.
	 *
	 * @return array<string, array<string>>
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
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that \'.+?\'( \[[^\]]+\]\(length: [0-9]+\))? does not contain ""( \[[^\]]+\]\(length: [0-9]+\))?\.`s';

		$this->expectException( AssertionFailedError::class );
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
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that \'.+?\'( \[[^\]]+\]\(length: [0-9]+\))? does not contain ""( \[[^\]]+\]\(length: [0-9]+\))?\.`s';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertStringNotContainsStringIgnoringCase( '', 'something', 'This assertion failed for reason XYZ' );
	}
}
