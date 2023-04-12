<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

/**
 * Fixture to test the test listener.
 *
 * PHP < 8.0: E_WARNING | The magic method __set() must have public visibility and cannot be static in ...
 * PHP 8.0+:  E_WARNING | The magic method Foo::__set() must have public visibility in ...
 */
class GenerateEWarning {

	/**
	 * Docblock.
	 *
	 * @var array<string, mixed>
	 */
	private $collection = [];

	/**
	 * Docblock.
	 *
	 * @phpcs:disable PHPCompatibility.FunctionDeclarations.NonStaticMagicMethods.__setMethodVisibility -- This is intentional.
	 *
	 * @param string $name  Property name.
	 * @param mixed  $value Property value.
	 */
	private function __set( $name, $value ) {
		$this->collection[ $name ] = $value;
	}
}
// phpcs:enable
