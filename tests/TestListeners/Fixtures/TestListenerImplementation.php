<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestListener;
use Yoast\PHPUnitPolyfills\TestListeners\TestListenerDefaultImplementation;

/**
 * TestListener implementation for testing the TestListener cross-version
 * TestListenerDefaultImplementation trait.
 */
class TestListenerImplementation implements TestListener {

	use TestListenerDefaultImplementation;

	/**
	 * Track how many errors have been encountered.
	 *
	 * @var int
	 */
	private $errorCount = 0;

	/**
	 * Track how many warnings have been encountered.
	 *
	 * @var int
	 */
	private $warningCount = 0;

	/**
	 * Track how many failures have been encountered.
	 *
	 * @var int
	 */
	private $failureCount = 0;

	/**
	 * Track how many incomplete tests have been encountered.
	 *
	 * @var int
	 */
	private $incompleteCount = 0;

	/**
	 * Track how many risky tests have been encountered.
	 *
	 * @var int
	 */
	private $riskyCount = 0;

	/**
	 * Track how many skipped tests have been encountered.
	 *
	 * @var int
	 */
	private $skippedCount = 0;

	/**
	 * Track how many tests have been started.
	 *
	 * @var int
	 */
	private $startTestCount = 0;

	/**
	 * Track how many tests have ended.
	 *
	 * @var int
	 */
	private $endTestCount = 0;

	/**
	 * An error occurred.
	 *
	 * @param Test                $test Test object.
	 * @param Exception|Throwable $e    Instance of the error encountered.
	 * @param float               $time Execution time of this test.
	 */
	public function add_error( $test, $e, $time ) {
		++$this->errorCount;
	}

	/**
	 * A warning occurred.
	 *
	 * @param Test    $test Test object.
	 * @param Warning $e    Instance of the warning encountered.
	 * @param float   $time Execution time of this test.
	 */
	public function add_warning( $test, $e, $time ) {
		++$this->warningCount;
	}

	/**
	 * A failure occurred.
	 *
	 * @param Test                 $test Test object.
	 * @param AssertionFailedError $e    Instance of the assertion failure exception encountered.
	 * @param float                $time Execution time of this test.
	 */
	public function add_failure( $test, $e, $time ) {
		++$this->failureCount;
	}

	/**
	 * Incomplete test.
	 *
	 * @param Test                $test Test object.
	 * @param Exception|Throwable $e    Instance of the incomplete test exception.
	 * @param float               $time Execution time of this test.
	 */
	public function add_incomplete_test( $test, $e, $time ) {
		++$this->incompleteCount;
	}

	/**
	 * Risky test.
	 *
	 * @param Test                $test Test object.
	 * @param Exception|Throwable $e    Instance of the risky test exception.
	 * @param float               $time Execution time of this test.
	 */
	public function add_risky_test( $test, $e, $time ) {
		++$this->riskyCount;
	}

	/**
	 * Skipped test.
	 *
	 * @param Test                $test Test object.
	 * @param Exception|Throwable $e    Instance of the skipped test exception.
	 * @param float               $time Execution time of this test.
	 */
	public function add_skipped_test( $test, $e, $time ) {
		++$this->skippedCount;
	}

	/**
	 * A test started.
	 *
	 * @param Test $test Test object.
	 */
	public function start_test( $test ) {
		++$this->startTestCount;
	}

	/**
	 * A test ended.
	 *
	 * @param Test  $test Test object.
	 * @param float $time Execution time of this test.
	 */
	public function end_test( $test, $time ) {
		++$this->endTestCount;
	}

	/**
	 * Getter to retrieve the values of the properties.
	 *
	 * @param string $name Property name.
	 *
	 * @return mixed|null The property value or null if the property does not exist.
	 */
	public function __get( $name ) {
		if ( isset( $this->{$name} ) ) {
			return $this->{$name};
		}

		return null;
	}
}
