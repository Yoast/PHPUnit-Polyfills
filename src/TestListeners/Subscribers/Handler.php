<?php

namespace Yoast\PHPUnitPolyfills\TestListeners\Subscribers;

use PHPUnit\Framework\AssertionFailedError;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;
use PHPUnit\Framework\Warning;

final class Handler {
	/**
	 * Handler constructor.
	 *
	 * @param object $testListener Instance of the class which functions as the "test listener".
	 */
	public function __construct(private readonly object $testListener)
	{
	}

	public function addError(Test $test, Throwable $t, float $time): void
	{
		$this->testListener->addError(
			$test,
			$t,
			$time
		);
	}

	public function addWarning(Test $test, Warning $e, float $time): void
	{
		$this->testListener->addWarning(
			$test,
			$e,
			$time
		);
	}

	public function addFailure(Test $test, AssertionFailedError $e, float $time): void
	{
		$this->testListener->addFailure(
			$test,
			$e,
			$time
		);
	}

	public function addIncompleteTest(Test $test, Throwable $t, float $time): void
	{
		$this->testListener->addIncompleteTest(
			$test,
			$t,
			$time
		);
	}

	public function addRiskyTest(Test $test, Throwable $t, float $time): void
	{
		$this->testListener->addRiskyTest(
			$test,
			$t,
			$time
		);
	}

	public function addSkippedTest(Test $test, Throwable $t, float $time): void
	{
		$this->testListener->addSkippedTest(
			$test,
			$t,
			$time
		);
	}

	public function startTestSuite(TestSuite $suite): void
	{
		$this->testListener->startTestSuite($suite);
	}

	public function endTestSuite(TestSuite $suite): void
	{
		$this->testListener->endTestSuite($suite);
	}

	public function startTest(Test $test): void
	{
		$this->testListener->startTest($test);
	}

	public function endTest(Test $test, float $time): void
	{
		$this->testListener->endTest(
			$test,
			$time
		);
	}
}
