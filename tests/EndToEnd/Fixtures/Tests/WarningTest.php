<?php

namespace Yoast\PHPUnitPolyfills\Tests\EndToEnd\Fixtures\Tests;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Warning as PHPUnit_Warning;

/**
 * Fixture to generate a test warning to pass to the test listener.
 */
class WarningTest extends TestCase {

	/**
	 * Test resulting in a warning.
	 *
	 * @return void
	 *
	 * @throws PHPUnit_Warning For test purposes.
	 */
	public function testWarning() {
		if (\class_exists(PHPUnit_Warning::class)) {
			throw new PHPUnit_Warning();
		}
	}
}
