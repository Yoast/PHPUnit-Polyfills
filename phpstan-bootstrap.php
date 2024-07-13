<?php
/**
 * Bootstrap file for PHPStan.
 *
 * @package Yoast\PHPUnitPolyfills
 *
 * @phpcs:disable Yoast.NamingConventions.NamespaceName -- This file emulates external classes.
 * @phpcs:disable Yoast.Commenting.FileComment.Unnecessary -- This is deliberate.
 * @phpcs:disable Generic.Files.OneObjectStructurePerFile
 * @phpcs:disable Universal.Namespaces.OneDeclarationPerFile
 * @phpcs:disable Universal.Namespaces.DisallowCurlyBraceSyntax
 * @phpcs:disable Squiz.Commenting.FunctionComment.InvalidNoReturn -- These are only stubs, not real functions.
 */

namespace PHPUnit\SebastianBergmann\Exporter {

	/**
	 * Emulate the PHPUnit-prefixed Exporter class.
	 */
	final class Exporter {

		/**
		 * Exports a value as a string.
		 *
		 * @param mixed $value       The value to export.
		 * @param int   $indentation The indentation to use.
		 *
		 * @return string
		 */
		public function export( $value, $indentation = 0 ) {}
	}
}

namespace PHPUnitPHAR\SebastianBergmann\Exporter {

	/**
	 * Emulate the PHPUnitPHAR-prefixed Exporter class.
	 */
	final class Exporter {

		/**
		 * Exports a value as a string.
		 *
		 * @param mixed $value       The value to export.
		 * @param int   $indentation The indentation to use.
		 *
		 * @return string
		 */
		public function export( $value, $indentation = 0 ) {}
	}
}
