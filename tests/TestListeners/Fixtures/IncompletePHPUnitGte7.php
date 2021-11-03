<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate an "incomplete test" to pass to the test listener.
 *
 * @requires PHPUnit 7.0
 */
class IncompletePHPUnitGte7 extends TestCase {

	/**
	 * Test resulting in a test marked as incomplete.
	 *
	 * @return void
	 */
	protected function testForListener() {
		$this->markTestIncomplete( 'Test incomplete' );
	}
}
