<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use Exception;
use PHPUnit\Framework\TestCase;

/**
 * Fixture to generate a test error to pass to the test listener.
 *
 * @requires PHPUnit 7.0
 */
class PHPDeprecationPHPUnitGte7 extends TestCase {

	/**
	 * Test resulting in a PHP deprecation notice.
	 *
	 * @return void
	 *
	 * @throws Exception For test purposes.
	 */
	protected function testForListener() {
		/*
		 * Trigger PHP features which were deprecated in various PHP versions.
		 * phpcs:disable Squiz.PHP.Eval.Discouraged -- See inline comments for the reasons.
		 */
		switch ( \PHP_MAJOR_VERSION ) {
			case 5:
				// Assigning the return value of new by reference is deprecated.
				// Wrapping this in an `eval()` to prevent it being seen as a file parse error in PHP 7/8.
				eval( '$obj = & new \ReflectionObject();' );
				break;

			case 7:
				// password_hash(): Use of the 'salt' option to password_hash is deprecated.
				\password_hash( 'foo', \PASSWORD_DEFAULT, [ 'salt' => 'usesomesillystringforsalt' ] );
				break;

			case 8:
				// Optional parameter $optional declared before required parameter $required.
				// Wrapping this in an `eval()` as the deprecation is thrown at compiled time, not runtime.
				eval( 'function intentionallyWrong($optional = true, $required) {}' );

				break;
		}
		// phpcs:enable
	}
}
