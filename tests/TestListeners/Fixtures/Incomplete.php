<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate an "incomplete test" to pass to the test listener.
 */
class Incomplete extends TestCase {

	/**
	 * Test resulting in a test marked as incomplete.
	 *
	 * @return void
	 */
	protected function runTest() {
		$this->markTestIncomplete( 'Test incomplete' );
	}
}
