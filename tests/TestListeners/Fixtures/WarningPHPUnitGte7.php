<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Warning as PHPUnit_Warning;

/**
 * Fixture to generate a test warning to pass to the test listener.
 *
 * @requires PHPUnit 7.0
 */
class WarningPHPUnitGte7 extends TestCase {

	/**
	 * Test resulting in a warning.
	 *
	 * @return void
	 *
	 * @throws PHPUnit_Warning For test purposes.
	 */
	protected function testForListener() {
		throw new PHPUnit_Warning();
	}
}
