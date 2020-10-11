<?php

namespace Yoast\PHPUnitPolyfills;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;

if ( \class_exists( 'Yoast\PHPUnitPolyfills\Autoload', false ) === false ) {

	/**
	 * Custom autoloader.
	 */
	class Autoload {

		/**
		 * Loads a class.
		 *
		 * @param string $class The name of the class to load.
		 *
		 * @return bool
		 */
		public static function load( $class ) {
			// Only load classes belonging to this library.
			if ( \stripos( $class, 'Yoast\PHPUnitPolyfills' ) !== 0 ) {
				return false;
			}

			switch ( $class ) {
				case 'Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionObject':
					self::loadExpectExceptionObject();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertIsType':
					self::loadAssertIsType();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertStringContains':
					self::loadAssertStringContains();
					return true;

				case 'Yoast\PHPUnitPolyfills\Polyfills\AssertEqualsSpecializations':
					self::loadAssertEqualsSpecializations();
					return true;
			}

			return false;
		}

		/**
		 * Load the ExpectExceptionObject polyfill or an empty trait with the same name
		 * if a PHPUnit version is used which already contains this functionality.
		 *
		 * @return void
		 */
		public static function loadExpectExceptionObject() {
			if ( \method_exists( TestCase::class, 'expectExceptionObject' ) === false ) {
				// PHPUnit < 6.4.0.
				require_once __DIR__ . '/src/Polyfills/ExpectExceptionObject.php';
				return;
			}

			// PHPUnit >= 6.4.0.
			require_once __DIR__ . '/src/Polyfills/ExpectExceptionObject_Empty.php';
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
	}

	\spl_autoload_register( __NAMESPACE__ . '\Autoload::load' );
}
