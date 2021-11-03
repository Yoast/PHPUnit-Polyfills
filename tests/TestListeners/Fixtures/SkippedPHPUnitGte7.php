<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "skipped test" to pass to the test listener.
 *
 * @requires PHPUnit 7.0
 */
class SkippedPHPUnitGte7 extends TestCase {

	/**
	 * Test resulting in a test marked as skipped.
	 *
	 * @return void
	 */
	protected function testForListener() {
		$this->markTestSkipped( 'Skipped test' );
	}
}
