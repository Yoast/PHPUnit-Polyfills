<?php

namespace Yoast\PHPUnitPolyfills\Exceptions;

use Exception;

/**
 * Exception used for all errors throw by the polyfill for the `assertObjectEquals()` and the `assertObjectNotEquals()` assertions.
 *
 * PHPUnit natively throws a range of different exceptions.
 * The polyfills throw just one exception type with different messages.
 *
 * @since 1.0.0
 */
final class InvalidComparisonMethodException extends Exception {

	/**
	 * Convert the Exception object to a string message.
	 *
	 * @return string
	 */
	public function __toString() {
		return $this->getMessage() . \PHP_EOL;
	}
}
