<?php

namespace Yoast\PHPUnitPolyfills\TestCases;

use PHPUnit\Framework\TestCase as PHPUnit_TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertEqualsSpecializations;
use Yoast\PHPUnitPolyfills\Polyfills\AssertFileEqualsSpecializations;
use Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;
use Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionObject;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectPHPException;

/**
 * Basic test case for use with PHPUnit <= 7.
 *
 * This test case uses renamed (snakecase) methods for the `setUpBeforeClass()`, `setUp()`,
 * `tearDown()` and `tearDownAfterClass()` methods to get round the signature change in PHPUnit 8.
 *
 * When using this TestCase, the snakecase method names need to be used to overload a fixture method.
 */
abstract class TestCase extends PHPUnit_TestCase {

	use AssertEqualsSpecializations;
	use AssertFileEqualsSpecializations;
	use AssertionRenames;
	use AssertIsType;
	use AssertStringContains;
	use ExpectExceptionMessageMatches;
	use ExpectExceptionObject;
	use ExpectPHPException;

	/**
	 * This method is called before the first test of this test class is run.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public static function setUpBeforeClass() {
		parent::setUpBeforeClass();
		static::set_up_before_class();
	}

	/**
	 * This method is called before each test.
	 *
	 * @return void
	 */
	protected function setUp() {
		parent::setUp();
		$this->set_up();
	}

	/**
	 * This method is called after each test.
	 *
	 * @return void
	 */
	protected function tearDown() {
		$this->tear_down();
		parent::tearDown();
	}

	/**
	 * This method is called after the last test of this test class is run.
	 *
	 * @codeCoverageIgnore
	 *
	 * @return void
	 */
	public static function tearDownAfterClass() {
		static::tear_down_after_class();
		parent::tearDownAfterClass();
	}

	/**
	 * This method is called before the first test of this test class is run.
	 *
	 * @return void
	 */
	public static function set_up_before_class() {}

	/**
	 * This method is called before each test.
	 *
	 * @return void
	 */
	protected function set_up() {}

	/**
	 * This method is called after each test.
	 *
	 * @return void
	 */
	protected function tear_down() {}

	/**
	 * This method is called after the last test of this test class is run.
	 *
	 * @return void
	 */
	public static function tear_down_after_class() {}
}
