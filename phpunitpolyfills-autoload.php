<?php

namespace Yoast\PHPUnitPolyfills;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use PHPUnit\Runner\Version as PHPUnit_Version;

if ( \class_exists( 'Yoast\PHPUnitPolyfills\Autoload', false ) === false ) {

	/**
	 * Custom autoloader.
	 *
	 * @since 0.1.0
	 */
	final class Autoload {

		/**
		 * Version number.
		 *
		 * @since 1.0.1
		 *
		 * @var string
		 */
		const VERSION = '3.1.1';

		/**
		 * Loads a class.
		 *
		 * @param string $className The name of the class to load.
		 *
		 * @return bool
		 */
		public static function load( $className ) {
			// Only load classes belonging to this library.
			if ( \stripos( $className, 'Yoast\PHPUnitPolyfills' ) !== 0 ) {
				return false;
			}

			switch ( $className ) {
				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertIsType':
					self::loadAssertIsType();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains':
					self::loadAssertStringContains();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertEqualsSpecializations':
					self::loadAssertEqualsSpecializations();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches':
					self::loadExpectExceptionMessageMatches();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertFileEqualsSpecializations':
					self::loadAssertFileEqualsSpecializations();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\EqualToSpecializations':
					self::loadEqualToSpecializations();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames':
					self::loadAssertionRenames();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource':
					self::loadAssertClosedResource();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals':
					self::loadAssertObjectEquals();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertIsList':
					self::loadAssertIsList();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertIgnoringLineEndings':
					self::loadAssertIgnoringLineEndings();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertObjectProperty':
					self::loadAssertObjectProperty();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertArrayWithListKeys':
					self::loadAssertArrayWithListKeys();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation':
					self::loadExpectUserDeprecation();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertObjectNotEquals':
					self::loadAssertObjectNotEquals();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertContainsOnly':
					self::loadAssertContainsOnly();
					return true;

				case 'Yoast\PHPUnitPolyfills\TestCases\TestCase':
					self::loadTestCase();
					return true;

				case 'Yoast\PHPUnitPolyfills\TestListeners\TestListenerDefaultImplementation':
					self::loadTestListenerDefaultImplementation();
					return true;

				/*
				 * Handles:
				 * - Yoast\PHPUnitPolyfills\Exceptions\InvalidComparisonMethodException
				 * - Yoast\PHPUnitPolyfills\Helpers\ComparatorValidator
				 * - Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
				 * - Yoast\PHPUnitPolyfills\TestCases\XTestCase
				 * - Yoast\PHPUnitPolyfills\TestListeners\TestListenerSnakeCaseMethods
				 */
				default:
					$file = \realpath( __DIR__ . '/src/' . \strtr( \substr( $className, 23 ), '\\', '/' ) . '.php' );

					if ( \is_string( $file ) && \file_exists( $file ) === true ) {
						require_once $file;
						return true;
					}
			}

			return false;
		}

		/**
		 * Load the AssertIsType polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertIsType() {
			if ( \method_exists( Assert::class, 'assertIsArray' ) === false ) {
				// PHPUnit < 7.5.0.
				require_once __DIR__ . '/src/Polyfills/AssertIsType.php';
				return;
			}

			// PHPUnit >= 7.5.0.
			require_once __DIR__ . '/src/Polyfills/AssertIsType_Empty.php';
		}

		/**
		 * Load the AssertStringContains polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertStringContains() {
			if ( \method_exists( Assert::class, 'assertStringContainsString' ) === false ) {
				// PHPUnit < 7.5.0.
				require_once __DIR__ . '/src/Polyfills/AssertStringContains.php';
				return;
			}

			// PHPUnit >= 7.5.0.
			require_once __DIR__ . '/src/Polyfills/AssertStringContains_Empty.php';
		}

		/**
		 * Load the AssertEqualsSpecializations polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertEqualsSpecializations() {
			if ( \method_exists( Assert::class, 'assertEqualsWithDelta' ) === false ) {
				// PHPUnit < 7.5.0.
				require_once __DIR__ . '/src/Polyfills/AssertEqualsSpecializations.php';
				return;
			}

			// PHPUnit >= 7.5.0.
			require_once __DIR__ . '/src/Polyfills/AssertEqualsSpecializations_Empty.php';
		}

		/**
		 * Load the ExpectExceptionMessageMatches polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadExpectExceptionMessageMatches() {
			if ( \method_exists( TestCase::class, 'expectExceptionMessageMatches' ) === false ) {
				// PHPUnit < 8.4.0.
				require_once __DIR__ . '/src/Polyfills/ExpectExceptionMessageMatches.php';
				return;
			}

			// PHPUnit >= 8.4.0.
			require_once __DIR__ . '/src/Polyfills/ExpectExceptionMessageMatches_Empty.php';
		}

		/**
		 * Load the AssertFileEqualsSpecializations polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertFileEqualsSpecializations() {
			if ( \method_exists( Assert::class, 'assertFileEqualsIgnoringCase' ) === false ) {
				// PHPUnit < 8.5.0.
				require_once __DIR__ . '/src/Polyfills/AssertFileEqualsSpecializations.php';
				return;
			}

			// PHPUnit >= 8.5.0.
			require_once __DIR__ . '/src/Polyfills/AssertFileEqualsSpecializations_Empty.php';
		}

		/**
		 * Load the EqualToSpecializations polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadEqualToSpecializations() {
			if ( \method_exists( Assert::class, 'equalToWithDelta' ) === false ) {
				// PHPUnit < 9.0.0.
				require_once __DIR__ . '/src/Polyfills/EqualToSpecializations.php';
				return;
			}

			// PHPUnit >= 9.0.0.
			require_once __DIR__ . '/src/Polyfills/EqualToSpecializations_Empty.php';
		}

		/**
		 * Load the AssertionRenames polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertionRenames() {
			if ( \method_exists( Assert::class, 'assertMatchesRegularExpression' ) === false ) {
				// PHPUnit < 9.1.0.
				require_once __DIR__ . '/src/Polyfills/AssertionRenames.php';
				return;
			}

			// PHPUnit >= 9.1.0.
			require_once __DIR__ . '/src/Polyfills/AssertionRenames_Empty.php';
		}

		/**
		 * Load the AssertClosedResource polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertClosedResource() {
			if ( \method_exists( Assert::class, 'assertIsClosedResource' ) === false ) {
				// PHPUnit < 9.3.0.
				require_once __DIR__ . '/src/Polyfills/AssertClosedResource.php';
				return;
			}

			// PHPUnit >= 9.3.0.
			require_once __DIR__ . '/src/Polyfills/AssertClosedResource_Empty.php';
		}

		/**
		 * Load the AssertObjectEquals polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertObjectEquals() {
			if ( \method_exists( Assert::class, 'assertObjectEquals' ) === false ) {
				// PHPUnit < 9.4.0.
				require_once __DIR__ . '/src/Polyfills/AssertObjectEquals.php';
				return;
			}

			// PHPUnit >= 9.4.0.
			require_once __DIR__ . '/src/Polyfills/AssertObjectEquals_Empty.php';
		}

		/**
		 * Load the AssertIsList polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertIsList() {
			if ( \method_exists( Assert::class, 'assertIsList' ) === false ) {
				// PHPUnit < 10.0.0.
				require_once __DIR__ . '/src/Polyfills/AssertIsList.php';
				return;
			}

			// PHPUnit >= 10.0.0.
			require_once __DIR__ . '/src/Polyfills/AssertIsList_Empty.php';
		}

		/**
		 * Load the AssertIgnoringLineEndings polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertIgnoringLineEndings() {
			if ( \method_exists( Assert::class, 'assertStringEqualsStringIgnoringLineEndings' ) === false ) {
				// PHPUnit < 10.0.0.
				require_once __DIR__ . '/src/Polyfills/AssertIgnoringLineEndings.php';
				return;
			}

			// PHPUnit >= 10.0.0.
			require_once __DIR__ . '/src/Polyfills/AssertIgnoringLineEndings_Empty.php';
		}

		/**
		 * Load the AssertObjectProperty polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertObjectProperty() {
			if ( \method_exists( Assert::class, 'assertObjectHasProperty' ) === false ) {
				// PHPUnit < 10.1.0.
				require_once __DIR__ . '/src/Polyfills/AssertObjectProperty.php';
				return;
			}

			// PHPUnit >= 10.1.0.
			require_once __DIR__ . '/src/Polyfills/AssertObjectProperty_Empty.php';
		}

		/**
		 * Load the AssertArrayWithListKeys polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertArrayWithListKeys() {
			if ( \method_exists( Assert::class, 'assertArrayIsEqualToArrayOnlyConsideringListOfKeys' ) === false ) {
				// PHPUnit < 11.0.0.
				require_once __DIR__ . '/src/Polyfills/AssertArrayWithListKeys.php';
				return;
			}

			// PHPUnit >= 11.0.0.
			require_once __DIR__ . '/src/Polyfills/AssertArrayWithListKeys_Empty.php';
		}

		/**
		 * Load the ExpectUserDeprecation polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadExpectUserDeprecation() {
			if ( \method_exists( TestCase::class, 'expectUserDeprecationMessage' ) === false ) {
				// PHPUnit < 11.0.0.
				require_once __DIR__ . '/src/Polyfills/ExpectUserDeprecation.php';
				return;
			}

			// PHPUnit >= 11.0.0.
			require_once __DIR__ . '/src/Polyfills/ExpectUserDeprecation_Empty.php';
		}

		/**
		 * Load the AssertObjectNotEquals polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertObjectNotEquals() {
			if ( \method_exists( Assert::class, 'assertObjectNotEquals' ) === false ) {
				// PHPUnit < 11.2.0.
				require_once __DIR__ . '/src/Polyfills/AssertObjectNotEquals.php';
				return;
			}

			// PHPUnit >= 11.2.0.
			require_once __DIR__ . '/src/Polyfills/AssertObjectNotEquals_Empty.php';
		}

		/**
		 * Load the AssertContainsOnly polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadAssertContainsOnly() {
			if ( \method_exists( Assert::class, 'assertContainsOnlyIterable' ) === false ) {
				// PHPUnit < 11.5.0.
				require_once __DIR__ . '/src/Polyfills/AssertContainsOnly.php';
				return;
			}

			// PHPUnit >= 11.5.0.
			require_once __DIR__ . '/src/Polyfills/AssertContainsOnly_Empty.php';
		}

		/**
		 * Load the appropriate TestCase class based on the PHPUnit version being used.
		 *
		 * @return void
		 */
		public static function loadTestCase() {
			if ( \version_compare( self::getPHPUnitVersion(), '8.0.0', '<' ) ) {
				// PHPUnit < 8.0.0.
				require_once __DIR__ . '/src/TestCases/TestCasePHPUnitLte7.php';
				return;
			}

			// PHPUnit >= 8.0.0.
			require_once __DIR__ . '/src/TestCases/TestCasePHPUnitGte8.php';
		}

		/**
		 * Load the appropriate TestListenerDefaultImplementation trait based on the PHPUnit version being used.
		 *
		 * @return void
		 */
		public static function loadTestListenerDefaultImplementation() {
			if ( \version_compare( PHPUnit_Version::id(), '7.0.0', '<' ) ) {
				// PHPUnit 6.4.4 < 7.0.0.
				require_once __DIR__ . '/src/TestListeners/TestListenerDefaultImplementationPHPUnit6.php';
				return;
			}

			// PHPUnit >= 7.0.0.
			require_once __DIR__ . '/src/TestListeners/TestListenerDefaultImplementationPHPUnitGte7.php';
		}

		/**
		 * Retrieve the PHPUnit version id.
		 *
		 * @return string Version number as a string.
		 */
		public static function getPHPUnitVersion() {
			if ( \class_exists( '\PHPUnit\Runner\Version' ) ) {
				return PHPUnit_Version::id();
			}

			return '0';
		}
	}

	\spl_autoload_register( __NAMESPACE__ . '\Autoload::load' );
}
