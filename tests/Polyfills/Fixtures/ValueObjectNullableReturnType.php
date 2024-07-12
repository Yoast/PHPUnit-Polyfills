<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures;

/**
 * Fixture to test the AssertObjectEquals trait.
 *
 * This `equals*()` method needs to be in this separate fixture as it needs
 * a nullable type declaration (PHP 7.1+).
 */
class ValueObjectNullableReturnType {

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
	 * Comparator method: incorrectly declared - return type is nullable.
	 *
	 * @param self $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsNullableReturnType( self $other ): ?bool {
		return ( $this->value === $other->value );
	}
}
