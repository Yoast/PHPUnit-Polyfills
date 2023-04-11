--TEST--
TestListener test: check that the add_error() method gets called correctly.

--SKIPIF--
<?php
if ( file_exists( __DIR__ . '/../../vendor/autoload.php' ) === false ) {
	print 'skip: Test can only be run in a Composer installed environment as otherwise there is no accces to the PHPUnit classes.';
}

// NOT WORKING: Make sure the Composer install is up to date for the PHP version on which the tests are being run.
try {

	require_once __DIR__ . '/../../vendor/autoload.php';
} catch ( Exception $e ) {
	print 'skip: Test can only be run in an up-to-date Composer installed environment. Version mismatch detected, please run `composer update`.';
}

--FILE--
<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$phpunitVersion = 0;
if ( class_exists( 'PHPUnit\Runner\Version' ) ) {
	$phpunitVersion = PHPUnit\Runner\Version::id();
} elseif ( class_exists( 'PHPUnit_Runner_Version' ) ) {
	$phpunitVersion = PHPUnit_Runner_Version::id();
}
//var_dump($phpunitVersion);
$configFile = version_compare( $phpunitVersion, '10.0.0', '>' ) ? 'phpunit10.xml' : 'phpunit.xml';

//var_dump(get_declared_classes());


$_SERVER['argv'][] = '--do-not-cache-result';
//$_SERVER['argv'][] = '--no-output'; // Should this stay ?
$_SERVER['argv'][] = '--configuration';
$_SERVER['argv'][] = __DIR__ . '/Fixtures/' . $configFile;
$_SERVER['argv'][] = '--filter';
$_SERVER['argv'][] = 'ErrorTest';

//require __DIR__ . '/../bootstrap.php';

// Need toggle for different PHPUnit versions
if (class_exists('PHPUnit_TextUI_Command')) {
	// PHPUnit 5.x.
	PHPUnit_TextUI_Command::main();
} elseif (class_exists('PHPUnit\TextUI\Command')) {
	// PHPUnit 6.x - 9.x.
	PHPUnit\TextUI\Command::main();
} elseif (class_exists('PHPUnit\TextUI\Application')) {
	// PHPUnit 10.x.
	(new PHPUnit\TextUI\Application)->run($_SERVER['argv']);
}

--EXPECTREGEX--
=====================
\\?Yoast\\PHPUnitPolyfills\\Tests\\EndToEnd\\TestListeners\\Fixtures\\TestListenerImplementation::__set_state\(array\(
   'errorCount' => 1,
   'warningCount' => 0,
   'failureCount' => 0,
   'incompleteCount' => 0,
   'riskyCount' => 0,
   'skippedCount' => 0,
   'startSuiteCount' => 3,
   'endSuiteCount' => 3,
   'startTestCount' => 1,
   'endTestCount' => 1,
\)\)
=====================
