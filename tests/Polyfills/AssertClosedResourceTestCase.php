<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * Helper functions for the functionality tests for the polyfills in the AssertClosedResource trait.
 */
abstract class AssertClosedResourceTestCase extends TestCase {

	use AssertClosedResource;
	use ExpectException; // Needed for PHPUnit < 5.2.0 support.
	use ExpectExceptionMessageMatches;

	/**
	 * Helper method: Verify that an exception is thrown when `assertIsClosedResource()` is passed an open resource.
	 *
	 * @param resource $actual The resource under test.
	 *
	 * @return void
	 */
	public function isClosedResourceExpectExceptionOnOpenResource( $actual ) {
		$pattern = '`^Failed asserting that .+? is of type ["]?resource \(closed\)["]?`';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$this->assertIsClosedResource( $actual );
	}

	/**
	 * Helper method: Verify that an exception is thrown when `assertIsNotClosedResource()` is passed a closed resource.
	 *
	 * @param resource $actual The resource under test.
	 *
	 * @return void
	 */
	public function isNotClosedResourceExpectExceptionOnClosedResource( $actual ) {
		/*
		 * PHPUnit itself will report closed resources as `NULL` prior to Exporter 3.0.4/4.1.4.
		 * See: https://github.com/sebastianbergmann/exporter/pull/37
		 */
		$pattern = '`^Failed asserting that (resource \(closed\)|NULL) is not of type ["]?resource \(closed\)["]?`';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		self::assertIsNotClosedResource( $actual );
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
