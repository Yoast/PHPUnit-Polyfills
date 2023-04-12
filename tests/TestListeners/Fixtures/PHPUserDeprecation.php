<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a test error to pass to the test listener.
 */
class PHPUserDeprecation extends TestCase {

	/**
	 * Test resulting in a PHP deprecation notice.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	protected function runTest() {
		\trigger_error( 'Deprecated', \E_USER_DEPRECATED );
	}
}
