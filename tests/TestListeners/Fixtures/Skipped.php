<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "skipped test" to pass to the test listener.
 */
class Skipped extends TestCase {

	/**
	 * Test resulting in a test marked as skipped.
	 *
	 * @return void
	 */
	protected function runTest() {
		$this->markTestSkipped( 'Skipped test' );
	}
}
