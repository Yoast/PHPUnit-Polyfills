<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

use Exception;
use PHPUnit\Framework\Attributes\PostCondition;
use PHPUnit\Framework\ExpectationFailedException;

/**
 * Polyfill the TestCase::expectExceptionObject() method.
 *
 * Introduced in PHPUnit 11.0.0.
 *
 * @link https://github.com/sebastianbergmann/phpunit/pull/5605
 */
trait ExpectUserDeprecation {

	/**
	 * @var array<string>
	 */
	private $expectedUserDeprecationMessage = [];

	/**
	 * @var array<string>
	 */
	private $expectedUserDeprecationMessageRegularExpression = [];

	private $errorHandlerAttached = false;

	/**
	 * Set expectations for an expected Exception based on an Exception object.
	 *
	 * @param Exception $exception Exception object.
	 *
	 * @return void
	 * /
	final public function expectUserDeprecationMessage( Exception $exception ) {
		$this->expectException( \get_class( $exception ) );
		$this->expectExceptionMessage( $exception->getMessage() );
		$this->expectExceptionCode( $exception->getCode() );
	}

	/**
	 * @return void
	 */
	protected function attachErrorHandler() {
		if ( $this->errorHandlerAttached === false ) {
			// attach.
			$this->errorHandlerAttached = true;
		}
	}

	/**
	 * @after
	 *
	 * @return void
	 */
	protected function detachErrorHandler() {
		if ( $this->errorHandlerAttached === true ) {
			// detach.
		}
	}

	/**
	 * @param string $expectedUserDeprecationMessage
	 *
	 * @return void
	 */
	final protected function expectUserDeprecationMessage( $expectedUserDeprecationMessage ) {
		$this->attachErrorHandler();

		$this->expectedUserDeprecationMessage[] = $expectedUserDeprecationMessage;
	}

	/**
	 * @param string $expectedUserDeprecationMessageRegularExpression
	 *
	 * @return void
	 */
	final protected function expectUserDeprecationMessageMatches( $expectedUserDeprecationMessageRegularExpression ) {
		$this->attachErrorHandler();
		$this->expectedUserDeprecationMessageRegularExpression[] = $expectedUserDeprecationMessageRegularExpression;
	}

	/**
	 *
	 *
	 * @return void
	 *
	 * @throws ExpectationFailedException
	 */
	#[PostCondition]
	// function assertPostConditions()
	protected function verifyDeprecationExpectations() {
		foreach ( $this->expectedUserDeprecationMessage as $deprecationExpectation ) {
			++$this->numberOfAssertionsPerformed;

			if ( \in_array( $deprecationExpectation, DeprecationCollector::deprecations(), true ) === false ) {
				throw new ExpectationFailedException(
					\sprintf(
						'Expected deprecation with message "%s" was not triggered',
						$deprecationExpectation
					)
				);
			}
		}

		foreach ( $this->expectedUserDeprecationMessageRegularExpression as $deprecationExpectation ) {
			++$this->numberOfAssertionsPerformed;

			$expectedDeprecationTriggered = false;

			foreach ( DeprecationCollector::deprecations() as $deprecation ) {
				// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
				if ( @\preg_match( $deprecationExpectation, $deprecation ) > 0 ) {
					$expectedDeprecationTriggered = true;

					break;
				}
			}

			if ( ! $expectedDeprecationTriggered ) {
				throw new ExpectationFailedException(
					\sprintf(
						'Expected deprecation with message matching regular expression "%s" was not triggered',
						$deprecationExpectation
					)
				);
			}
		}
	}
}
