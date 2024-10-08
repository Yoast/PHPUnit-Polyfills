<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use Exception;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a test error to pass to the test listener.
 *
 * @requires PHPUnit 7.0
 *
 * @coversNothing
 */
#[CoversNothing]
#[RequiresPhpunit( '7.0' )]
class TestErrorPHPUnitGte7 extends TestCase {

	/**
	 * Test resulting in an error.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	protected function testForListener() {
		throw new Exception();
	}
}
