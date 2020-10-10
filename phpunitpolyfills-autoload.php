<?php

namespace Yoast\PHPUnitPolyfills;

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
	}

	\spl_autoload_register( __NAMESPACE__ . '\Autoload::load' );
}
