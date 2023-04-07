<?php

namespace Yoast\PHPUnitPolyfills\Tests\EndToEnd\Fixtures\Tests;

use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a "successfull test" to pass to the test listener.
 */
class SuccessTest extends TestCase {

	/**
	 * Test resulting in a successfull test.
	 *
	 * @return void
	 */
	public function testSuccess() {
		$this->assertTrue( true );
	}
}
