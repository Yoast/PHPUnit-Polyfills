<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

use Exception;

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
	private array $expectedUserDeprecationMessage = [];

	/**
	 * @var array<string>
	 */
	private array $expectedUserDeprecationMessageRegularExpression = [];

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
	 * @param string $expectedUserDeprecationMessage
	 */
	final protected function expectUserDeprecationMessage($expectedUserDeprecationMessage) {
		$this->expectedUserDeprecationMessage[] = $expectedUserDeprecationMessage;
	}

	/**
	 * @param string $expectedUserDeprecationMessageRegularExpression
	 */
	final protected function expectUserDeprecationMessageMatches($expectedUserDeprecationMessageRegularExpression) {
		$this->expectedUserDeprecationMessageRegularExpression[] = $expectedUserDeprecationMessageRegularExpression;
	}
}
