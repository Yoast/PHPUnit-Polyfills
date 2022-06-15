<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestCases;

use Yoast\PHPUnitPolyfills\TestCases\XTestCase;

/**
 * Basic test for the PHPUnit version-based TestCase fixture setup.
 *
 * @covers \Yoast\PHPUnitPolyfills\TestCases\XTestCase
 */
final class XTestCaseTest extends XTestCase {

	use TestCaseTestTrait;

	/**
	 * Keep track of how often the PHPUnit native `setUpBeforeClass()` method was called/
	 * called the `set_up_before_class()` method.
	 *
	 * @var int
	 */
	private static $beforeClass = 0;

	/**
	 * Keep track of how often the PHPUnit native `setUp()` method was called/
	 * called the `set_up()` method.
	 *
	 * @var int
	 */
	private static $before = 0;

	/**
	 * Keep track of how often the PHPUnit native `tearDown()` method was called/
	 * called the `tear_down()` method.
	 *
	 * @var int
	 */
	private static $after = 0;

	/**
	 * This method is called before the first test of this test class is run.
	 *
	 * @beforeClass
	 *
	 * @return void
	 */
	public static function setUpFixturesBeforeClass() {
		parent::setUpFixturesBeforeClass();

		++self::$beforeClass;
	}

	/**
	 * This method is called before each test.
	 *
	 * @before
	 *
	 * @return void
	 */
	protected function setUpFixtures() {
		parent::setUpFixtures();

		++self::$before;
	}

	/**
	 * This method is called after each test.
	 *
	 * @after
	 *
	 * @return void
	 */
	protected function tearDownFixtures() {
		++self::$after;

		parent::tearDownFixtures();
	}

	/**
	 * This method is called after the last test of this test class is run.
	 *
	 * @afterClass
	 *
	 * @return void
	 */
	public static function tearDownFixturesAfterClass() {
		// Reset.
		self::$beforeClass = 0;
		self::$before      = 0;
		self::$after       = 0;

		parent::tearDownFixturesAfterClass();
	}

	/**
	 * Test that the fixture method overloads have been triggered and run correctly.
	 *
	 * Note: Can't really test `tearDownFixturesAfterClass()`, but if everything else works, that should too.
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
			"Failed to verify that setUpFixturesBeforeClass() was triggered $expectedBeforeClass time(s). Actual: "
				. self::$beforeClass
		);
		$this->assertSame(
			$expectedBefore,
			self::$before,
			"Failed to verify that setUpFixtures() was triggered $expectedBefore time(s). Actual: "
				. self::$before
		);
		$this->assertSame(
			$expectedAfter,
			self::$after,
			"Failed to verify that tearDownFixtures() was triggered $expectedAfter time(s). Actual: "
				. self::$after
		);
	}
}
