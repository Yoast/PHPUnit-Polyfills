<?php

namespace Yoast\PHPUnitPolyfills\Tests\Exceptions;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Exceptions\InvalidComparisonMethodException;

/**
 * Minimal test for the custom exception.
 *
 * @covers \Yoast\PHPUnitPolyfills\Exceptions\InvalidComparisonMethodException
 */
final class InvalidComparisonMethodExceptionTest extends TestCase {

	/**
	 * Test that the exception is stringable.
	 *
	 * @return void
	 */
	public function testIsStringable() {
		$text = 'Dummy text';
		$obj  = new InvalidComparisonMethodException( $text );

		$this->assertSame( $text . \PHP_EOL, (string) $obj );
	}
}
