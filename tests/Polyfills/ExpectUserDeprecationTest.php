<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\IgnoreDeprecations;
use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation;

/**
 * Availability test for the function polyfilled by the ExpectUserDeprecation trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation
 */
#[CoversClass( ExpectUserDeprecation::class )]
final class ExpectUserDeprecationTest extends TestCase {

	use ExpectUserDeprecation;
	
	/**
	 * Failure message template for the expectUserDeprecationMessage() method.
	 *
	 * @var string
	 */
	const FAILURE_MSG_EXACT = 'Expected deprecation with message "%s" was not triggered';

	/**
	 * Failure message template for the expectUserDeprecationMessageMatches() method.
	 *
	 * @var string
	 */
	const FAILURE_MSG_REGEX = 'Expected deprecation with message matching regular expression "%s" was not triggered';

	/**
	 * Verify availability and functionality of the expectUserDeprecationMessage() method.
	 *
	 * @return void
	 */
	#[IgnoreDeprecations]
	public function testExpectUserDeprecationMessagePassSingleDeprecation() {
		$this->expectUserDeprecationMessage( 'Testing catching of a deprecation notice' );

		\trigger_error( 'Testing catching of a deprecation notice', \E_USER_DEPRECATED );
	}

	/**
	 * Verify availability and functionality of the expectUserDeprecationMessage() method.
	 *
	 * @return void
	 */
	#[IgnoreDeprecations]
	public function testExpectUserDeprecationMessagePassMultipleDeprecations() {
		$this->expectUserDeprecationMessage( 'Testing catching of a deprecation notice' );
		$this->expectUserDeprecationMessage( 'Testing another deprecation notice' );

		\trigger_error( 'Testing catching of a deprecation notice', \E_USER_DEPRECATED );
		\trigger_error( 'Testing another deprecation notice', \E_USER_DEPRECATED );
	}

	/**
	 * Verify the expectUserDeprecationMessage() method fails when no deprecation is thrown.
	 *
	 * @return void
	 */
	#[IgnoreDeprecations]
	public function testExpectUserDeprecationMessageFailNoDeprecationThrown() {
		$deprecation = 'Testing catching of a deprecation notice';

//		$this->expectException( ExpectationFailedException::class );
//		$this->expectExceptionMessage( \sprintf( self::FAILURE_MSG_EXACT, $deprecation ) );

		$this->expectUserDeprecationMessage( $deprecation );
	}

	/**
	 * Verify the expectUserDeprecationMessage() method fails when the expected deprecation notice doesn't match.
	 *
	 * @dataProvider dataExpectUserDeprecationMessageFail
	 *
	 * @param string $expectedMessage The message expectation.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataExpectUserDeprecationMessageFail' )]
	#[IgnoreDeprecations]
	public function testExpectUserDeprecationMessageFail( $expectedMessage ) {
//		$this->expectException( ExpectationFailedException::class );
//		$this->expectExceptionMessage( \sprintf( self::FAILURE_MSG_EXACT, $expectedMessage ) );

		$this->expectUserDeprecationMessage( $expectedMessage );

		\trigger_error( 'Testing catching of a deprecation notice', \E_USER_DEPRECATED );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<array<mixed>>>
	 */
	public static function dataExpectUserDeprecationMessageFail() {
		return [
			'different message'             => [ 'Some other message' ],
			'message is not an exact match' => [ 'catching of a deprecation' ],
		];
	}

	/**
	 * Verify availability and functionality of the expectUserDeprecationMessageMatches() method.
	 *
	 * @dataProvider dataExpectUserDeprecationMessageMatchesPass
	 *
	 * @param string $expectedRegex The message expectation regex.
	 *
	 * @return void
	 */
	#[DataProvider( 'dataExpectUserDeprecationMessageMatchesPass' )]
	#[IgnoreDeprecations]
	public function testExpectUserDeprecationMessageMatchesPass( $expectedRegex ) {
		$this->expectUserDeprecationMessageMatches( $expectedRegex );

		\trigger_error( 'Testing catching of a deprecation notice', \E_USER_DEPRECATED );
	}

	/**
	 * Data provider.
	 *
	 * @return array<string, array<array<mixed>>>
	 */
	public static function dataExpectUserDeprecationMessageMatchesPass() {
		return [
			'Exact match'            => [ '`^Testing catching of a deprecation notice$`' ],
			'Case insensitive match' => [ '`^TESTING CATCHING OF A DEPRECATION NOTICE$`i' ],
			'Partial match'          => [ '`catching( [^ ]+){2} deprecation`' ],
		];
	}

	/**
	 * Verify availability and functionality of the expectUserDeprecationMessage() method.
	 *
	 * @return void
	 */
	#[IgnoreDeprecations]
	public function testExpectUserDeprecationMessageMatchesPassMultipleDeprecations() {
		$this->expectUserDeprecationMessageMatches('/foo/');
		$this->expectUserDeprecationMessageMatches('/bar/');

		\trigger_error('...foo...', \E_USER_DEPRECATED);
		\trigger_error('...bar...', \E_USER_DEPRECATED);
	}

	/**
	 * Verify the expectUserDeprecationMessageMatches() method fails when no deprecation is thrown.
	 *
	 * @return void
	 */
	#[IgnoreDeprecations]
	public function testExpectUserDeprecationMessageMatchesFailNoDeprecationThrown() {
		$deprecation = '`^Testing catching of a deprecation notice$`';

		$this->expectException( ExpectationFailedException::class );
		$this->expectExceptionMessage( \sprintf( self::FAILURE_MSG_REGEX, $deprecation ) );

		$this->expectUserDeprecationMessageMatches( $deprecation );
	}

	/**
	 * Verify the expectUserDeprecationMessageMatches() method fails when the expected deprecation notice doesn't match.
	 *
	 * @return void
	 */
	#[IgnoreDeprecations]
	public function testExpectUserDeprecationMessageMatchesFail() {
		$deprecation = '`^Some other message$`';

		$this->expectException( ExpectationFailedException::class );
		$this->expectExceptionMessage( \sprintf( self::FAILURE_MSG_REGEX, $deprecation ) );

		$this->expectUserDeprecationMessageMatches( $deprecation );

		\trigger_error( 'Testing catching of a deprecation notice', \E_USER_DEPRECATED );
	}

// Test with deprecation which doesn't use new expectation (old behaviour is maintained, i.e. in PHPUnit < 10 test errors out, PHPUnit 10, ignored/failed)
// Test PHPUnit < 10 with old method which can only handle one deprecation and doesn't run the rest of the test

// Throw exception on invalid regex ?
// Throw exception on non-string or empty string params passed ?

// Test error handler chaining ?

// Test that if a notice/warning is thrown this is not handled by the polyfill, but by PHPUnit
// Test that if a PHP native deprecation is thrown this is not handled by the polyfill, but by PHPUnit


}
