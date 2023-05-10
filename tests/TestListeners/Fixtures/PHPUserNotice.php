<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a test error to pass to the test listener.
 */
class PHPUserNotice extends TestCase {

	/**
	 * Test resulting in a PHP notice.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	protected function runTest() {
		\trigger_error( 'Notice', \E_USER_NOTICE );
	}
}
