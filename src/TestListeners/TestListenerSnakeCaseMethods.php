<?php

namespace Yoast\PHPUnitPolyfills\TestListeners;

use Exception;
use PHPUnit\Event\Code\Test as ImmutableTest;
use PHPUnit\Event\Code\Throwable as ImmutableThrowable;
use PHPUnit\Event\TestSuite\TestSuite as ImmutableTestSuite;
use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;
use Throwable;

/**
 * Renamed snake_case TestListener method collection used by the TestListenerDefaultImplementation traits.
 */
trait TestListenerSnakeCaseMethods {

	/**
	 * An error occurred.
	 *
	 * @param Test|ImmutableTest                     $test Test object.
	 * @param Exception|Throwable|ImmutableThrowable $e    Instance of the error encountered.
	 * @param float                                  $time Execution time of this test.
	 *
	 * @return void
	 */
	public function add_error( $test, $e, $time ) {}

	/**
	 * A warning occurred.
	 *
	 * This method is only functional in PHPUnit 6.0 and above.
	 *
	 * @param Test    $test Test object.
	 * @param Warning $e    Instance of the warning encountered.
	 * @param float   $time Execution time of this test.
	 *
	 * @return void
	 */
	public function add_warning( $test, $e, $time ) {}

	/**
	 * A failure occurred.
	 *
	 * @param Test|ImmutableTest                      $test Test object.
	 * @param AssertionFailedError|ImmutableThrowable $e    Instance of the failure encountered.
	 * @param float                                   $time Execution time of this test.
	 *
	 * @return void
	 */
	public function add_failure( $test, $e, $time ) {}

	/**
	 * Incomplete test.
	 *
	 * @param Test|ImmutableTest                     $test Test object.
	 * @param Exception|Throwable|ImmutableThrowable $e    Instance of the incomplete test exception.
	 * @param float                                  $time Execution time of this test.
	 *
	 * @return void
	 */
	public function add_incomplete_test( $test, $e, $time ) {}

	/**
	 * Risky test.
	 *
	 * @param Test|ImmutableTest                     $test Test object.
	 * @param Exception|Throwable|ImmutableThrowable $e    Instance of the risky test exception.
	 * @param float                                  $time Execution time of this test.
	 *
	 * @return void
	 */
	public function add_risky_test( $test, $e, $time ) {}

	/**
	 * Skipped test.
	 *
	 * @param Test|ImmutableTest                     $test Test object.
	 * @param Exception|Throwable|ImmutableThrowable $e    Instance of the skipped test exception.
	 * @param float                                  $time Execution time of this test.
	 *
	 * @return void
	 */
	public function add_skipped_test( $test, $e, $time ) {}

	/**
	 * A test suite started.
	 *
	 * @param TestSuite|ImmutableTestSuite $suite Test suite object.
	 *
	 * @return void
	 */
	public function start_test_suite( $suite ) {}

	/**
	 * A test suite ended.
	 *
	 * @param TestSuite|ImmutableTestSuite $suite Test suite object.
	 *
	 * @return void
	 */
	public function end_test_suite( $suite ) {}

	/**
	 * A test started.
	 *
	 * @param Test|ImmutableTest $test Test object.
	 *
	 * @return void
	 */
	public function start_test( $test ) {}

	/**
	 * A test ended.
	 *
	 * @param Test|ImmutableTest $test Test object.
	 * @param float              $time Execution time of this test.
	 *
	 * @return void
	 */
	public function end_test( $test, $time ) {}
}
