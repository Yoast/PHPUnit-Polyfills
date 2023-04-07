<?php

namespace Yoast\PHPUnitPolyfills\TestListeners;

use PHPUnit\Event\Code\Test;
use PHPUnit\Event\Code\Throwable;
use PHPUnit\Event\Telemetry\HRTime;
use PHPUnit\Event\TestSuite\TestSuite;
use PHPUnit\Runner\Extension\Facade;
use PHPUnit\Runner\Extension\ParameterCollection;
use PHPUnit\TextUI\Configuration\Configuration;
use RuntimeException;

/**
 * Basic event based TestListener implementation for use with PHPUnit >= 10.x.
 *
 * This TestListener trait uses renamed (snakecase) methods for all standard methods in
 * a TestListener to get round the method signature changes in various PHPUnit versions.
 *
 * When using this TestListener trait, the snake_case method names need to be used to implement
 * the listener functionality.
 *
 * Also, please carefully read the instructions in the project README about cross-version
 * considerations and issues when using TestListeners.
 */
trait TestListenerDefaultImplementation {

	use TestListenerSnakeCaseMethods;

	/**
	 * Cache for test start times.
	 *
	 * @var array<string, HRTime> Key is the test ID.
	 */
	private $preparedTests = [];

	/**
	 * Bootstrap for using the test listener as an extension.
	 *
	 * @param Configuration       $configuration Test run configuration object.
	 * @param Facade              $facade        Extension Facade object.
	 * @param ParameterCollection $parameters    Extension ParameterCollection object.
	 */
	public function bootstrap( Configuration $configuration, Facade $facade, ParameterCollection $parameters ): void {
        $handler = new Handler( $this );
        
		$facade->registerSubscribers(
			new Subscribers\AddErrorSubscriber( $handler ),
// Note: unsure if the WarningTriggered subscriber is correct/comparable to before.
			new Subscribers\AddWarningSubscriber( $handler ),
			new Subscribers\AddFailureSubscriber( $handler ),
			new Subscribers\AddIncompleteSubscriber( $handler ),
			new Subscribers\AddRiskySubscriber( $handler ),
			new Subscribers\AddSkippedSubscriber( $handler ),
			new Subscribers\StartTestSubscriber( $handler ),
			new Subscribers\EndTestSubscriber( $handler ),
			new Subscribers\StartTestSuiteSubscriber( $handler ),
			new Subscribers\EndTestSuiteSubscriber( $handler )
		);
	}

	/**
	 * An error occurred.
	 *
	 * @param Test      $test Test object.
	 * @param Throwable $t    Instance of the error encountered.
	 * @param HRTime    $time Execution time of this test.
	 */
	public function addError( Test $test, Throwable $t, HRTime $time ): void {
		$this->add_error( $test, $t, $this->getDuration( $test, $time ) );
	}

	/**
	 * A warning occurred.
	 *
	 * This method is only functional in PHPUnit 6.0 and above.
	 *
	 * @param Test    $test Test object.
	 * @param Warning $e    Instance of the warning encountered.
	 * @param HRTime  $time Execution time of this test.
	 */
	public function addWarning( Test $test, Warning $e, HRTime $time ): void {
// Note: WarningTriggered does not have a throwable() method... ?
// As there is no support in PHPUnit < 6.0 either, one option would be to not support this in the PHPUnit 10+ implementation either.
		$this->add_warning( $test, $e, $this->getDuration( $test, $time ) );
	}

	/**
	 * A failure occurred.
	 *
	 * @param Test      $test Test object.
	 * @param Throwable $e    Instance of the failure exception.
	 * @param HRTime    $time Execution time of this test.
	 */
	public function addFailure( Test $test, Throwable $e, HRTime $time ): void {
		$this->add_failure( $test, $e, $this->getDuration( $test, $time ) );
	}

	/**
	 * Incomplete test.
	 *
	 * @param Test      $test Test object.
	 * @param Throwable $t    Instance of the incomplete test exception.
	 * @param HRTime    $time Execution time of this test.
	 */
	public function addIncompleteTest( Test $test, Throwable $t, HRTime $time ): void {
		$this->add_incomplete_test( $test, $t, $this->getDuration( $test, $time ) );
	}

	/**
	 * Risky test.
	 *
	 * @param Test      $test Test object.
	 * @param Throwable $t    Instance of the risky test exception.
	 * @param HRTime    $time Execution time of this test.
	 */
	public function addRiskyTest( Test $test, Throwable $t, HRTime $time ): void {
		$this->add_risky_test( $test, $t, $this->getDuration( $test, $time ) );
	}

	/**
	 * Skipped test.
	 *
	 * @param Test      $test Test object.
	 * @param Throwable $t    Instance of the skipped test exception.
	 * @param HRTime    $time Execution time of this test.
	 */
	public function addSkippedTest( Test $test, Throwable $t, HRTime $time ): void {
		$this->add_skipped_test( $test, $t, $this->getDuration( $test, $time ) );
	}

	/**
	 * A test suite started.
	 *
	 * @param TestSuite $suite Test suite object.
	 */
	public function startTestSuite( TestSuite $suite ): void {
		$this->start_test_suite( $suite );
	}

	/**
	 * A test suite ended.
	 *
	 * @param TestSuite $suite Test suite object.
	 */
	public function endTestSuite( TestSuite $suite ): void {
		$this->end_test_suite( $suite );
	}

	/**
	 * A test started.
	 *
	 * @param Test   $test Test object.
	 * @param HRTime $time Start time of the test.
	 *
	 * @throws RuntimeException For an edge case which should never happen.
	 */
	public function startTest( Test $test, HRTime $time ): void {
		if ( \array_key_exists( $test->id(), $this->preparedTests ) ) {
			throw new RuntimeException( 'This should not happen.' );
		}

		$this->preparedTests[ $test->id() ] = $time;

		$this->start_test( $test );
	}

	/**
	 * A test ended.
	 *
	 * @param Test   $test Test object.
	 * @param HRTime $time Execution time of this test.
	 */
	public function endTest( Test $test, HRTime $time ): void {
		$time = $this->getDuration( $test, $time );

		unset( $this->preparedTests[ $test->id() ] );

		$this->end_test( $test, $time );
	}

	/**
	 * Retrieve the test duration.
	 *
	 * @param Test   $test Test object.
	 * @param HRTime $end  Execution time.
	 *
	 * @throws RuntimeException For an edge case which should never happen.
	 */
	private function getDuration( Test $test, HRTime $end ): float {
		if ( \array_key_exists( $test->id(), $this->preparedTests ) === false ) {
			throw new RuntimeException( 'This should not happen.' );
		}

		$duration = $end->duration( $this->preparedTests[ $test->id() ] );

		return $duration->asFloat();
	}
}
