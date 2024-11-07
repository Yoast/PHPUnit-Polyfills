<?php

namespace Yoast\PHPUnitPolyfills\Tests;

if ( \defined( '__PHPUNIT_PHAR__' ) ) {
	require_once \dirname( __DIR__ ) . '/phpunitpolyfills-autoload.php';

	// phpcs:disable Universal.FunctionDeclarations.NoLongClosures.ExceedsMaximum
	\spl_autoload_register(
		/**
		 * Custom PSR-4 based autoloader for test helper files.
		 *
		 * @param string $fqClassName The name of the class to load.
		 *
		 * @return bool
		 */
		static function ( $fqClassName ) {
			// Only try & load our own classes.
			if ( \stripos( $fqClassName, 'Yoast\PHPUnitPolyfills\Tests\\' ) !== 0 ) {
				return false;
			}

			// Strip namespace prefix 'Yoast\PHPUnitPolyfills\Tests\'.
			$relativeClass = \substr( $fqClassName, 29 );
			$file          = \realpath( __DIR__ ) . \DIRECTORY_SEPARATOR
				. \strtr( $relativeClass, '\\', \DIRECTORY_SEPARATOR ) . '.php';

			if ( \file_exists( $file ) ) {
				include_once $file;
				return true;
			}

			return false;
		}
	);
	// phpcs:enable
}
elseif ( \file_exists( \dirname( __DIR__ ) . '/vendor/autoload.php' ) ) {
	/*
	 * Only load the Composer autoload file when running the tests via a Composer
	 * installed PHPUnit version, otherwise the &@%*& autoloader will block the test run
	 * when the installed PHPUnit version does not match the PHP version of the test run.
	 * Big *sigh*.
	 */
	require_once \dirname( __DIR__ ) . '/vendor/autoload.php';
}
else {
	echo 'Please run `composer install` before attempting to run the tests.';
	exit( 1 );
}

/*
 * Define the constant because our tests are running PHPUnit test cases themselves.
 * This will prevent some tests being marked as "risky" on old PHPUnit versions for
 * closing buffers.
 */
if ( \defined( 'PHPUNIT_TESTSUITE' ) === false ) {
	\define( 'PHPUNIT_TESTSUITE', true );
}
