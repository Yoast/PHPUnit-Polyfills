--TEST--
TestListener test: check that the add_error() method gets called correctly.

--FILE--
<?php
$phpunitVersion = 0;
if ( class_exists( 'PHPUnit\Runner\Version' ) ) {
	$phpunitVersion = PHPUnit\Runner\Version::id();
} elseif ( class_exists( 'PHPUnit_Runner_Version' ) ) {
	$phpunitVersion = PHPUnit_Runner_Version::id();
}
$configFile = version_compare( $phpunitVersion, '10.0.0', '>' ) ? 'phpunit10.xml' : 'phpunit.xml';

$_SERVER['argv'][] = '--do-not-cache-result';
//$_SERVER['argv'][] = '--no-output'; // Should this stay ?
$_SERVER['argv'][] = '--configuration';
$_SERVER['argv'][] = __DIR__ . '/Fixtures/' . $configFile;
$_SERVER['argv'][] = '--filter';
$_SERVER['argv'][] = 'WarningTest';

require __DIR__ . '/../bootstrap.php';

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
   'errorCount' => 0,
   'warningCount' => 1,
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
