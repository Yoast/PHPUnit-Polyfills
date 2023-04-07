<?php

namespace Yoast\PHPUnitPolyfills\Tests\EndToEnd\Fixtures\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate an "incomplete test" to pass to the test listener.
 */
class IncompleteTest extends TestCase {

	/**
	 * Test resulting in a test marked as incomplete.
	 *
	 * @return void
	 */
	public function testIncomplete() {
		$this->markTestIncomplete( 'Test incomplete' );
	}
}
