<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use Exception;
use PHPUnit\Framework\Exception as PHPUnit_Exception;
use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Version as PHPUnit_Version;
use TypeError;
use Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\InvalidExceptionCodeTestCase;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\InvalidExceptionMessageTestCase;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures\ThrowExceptionTestCase;

/**
 * Availability test for the functions polyfilled by the ExpectException trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\ExpectException
 */
class ExpectExceptionTest extends TestCase {

	use AssertionRenames;
	use ExpectException;

	/**
	 * Verify availability of the expectException() method.
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testExpectException() {
		$this->expectException( Exception::class );

		throw new Exception( 'message' );
	}

	/**
	 * Verify availability of the expectExceptionCode() method.
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testExpectExceptionCode() {
		$this->expectException( Exception::class );
		$this->expectExceptionCode( 404 );

		throw new Exception( '', 404 );
	}

	/**
	 * Test the "invalid argument" exception if a non-int/string exception code is passed.
	 *
	 * This exception was thrown in PHPUnit < 7.0.0, after which it was removed.
	 * PHPUnit introduces parameter type declaration in PHPUnit 7.0.0, but didn't for
	 * this method as it needs union types.
	 *
	 * @requires PHPUnit < 7
	 */
	public function testExpectExceptionCodeException() {
		$test   = new InvalidExceptionCodeTestCase( 'test' );
		$result = $test->run();

		$this->assertSame( 1, $result->errorCount() );
		$this->assertSame( 1, \count( $result ) );
		$this->assertMatchesRegularExpression(
			'`^Argument #1 \([^)]+\) of [^:]+::expectExceptionCode\(\) must be a integer or string`',
			$test->getStatusMessage()
		);
	}

	/**
	 * Verify availability of the expectExceptionMessage() method.
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testExpectExceptionMessage() {
		$this->expectException( Exception::class );
		$this->expectExceptionMessage( 'message' );

		throw new Exception( 'message' );
	}

	/**
	 * Test the "invalid argument" exception if a non-string exception message is passed.
	 *
	 * This exception was thrown until PHP 7.0.0. Since PHP 7.0.0, a PHP native TypeError will
	 * be thrown based on the type declaration.
	 *
	 * @return void
	 */
	public function testExpectExceptionMessageException() {
		$regex = '`^Argument #1 \([^)]+\) of [^:]+::expectExceptionMessage\(\) must be a string`';
		if ( \class_exists( PHPUnit_Version::class ) === true
			&& \version_compare( PHPUnit_Version::id(), '7.0.0', '>=' )
		) {
			$regex = '`^Argument 1 passed to [^:]+::expectExceptionMessage\(\) must be of the type string`';
			if ( \PHP_MAJOR_VERSION === 8 ) {
				$regex = '`^[^:]+::expectExceptionMessage\(\): Argument \#1 \([^)]+\) must be of type string`';
			}
		}

		$test   = new InvalidExceptionMessageTestCase( 'test' );
		$result = $test->run();

		$this->assertSame( 1, $result->errorCount() );
		$this->assertSame( 1, \count( $result ) );
		$this->assertMatchesRegularExpression( $regex, $test->getStatusMessage() );
	}

	/**
	 * Verify that when the expectations are set individually, the polyfill sets them
	 * correctly as combined for older PHPUnit versions.
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testExpectExceptionMessageAndCode() {
		$this->expectException( Exception::class );
		$this->expectExceptionMessage( 'message' );
		$this->expectExceptionCode( 404 );

		throw new Exception( 'message', 404 );
	}

	/**
	 * Verify that when the expectations are set individually, the polyfill sets them
	 * correctly as combined for older PHPUnit versions and fails on one of the expectations
	 * not being matched.
	 *
	 * @return void
	 */
	public function testExpectExceptionMessageAndCodeFailOnCode() {
		$test = new ThrowExceptionTestCase( 'test' );
		$test->expectException( Exception::class );
		$test->expectExceptionMessage( 'A runtime error occurred' );
		$test->expectExceptionCode( 404 );

		$result = $test->run();

		$this->assertSame( 1, $result->failureCount() );
		$this->assertSame( 1, \count( $result ) );
		$this->assertSame(
			'Failed asserting that 999 is equal to expected exception code 404.',
			$test->getStatusMessage()
		);
	}

	/**
	 * Verify that when the expectations are set individually, the polyfill sets them
	 * correctly as combined for older PHPUnit versions and fails on one of the expectations
	 * not being matched.
	 *
	 * @return void
	 */
	public function testExpectExceptionMessageAndCodeFailOnMsg() {
		$test = new ThrowExceptionTestCase( 'test' );
		$test->expectException( Exception::class );
		$test->expectExceptionMessage( 'message' );
		$test->expectExceptionCode( 999 );

		$result = $test->run();

		$this->assertSame( 1, $result->failureCount() );
		$this->assertSame( 1, \count( $result ) );
		$this->assertSame(
			"Failed asserting that exception message 'A runtime error occurred' contains 'message'.",
			$test->getStatusMessage()
		);
	}

	/**
	 * Verify availability of the expectExceptionMessageRegExp() method.
	 *
	 * This test only needs to run in the PHPUnit versions where this method was
	 * not yet deprecated. For newer PHPUnit versions, end-users should use the
	 * polyfill for the `TestCase::expectExceptionMessageMatches()` method.
	 *
	 * @requires PHPUnit < 8.4.0
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testExpectExceptionMessageRegExp() {
		$this->expectException( Exception::class );
		$this->expectExceptionMessageRegExp( '/^foo/' );

		throw new Exception( 'foobar' );
	}

	/**
	 * Test the "invalid argument" exception if a non-string exception message regex is passed.
	 *
	 * This exception was thrown until PHP 7.0.0. Since PHP 7.0.0, a PHP native TypeError will
	 * be thrown based on the type declaration.
	 *
	 * This test only needs to run in the PHPUnit versions where this method was
	 * not yet deprecated. For newer PHPUnit versions, end-users should use the
	 * polyfill for the `TestCase::expectExceptionMessageMatches()` method.
	 *
	 * @requires PHPUnit < 8.4.0
	 *
	 * @return void
	 */
	public function testExpectExceptionMessageRegExpException() {
		try {
			$this->expectExceptionMessageRegExp( null );
		} catch ( PHPUnit_Exception $e ) {
			// PHPUnit < 7.0.0.
			$this->assertMatchesRegularExpression(
				'`^Argument #1 \([^)]+\) of [^:]+::expectExceptionMessageRegExp\(\) must be a string`',
				$e->getMessage()
			);
			return;
		} catch ( TypeError $e ) {
			// PHPUnit >= 7.0.0.
			$regex = '`^Argument 1 passed to [^:]+::expectExceptionMessageRegExp\(\) must be of the type string`';
			if ( \PHP_MAJOR_VERSION === 8 ) {
				// Just in case someone tries to run the tests with PHPUnit < 8.4 on PHP 8.
				$regex = '`^[^:]+::expectExceptionMessageRegExp\(\): Argument \#1 \([^)]+\) must be of type string`';
			}

			$this->assertMatchesRegularExpression( $regex, $e->getMessage() );
			return;
		}

		$this->fail( 'Failed to assert that the expected "invalid argument" exception was thrown' );
	}

	/**
	 * Verify that when the expectations are set individually, the polyfill sets them
	 * correctly as combined for older PHPUnit versions.
	 *
	 * This test only needs to run in the PHPUnit versions where this method was
	 * not yet deprecated. For newer PHPUnit versions, end-users should use the
	 * polyfill for the `TestCase::expectExceptionMessageMatches()` method.
	 *
	 * @requires PHPUnit < 8.4.0
	 *
	 * @return void
	 *
	 * @throws Exception For testing purposes.
	 */
	public function testExpectExceptionMessageRegExpAndCode() {
		$this->expectException( Exception::class );
		$this->expectExceptionMessageRegExp( '/^foo/' );
		$this->expectExceptionCode( 404 );

		throw new Exception( 'foobar', 404 );
	}

	/**
	 * Verify that when the expectations are set individually, the polyfill sets them
	 * correctly as combined for older PHPUnit versions and fails on one of the expectations
	 * not being matched.
	 *
	 * This test only needs to run in the PHPUnit versions where this method was
	 * not yet deprecated. For newer PHPUnit versions, end-users should use the
	 * polyfill for the `TestCase::expectExceptionMessageMatches()` method.
	 *
	 * @requires PHPUnit < 8.4.0
	 *
	 * @return void
	 */
	public function testExpectExceptionMessageRegExpAndCodeFailOnCode() {
		$test = new ThrowExceptionTestCase( 'test' );
		$test->expectException( Exception::class );
		$test->expectExceptionMessageRegExp( '/^A runtime/' );
		$test->expectExceptionCode( 404 );

		$result = $test->run();

		$this->assertSame( 1, $result->failureCount() );
		$this->assertSame( 1, \count( $result ) );
		$this->assertSame(
			'Failed asserting that 999 is equal to expected exception code 404.',
			$test->getStatusMessage()
		);
	}

	/**
	 * Verify that when the expectations are set individually, the polyfill sets them
	 * correctly as combined for older PHPUnit versions and fails on one of the expectations
	 * not being matched.
	 *
	 * This test only needs to run in the PHPUnit versions where this method was
	 * not yet deprecated. For newer PHPUnit versions, end-users should use the
	 * polyfill for the `TestCase::expectExceptionMessageMatches()` method.
	 *
	 * @requires PHPUnit < 8.4.0
	 *
	 * @return void
	 */
	public function testExpectExceptionMessageRegExpAndCodeFailOnMsg() {
		$test = new ThrowExceptionTestCase( 'test' );
		$test->expectException( Exception::class );
		$test->expectExceptionMessageRegExp( '/^foo/' );
		$test->expectExceptionCode( 999 );

		$result = $test->run();

		$this->assertSame( 1, $result->failureCount() );
		$this->assertSame( 1, \count( $result ) );
		$this->assertSame(
			"Failed asserting that exception message 'A runtime error occurred' matches '/^foo/'.",
			$test->getStatusMessage()
		);
	}
}
