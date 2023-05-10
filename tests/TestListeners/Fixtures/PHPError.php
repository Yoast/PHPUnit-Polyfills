<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use Exception;
use Generator;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a test error to pass to the test listener.
 */
class PHPError extends TestCase {

	/**
	 * Test resulting in a PHP error.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	protected function runTest() {
		// Trigger PHP features which will throw errors in various PHP versions.
		switch ( \PHP_MAJOR_VERSION ) {
			case 5:
				// The "Generator" class is reserved for internal use.
				new Generator();
				break;

			case 7:
			case 8:
				// strpos() expects at least 2 parameters, 1 given.
				\strpos( 'bar' );
				break;
		}
	}
}
