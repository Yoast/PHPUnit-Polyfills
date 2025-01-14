<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use PHPUnit\Framework\TestResult;
use Yoast\PHPUnitPolyfills\TestCases\TestCase;
use Yoast\PHPUnitPolyfills\TestListeners\TestListenerDefaultImplementation;
use Yoast\PHPUnitPolyfills\TestListeners\TestListenerSnakeCaseMethods;
use Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures\Failure;
use Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures\Incomplete;
use Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures\Risky;
use Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures\Skipped;
use Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures\Success;
use Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures\TestError;
use Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures\TestListenerImplementation;
use Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures\Warning;

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
	 * Test that the TestListener add_error() method is called.
	 *
	 * @return void
	 */
	public function testError() {
		$test = new TestError( 'testForListener' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'test start count failed' );
		$this->assertSame( 1, $this->listener->errorCount, 'error count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'test end count failed' );
	}

	/**
	 * Test that the TestListener add_warning() method is called.
	 *
	 * @return void
	 */
	public function testWarning() {
		$test = new Warning( 'testForListener' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'test start count failed' );
		$this->assertSame( 1, $this->listener->warningCount, 'warning count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'test end count failed' );
	}

	/**
	 * Test that the TestListener add_failure() method is called.
	 *
	 * @return void
	 */
	public function testFailure() {
		$test = new Failure( 'testForListener' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'test start count failed' );
		$this->assertSame( 1, $this->listener->failureCount, 'failure count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'test end count failed' );
	}

	/**
	 * Test that the TestListener add_incomplete_test() method is called.
	 *
	 * @return void
	 */
	public function testIncomplete() {
		$test = new Incomplete( 'testForListener' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'test start count failed' );
		$this->assertSame( 1, $this->listener->incompleteCount, 'incomplete count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'test end count failed' );
	}

	/**
	 * Test that the TestListener add_risky_test() method is called.
	 *
	 * @return void
	 */
	public function testRisky() {
		$test = new Risky( 'testForListener' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'test start count failed' );
		$this->assertSame( 1, $this->listener->riskyCount, 'risky count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'test end count failed' );
	}

	/**
	 * Test that the TestListener add_skipped_test() method is called.
	 *
	 * @return void
	 */
	public function testSkipped() {
		$test = new Skipped( 'testForListener' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'test start count failed' );
		$this->assertSame( 1, $this->listener->skippedCount, 'skipped count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'test end count failed' );
	}

	/**
	 * Test that the TestListener start_test() and end_test() methods are called.
	 *
	 * @return void
	 */
	public function testStartStop() {
		$test = new Success( 'testForListener' );
		$test->run( $this->result );

		$this->assertSame( 1, $this->listener->startTestCount, 'test start count failed' );
		$this->assertSame( 1, $this->listener->endTestCount, 'test end count failed' );
	}
}
