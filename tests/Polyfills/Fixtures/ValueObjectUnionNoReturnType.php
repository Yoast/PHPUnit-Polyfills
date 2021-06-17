<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures;

/**
 * Fixture to test the AssertObjectEquals trait.
 */
class ValueObjectUnionNoReturnType {

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
	 * Comparator method: incorrectly declared - parameter has a union type.
	 *
	 * @param self|OtherClass|array $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsParamUnionType( self|OtherClass|array $other ) {
		return ( $this->value === $other->value );
	}
}
