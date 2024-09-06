<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures;

/**
 * Fixture to test the AssertObjectEquals trait.
 *
 * This `equals*()` method needs to be in this separate fixture as it needs
 * a union type declaration (PHP 8.0+).
 */
class ValueObjectUnionReturnType {

	/**
	 * The value.
	 *
	 * @var mixed
	 */
	protected $value;

	/**
	 * Constructor.
	 *
	 * @param mixed $value The value.
	 */
	public function __construct( $value ) {
		$this->value = $value;
	}

	/**
	 * Comparator method: incorrectly declared - union type as return type.
	 *
	 * @param self $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsUnionReturnType( self $other ): bool|int {
		return ( $this->value === $other->value );
	}
}
