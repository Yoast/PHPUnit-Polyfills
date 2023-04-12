<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use PHPUnit\Framework\TestResult;
use Yoast\PHPUnitPolyfills\Autoload;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\TestListeners\TestListenerDefaultImplementation;
use Yoast\PHPUnitPolyfills\TestListeners\TestListenerSnakeCaseMethods;
use Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures\TestListenerImplementation;

/**
 * Basic test for the PHPUnit version-based TestListenerDefaultImplementation setup.
 *
 * @covers \Yoast\PHPUnitPolyfills\TestListeners\TestListenerDefaultImplementation
 * @covers \Yoast\PHPUnitPolyfills\TestListeners\TestListenerSnakeCaseMethods
 *
 * @requires PHPUnit < 10
 */
#[CoversClass( TestListenerDefaultImplementation::class )]
#[CoversClass( TestListenerSnakeCaseMethods::class )]
#[RequiresPhpunit( '< 10' )]
final class TestListenerTest extends TestCase {

	/**
	 * The current test result instance.
	 *
	 * @var TestResult
	 */
	private $result;

	/**
	 * The applicable test listener instance.
	 *
	 * @var TestListenerImplementation
	 */
	private $listener;

	/**
	 * Set up a test result and add the test listener to it.
	 *
	 * @return void
	 */
	protected function set_up() {
		$this->result   = new TestResult();
		$this->listener = new TestListenerImplementation();

		$this->result->addListener( $this->listener );
	}

	/**
	 * Test that the TestListener add_error() method is called when an exception is thrown.
	 *
	 * @dataProvider dataError
	 *
	 * @param string $class_name The name of the fixture test class to use.
	 *
	 * @return void
	 */
	public function testError( $class_name ) {
		$test = $this->getTestObject( $class_name );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'Test start count failed' );
		$this->assertSame( 1, $this->listener->errorCount, 'Error count failed' );
		$this->assertSame( 0, $this->listener->warningCount, 'Warning count failed' );
		$this->assertSame( 0, $this->listener->failureCount, 'Failure count failed' );
		$this->assertSame( 0, $this->listener->incompleteCount, 'Incomplete count failed' );
		$this->assertSame( 0, $this->listener->riskyCount, 'Risky count failed' );
		$this->assertSame( 0, $this->listener->skippedCount, 'Skipped count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'Test end count failed' );
	}

	/**
	 * Data provider.
	 *
	 * @return array
	 */
	public static function dataError() {
		return [
			'Exception thrown'               => [ 'TestException' ],
			'PHP Error triggered'            => [ 'PHPError' ],
			'PHP User Error triggered'       => [ 'PHPUserError' ],
			'PHP Warning triggered'          => [ 'PHPWarning' ],
			'PHP User Warning triggered'     => [ 'PHPUserWarning' ],
			'PHP Notice triggered'           => [ 'PHPNotice' ],
			'PHP User Notice triggered'      => [ 'PHPUserNotice' ],
			'PHP Deprecation triggered'      => [ 'PHPDeprecation' ],
			'PHP User Deprecation triggered' => [ 'PHPUserDeprecation' ],
		];
	}

	/**
	 * Test that the TestListener add_warning() method is called.
	 *
	 * Note: Prior to PHPUnit 6, PHPUnit did not have `addWarning()` support.
	 * Interestingly enough, it does seem to work on PHPUnit 5, just don't ask me how.
	 *
	 * @requires PHPUnit 5
	 *
	 * @return void
	 */
	#[RequiresPhpunit( '5' )]
	public function testWarning() {
		$test = $this->getTestObject( 'Warning' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'Test start count failed' );
		$this->assertSame( 0, $this->listener->errorCount, 'Error count failed' );
		$this->assertSame( 1, $this->listener->warningCount, 'Warning count failed' );
		$this->assertSame( 0, $this->listener->failureCount, 'Failure count failed' );
		$this->assertSame( 0, $this->listener->incompleteCount, 'Incomplete count failed' );
		$this->assertSame( 0, $this->listener->riskyCount, 'Risky count failed' );
		$this->assertSame( 0, $this->listener->skippedCount, 'Skipped count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'Test end count failed' );
	}

	/**
	 * Test that the TestListener add_failure() method is called.
	 *
	 * @return void
	 */
	public function testFailure() {
		$test = $this->getTestObject( 'Failure' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'Test start count failed' );
		$this->assertSame( 0, $this->listener->errorCount, 'Error count failed' );
		$this->assertSame( 0, $this->listener->warningCount, 'Warning count failed' );
		$this->assertSame( 1, $this->listener->failureCount, 'Failure count failed' );
		$this->assertSame( 0, $this->listener->incompleteCount, 'Incomplete count failed' );
		$this->assertSame( 0, $this->listener->riskyCount, 'Risky count failed' );
		$this->assertSame( 0, $this->listener->skippedCount, 'Skipped count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'Test end count failed' );
	}

	/**
	 * Test that the TestListener add_incomplete_test() method is called.
	 *
	 * @return void
	 */
	public function testIncomplete() {
		$test = $this->getTestObject( 'Incomplete' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'Test start count failed' );
		$this->assertSame( 0, $this->listener->errorCount, 'Error count failed' );
		$this->assertSame( 0, $this->listener->warningCount, 'Warning count failed' );
		$this->assertSame( 0, $this->listener->failureCount, 'Failure count failed' );
		$this->assertSame( 1, $this->listener->incompleteCount, 'Incomplete count failed' );
		$this->assertSame( 0, $this->listener->riskyCount, 'Risky count failed' );
		$this->assertSame( 0, $this->listener->skippedCount, 'Skipped count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'Test end count failed' );
	}

	/**
	 * Test that the TestListener add_risky_test() method is called.
	 *
	 * Note: It appears that the PHPUnit native recording of risky tests prior to PHPUnit 6 is buggy.
	 *
	 * @requires PHPUnit 6
	 *
	 * @return void
	 */
	#[RequiresPhpunit( '6' )]
	public function testRisky() {
		$test = $this->getTestObject( 'Risky' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'Test start count failed' );
		$this->assertSame( 0, $this->listener->errorCount, 'Error count failed' );
		$this->assertSame( 0, $this->listener->warningCount, 'Warning count failed' );
		$this->assertSame( 0, $this->listener->failureCount, 'Failure count failed' );
		$this->assertSame( 0, $this->listener->incompleteCount, 'Incomplete count failed' );
		$this->assertSame( 1, $this->listener->riskyCount, 'Risky count failed' );
		$this->assertSame( 0, $this->listener->skippedCount, 'Skipped count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'Test end count failed' );
	}

	/**
	 * Test that the TestListener add_skipped_test() method is called.
	 *
	 * @return void
	 */
	public function testSkipped() {
		$test = $this->getTestObject( 'Skipped' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'Test start count failed' );
		$this->assertSame( 0, $this->listener->errorCount, 'Error count failed' );
		$this->assertSame( 0, $this->listener->warningCount, 'Warning count failed' );
		$this->assertSame( 0, $this->listener->failureCount, 'Failure count failed' );
		$this->assertSame( 0, $this->listener->incompleteCount, 'Incomplete count failed' );
		$this->assertSame( 0, $this->listener->riskyCount, 'Risky count failed' );
		$this->assertSame( 1, $this->listener->skippedCount, 'Skipped count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'Test end count failed' );
	}

	/**
	 * Test that the TestListener start_test() and end_test() methods are called.
	 *
	 * @return void
	 */
	public function testStartStop() {
		$test = $this->getTestObject( 'Success' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'Test start count failed' );
		$this->assertSame( 0, $this->listener->errorCount, 'Error count failed' );
		$this->assertSame( 0, $this->listener->warningCount, 'Warning count failed' );
		$this->assertSame( 0, $this->listener->failureCount, 'Failure count failed' );
		$this->assertSame( 0, $this->listener->incompleteCount, 'Incomplete count failed' );
		$this->assertSame( 0, $this->listener->riskyCount, 'Risky count failed' );
		$this->assertSame( 0, $this->listener->skippedCount, 'Skipped count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'Test end count failed' );
	}

	/**
	 * Helper method to get the right Test class object.
	 *
	 * Toggles between different versions of the same Test class object:
	 * - Base version using `runTest()` method, compatible with PHPUnit < 10.0.
	 * - Version using `testForListener()` method, compatible with PHPUnit > 7.0.
	 *
	 * @param string $className Base class name of the test class to instantiate.
	 *
	 * @return PHPUnitTestCase
	 */
	private function getTestObject( $className ) {
		$className = '\Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures\\' . $className;
		$testName  = 'runTest';

		if ( \version_compare( Autoload::getPHPUnitVersion(), '7.0.0', '>=' ) ) {
			$className .= 'PHPUnitGte7';
			$testName   = 'testForListener';
		}

		return new $className( $testName );
	}
}
