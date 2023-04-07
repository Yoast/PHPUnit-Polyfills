<?php

namespace Yoast\PHPUnitPolyfills\Tests\EndToEnd\Fixtures\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "skipped test" to pass to the test listener.
 */
class SkippedTest extends TestCase {

	/**
	 * Test resulting in a test marked as skipped.
	 *
	 * @return void
	 */
	public function testSkipped() {
		$this->markTestSkipped( 'Skipped test' );
	}
}
