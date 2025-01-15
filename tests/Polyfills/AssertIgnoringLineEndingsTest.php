<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Version as PHPUnit_Version;
use PHPUnit\SebastianBergmann\Exporter\Exporter as Exporter_In_Phar_Old;
use PHPUnitPHAR\SebastianBergmann\Exporter\Exporter as Exporter_In_Phar;
use SebastianBergmann\Exporter\Exporter;
use stdClass;
use TypeError;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIgnoringLineEndings;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * Availability test for the functions polyfilled by the AssertIgnoringLineEndings trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertIgnoringLineEndings
 */
#[CoversClass( AssertIgnoringLineEndings::class )]
final class AssertIgnoringLineEndingsTest extends TestCase {

	use AssertIgnoringLineEndings;
	use ExpectExceptionMessageMatches;

	/**
	 * Verify that the assertStringEqualsStringIgnoringLineEndings() method throws a TypeError
	 * when the $expected parameter is not a scalar.
	 *
	 * @dataProvider dataThrowsTypeErrorOnInvalidType
	 *
	 * @param mixed $input Non-string value.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataThrowsTypeErrorOnInvalidType' )]
	public function testAssertStringEqualsStringIgnoringLineEndingsThrowsTypeErrorOnInvalidTypeArg1( $input ) {
		if ( \PHP_VERSION_ID >= 80000 ) {
			$msg = 'assertStringEqualsStringIgnoringLineEndings(): Argument #1 ($expected) must be of type string, ';
		}
		else {
			// PHP 7.
			$msg  = 'Argument 1 passed to Yoast\\PHPUnitPolyfills\\Tests\\Polyfills\\AssertIgnoringLineEndingsTest';
			$msg .= '::assertStringEqualsStringIgnoringLineEndings() must be of the type string, ';
		}

		$this->expectException( TypeError::class );
		$this->expectExceptionMessage( $msg );

		self::assertStringEqualsStringIgnoringLineEndings( $input, 'string' );
	}

	/**
	 * Verify that the assertStringEqualsStringIgnoringLineEndings() method throws a TypeError
	 * when the $actual parameter is not a scalar.
	 *
	 * @dataProvider dataThrowsTypeErrorOnInvalidType
	 *
	 * @param mixed $input Non-string value.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataThrowsTypeErrorOnInvalidType' )]
	public function testAssertStringEqualsStringIgnoringLineEndingsThrowsTypeErrorOnInvalidTypeArg2( $input ) {
		if ( \PHP_VERSION_ID >= 80000 ) {
			$msg = 'assertStringEqualsStringIgnoringLineEndings(): Argument #2 ($actual) must be of type string, ';
		}
		else {
			// PHP 7.
			$msg  = 'Argument 2 passed to Yoast\\PHPUnitPolyfills\\Tests\\Polyfills\\AssertIgnoringLineEndingsTest';
			$msg .= '::assertStringEqualsStringIgnoringLineEndings() must be of the type string, ';
		}

		$this->expectException( TypeError::class );
		$this->expectExceptionMessage( $msg );

		static::assertStringEqualsStringIgnoringLineEndings( 'string', $input );
	}

	/**
	 * Verify availability and functionality of the assertStringEqualsStringIgnoringLineEndings() method.
	 *
	 * @dataProvider dataAllLineEndingVariations
	 * @dataProvider dataAssertStringEqualsStringIgnoringLineEndingsTypeVariations
	 *
	 * @param mixed $expected Expected value.
	 * @param mixed $actual   The value to test.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAllLineEndingVariations' )]
	#[DataProvider( 'dataAssertStringEqualsStringIgnoringLineEndingsTypeVariations' )]
	public function testAssertStringEqualsStringIgnoringLineEndings( $expected, $actual ) {
		self::assertStringEqualsStringIgnoringLineEndings( $expected, $actual );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string>>
	 */
	public static function dataAllLineEndingVariations() {
		return [
			'lf-crlf'   => [ "a\nb", "a\r\nb" ],
			'cr-crlf'   => [ "a\rb", "a\r\nb" ],
			'crlf-crlf' => [ "a\r\nb", "a\r\nb" ],
			'lf-cr'     => [ "a\nb", "a\rb" ],
			'cr-cr'     => [ "a\rb", "a\rb" ],
			'crlf-cr'   => [ "a\r\nb", "a\rb" ],
			'lf-lf'     => [ "a\nb", "a\nb" ],
			'cr-lf'     => [ "a\rb", "a\nb" ],
			'crlf-lf'   => [ "a\r\nb", "a\nb" ],
		];
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<mixed>>
	 */
	public static function dataAssertStringEqualsStringIgnoringLineEndingsTypeVariations() {
		return [
			'comparing int with string'        => [ 10, '10' ],
			'comparing int with float'         => [ 10, 10.0 ],
			'comparing bool false with string' => [ false, '' ],
			'comparing bool true with string'  => [ true, '1' ],
			'comparing bool true with int'     => [ true, 1 ],
		];
	}

	/**
	 * Verify handling of the lines endings for the assertStringEqualsStringIgnoringLineEndings() method.
	 *
	 * @dataProvider dataAssertStringEqualsStringIgnoringLineEndingsFails
	 *
	 * @param mixed $expected Expected value.
	 * @param mixed $actual   The value to test.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAssertStringEqualsStringIgnoringLineEndingsFails' )]
	public function testAssertStringEqualsStringIgnoringLineEndingsFails( $expected, $actual ) {

		$exporter = self::getPHPUnitExporterObjectForIgnoringLineEndingsForTests();
		$msg      = \sprintf(
			'Failed asserting that %s is equal to "%s" ignoring line endings.',
			$exporter->export( $actual ),
			self::normalizeLineEndings( $expected )
		);

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessage( $msg );

		$this->assertStringEqualsStringIgnoringLineEndings( $expected, $actual );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string>>
	 */
	public static function dataAssertStringEqualsStringIgnoringLineEndingsFails() {
		return [
			'lf-none'   => [ "a\nb", 'ab' ],
			'cr-none'   => [ "a\rb", 'ab' ],
			'crlf-none' => [ "a\r\nb", 'ab' ],
			'none-lf'   => [ 'ab', "a\nb" ],
			'none-cr'   => [ 'ab', "a\rb" ],
			'none-crlf' => [ 'ab', "a\r\nb" ],
		];
	}

	/**
	 * Verify that the assertStringEqualsStringIgnoringLineEndings() method fails a test with the correct
	 * custom failure message, when the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testAssertStringEqualsStringIgnoringLineEndingsFailsWithCustomMessage() {
		$actual   = 'ab';
		$expected = "a b\n";

		$exporter = self::getPHPUnitExporterObjectForIgnoringLineEndingsForTests();
		$msg      = \sprintf(
			'Failed asserting that %s is equal to "%s" ignoring line endings.',
			$exporter->export( $actual ),
			self::normalizeLineEndings( $expected )
		);

		$pattern = '`^This assertion failed for reason XYZ\s+' . \preg_quote( $msg, '`' ) . '`s';

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertStringEqualsStringIgnoringLineEndings( $expected, $actual, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify that the assertStringContainsStringIgnoringLineEndings() method throws a TypeError
	 * when the $needle parameter is not a scalar.
	 *
	 * @dataProvider dataThrowsTypeErrorOnInvalidType
	 *
	 * @param mixed $input Non-string value.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataThrowsTypeErrorOnInvalidType' )]
	public function testAssertStringContainsStringIgnoringLineEndingsThrowsTypeErrorOnInvalidTypeArg1( $input ) {
		if ( \PHP_VERSION_ID >= 80000 ) {
			$msg = 'assertStringContainsStringIgnoringLineEndings(): Argument #1 ($needle) must be of type string, ';
		}
		else {
			// PHP 7.
			$msg  = 'Argument 1 passed to Yoast\\PHPUnitPolyfills\\Tests\\Polyfills\\AssertIgnoringLineEndingsTest';
			$msg .= '::assertStringContainsStringIgnoringLineEndings() must be of the type string, ';
		}

		$this->expectException( TypeError::class );
		$this->expectExceptionMessage( $msg );

		static::assertStringContainsStringIgnoringLineEndings( $input, 'string' );
	}

	/**
	 * Verify that the assertStringContainsStringIgnoringLineEndings() method throws a TypeError
	 * when the $haystack parameter is not a scalar.
	 *
	 * @dataProvider dataThrowsTypeErrorOnInvalidType
	 *
	 * @param mixed $input Non-string value.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataThrowsTypeErrorOnInvalidType' )]
	public function testAssertStringContainsStringIgnoringLineEndingsThrowsTypeErrorOnInvalidTypeArg2( $input ) {
		if ( \PHP_VERSION_ID >= 80000 ) {
			$msg = 'assertStringContainsStringIgnoringLineEndings(): Argument #2 ($haystack) must be of type string, ';
		}
		else {
			// PHP 7.
			$msg  = 'Argument 2 passed to Yoast\\PHPUnitPolyfills\\Tests\\Polyfills\\AssertIgnoringLineEndingsTest';
			$msg .= '::assertStringContainsStringIgnoringLineEndings() must be of the type string, ';
		}

		$this->expectException( TypeError::class );
		$this->expectExceptionMessage( $msg );

		self::assertStringContainsStringIgnoringLineEndings( 'string', $input );
	}

	/**
	 * Verify availability and functionality of the assertStringContainsStringIgnoringLineEndings() method.
	 *
	 * @dataProvider dataAssertStringContainsStringIgnoringLineEndings
	 *
	 * @param string $needle   The string to search for.
	 * @param string $haystack The string to treat as the haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAssertStringContainsStringIgnoringLineEndings' )]
	public function testAssertStringContainsStringIgnoringLineEndings( $needle, $haystack ) {
		$this->assertStringContainsStringIgnoringLineEndings( $needle, $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<mixed>>
	 */
	public static function dataAssertStringContainsStringIgnoringLineEndings() {
		return [
			'needle is empty string'        => [ '', "b\r\nc" ],
			'same string'                   => [ "b\nc", "b\r\nc" ],
			'needle is substring 1'         => [ 'b', "a\r\nb\r\nc\r\nd" ],
			'needle is substring 2'         => [ "b\nc", "a\r\nb\r\nc\r\nd" ],
			'haystack is scalar non-string' => [ '10', 24310276 ],
			'needle is scalar non-string 1' => [ 10, '24310276' ],
			'needle is scalar non-string 2' => [ false, "something\nelse" ],
			'needle is scalar non-string 3' => [ true, '123' ],
		];
	}

	/**
	 * Verify that the assertStringContainsStringIgnoringLineEndings() method normalizes the line endings
	 * of both the haystack and the needle.
	 *
	 * @link https://github.com/sebastianbergmann/phpunit/pull/5279
	 *
	 * @dataProvider dataAllLineEndingVariations
	 *
	 * @param string $needle   The string to search for.
	 * @param string $haystack The string to treat as the haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAllLineEndingVariations' )]
	public function testAssertStringContainsStringIgnoringLineEndingsBug5279( $needle, $haystack ) {
		if ( \version_compare( PHPUnit_Version::id(), '10.0.0', '>=' )
			&& \version_compare( PHPUnit_Version::id(), '10.0.16', '<' )
		) {
			// This bug was fixed in PHPUnit 10.0.16.
			$this->markTestSkipped( 'Skipping test on PHPUnit versions which contained the bug' );
		}

		$this->assertStringContainsStringIgnoringLineEndings( $needle, $haystack );
	}

	/**
	 * Verify that the assertStringContainsStringIgnoringLineEndings() method fails a test
	 * when the needle is not found in the haystack.
	 *
	 * @dataProvider dataAssertStringContainsStringIgnoringLineEndingsFails
	 *
	 * @param string $needle   The string to search for.
	 * @param string $haystack The string to treat as the haystack.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataAssertStringContainsStringIgnoringLineEndingsFails' )]
	public function testAssertStringContainsStringIgnoringLineEndingsFails( $needle, $haystack ) {
		$exporter = self::getPHPUnitExporterObjectForIgnoringLineEndingsForTests();
		$pattern  = \sprintf(
			'`^Failed asserting that %1$s%3$s contains "%2$s"%3$s\.`',
			\preg_quote( $exporter->export( $haystack ), '`' ),
			\preg_quote( self::normalizeLineEndings( $needle ), '`' ),
			'( \[[^\]]+\]\(length: [0-9]+\))?'
		);

		$this->expectException( AssertionFailedError::class );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertStringContainsStringIgnoringLineEndings( $needle, $haystack );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<string>>
	 */
	public static function dataAssertStringContainsStringIgnoringLineEndingsFails() {
		return [
			'not substring'                  => [ 'a', 'bc' ],
			'no line endings in needle'      => [ 'bc', "b\nc" ],
			'no line endings in haystack'    => [ "b\nc", 'bc' ],
			'different line endings count 1' => [ "b\nc", "b\n\n\nc" ],
			'different line endings count 2' => [ "b\n\n\nc", "b\nc" ],
		];
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<mixed>>
	 */
	public static function dataThrowsTypeErrorOnInvalidType() {
		return [
			'null'    => [ null ],
			'array'   => [ [ 'a' ] ],
			'object'  => [ new stdClass() ],
		];
	}

	/**
	 * Normalize line endings.
	 *
	 * @param string $value The text to normalize.
	 *
	 * @return string
	 */
	private static function normalizeLineEndings( $value ) {
		return \strtr(
			$value,
			[
				"\r\n" => "\n",
				"\r"   => "\n",
			]
		);
	}

	/**
	 * Helper function to obtain an instance of the Exporter class.
	 *
	 * Note: the helper from the trait is accessible, but may not be available if the "empty" trait is being loaded.
	 *
	 * @return SebastianBergmann\Exporter\Exporter|PHPUnitPHAR\SebastianBergmann\Exporter\Exporter|PHPUnit\SebastianBergmann\Exporter\Exporter
	 */
	private static function getPHPUnitExporterObjectForIgnoringLineEndingsForTests() {
		if ( \class_exists( Exporter::class ) ) {
			// Composer install or really old PHAR files.
			return new Exporter();
		}
		elseif ( \class_exists( Exporter_In_Phar::class ) ) {
			// PHPUnit PHAR file for 8.5.38+, 9.6.19+, 10.5.17+ and 11.0.10+.
			return new Exporter_In_Phar();
		}

		// PHPUnit PHAR file for < 8.5.38, < 9.6.19, < 10.5.17 and < 11.0.10.
		return new Exporter_In_Phar_Old();
	}
}
