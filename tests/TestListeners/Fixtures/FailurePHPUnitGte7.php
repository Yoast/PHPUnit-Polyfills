<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "failed test" to pass to the test listener.
 *
 * @requires PHPUnit 7.0
 */
#[RequiresPhpunit( '7.0' )]
class FailurePHPUnitGte7 extends TestCase {

	/**
	 * Test resulting in a failed test.
	 *
	 * @return void
	 */
	protected function testForListener() {
		$this->fail();
	}
}
