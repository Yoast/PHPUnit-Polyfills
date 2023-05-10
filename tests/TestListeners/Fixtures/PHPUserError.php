<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a test error to pass to the test listener.
 */
class PHPUserError extends TestCase {

	/**
	 * Test resulting in a PHP error.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	protected function runTest() {
		\trigger_error( 'Error', \E_USER_ERROR );
	}
}
