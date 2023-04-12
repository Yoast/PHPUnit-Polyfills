<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a test error to pass to the test listener.
 */
class PHPWarning extends TestCase {

	/**
	 * Test resulting in a PHP warning.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	protected function runTest() {
		// Triggers a warning in all supported PHP versions.
		// The magic method __set() must have public visibility and cannot be static.
		include __DIR__ . '/Fixtures/GenerateEWarning.php';
	}
}
