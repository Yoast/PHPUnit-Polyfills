<?php

namespace Yoast\PHPUnitPolyfills\Tests;

if ( \defined( '__PHPUNIT_PHAR__' ) ) {
	require_once \dirname( __DIR__ ) . '/phpunitpolyfills-autoload.php';

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
	die( 1 );
}

/*
 * Create a number of class aliases for PHPUnit native classes which have been
 * renamed over time and are only used in the unit tests.
 */
if ( \class_exists( 'PHPUnit_Runner_Version' ) === true
	&& \class_exists( 'PHPUnit\Runner\Version' ) === false
) {
	\class_alias( 'PHPUnit_Runner_Version', 'PHPUnit\Runner\Version' );
}

if ( \class_exists( 'PHPUnit_Framework_TestResult' ) === true
	&& \class_exists( 'PHPUnit\Framework\TestResult' ) === false
) {
	\class_alias( 'PHPUnit_Framework_TestResult', 'PHPUnit\Framework\TestResult' );
}
