<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a test error to pass to the test listener.
 */
class PHPUserWarning extends TestCase {

	/**
	 * Test resulting in a PHP warning.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	protected function runTest() {
		\trigger_error( 'Warning', \E_USER_WARNING );
	}
}
