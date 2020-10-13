<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestCases;

use Yoast\PHPUnitPolyfills\TestCases\TestCase;

/**
 * Basic test for the PHPUnit version-based TestCase fixture setup.
 *
 * @covers \Yoast\PHPUnitPolyfills\TestCases\TestCase
 */
class TestCaseTest extends TestCase {

	use TestCaseTestTrait;

	/**
	 * Keep track of how often the PHPUnit native `setUpBeforeClass()` method was called/
	 * called the `set_up_before_class()` method.
	 *
	 * @var int
	 */
	public static $beforeClass = 0;

	/**
	 * Keep track of how often the PHPUnit native `setUp()` method was called/
	 * called the `set_up()` method.
	 *
	 * @var int
	 */
	public static $before = 0;

	/**
	 * Keep track of how often the PHPUnit native `tearDown()` method was called/
	 * called the `tear_down()` method.
	 *
	 * @var int
	 */
	public static $after = 0;

	/**
	 * This method is called before the first test of this test class is run.
	 *
	 * @return void
	 */
	public static function set_up_before_class() {
		++self::$beforeClass;
	}

	/**
	 * This method is called before each test.
	 *
	 * @return void
	 */
	protected function set_up() {
		++self::$before;
	}

	/**
	 * This method is called after each test.
	 *
	 * @return void
	 */
	protected function tear_down() {
		++self::$after;
	}

	/**
	 * This method is called after the last test of this test class is run.
	 *
	 * @return void
	 */
	public static function tear_down_after_class() {
		// Reset.
		self::$beforeClass = 0;
		self::$before      = 0;
		self::$after       = 0;
	}

	/**
	 * Test that the fixture method overloads have been triggered and run correctly.
	 *
	 * Note: Can't really test `tear_down_after_class()`, but if everything else works, that should too.
	 *
	 * @dataProvider dataHaveFixtureMethodsBeenTriggered
	 *
	 * @param int $expectedBeforeClass Value expected for the $beforeClass property.
	 * @param int $expectedBefore      Value expected for the $before property.
	 * @param int $expectedAfter       Value expected for the $after property.
	 *
	 * @return void
	 */
	public function testHaveFixtureMethodsBeenTriggered( $expectedBeforeClass, $expectedBefore, $expectedAfter ) {
		$this->assertSame(
			$expectedBeforeClass,
			self::$beforeClass,
			"Failed to verify that set_up_before_class() was triggered $expectedBeforeClass time(s). Actual: "
				. self::$beforeClass
		);
		$this->assertSame(
			$expectedBefore,
			self::$before,
			"Failed to verify that set_up() was triggered $expectedBefore time(s). Actual: "
				. self::$before
		);
		$this->assertSame(
			$expectedAfter,
			self::$after,
			"Failed to verify that tear_down() was triggered $expectedAfter time(s). Actual: "
				. self::$after
		);
	}
}
