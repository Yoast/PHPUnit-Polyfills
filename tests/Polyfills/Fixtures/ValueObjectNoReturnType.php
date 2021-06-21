<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures;

use ClassWhichDoesntExist;

/**
 * Fixture to test the AssertObjectEquals trait.
 */
class ValueObjectNoReturnType {

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
	 * Comparator method: correctly declared.
	 *
	 * @param ValueObjectNoReturnType $other Object to compare.
	 *
	 * @return bool
	 */
	public function equals( ValueObjectNoReturnType $other ) {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: correctly declared and with self as type instead of the class name.
	 *
	 * @param self $other Object to compare.
	 *
	 * @return bool
	 */
	public function nonDefaultName( self $other ) {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - more than one parameter.
	 *
	 * @param ValueObjectNoReturnType $other Object to compare.
	 * @param mixed                   $param Just testing.
	 *
	 * @return bool
	 */
	public function equalsTwoParams( $other, $param ) {
		return ( $param && $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - parameter is not required.
	 *
	 * @param self|null $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsParamNotRequired( self $other = null ) {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - parameter is not typed.
	 *
	 * @param ValueObjectNoReturnType $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsParamNoType( $other ) {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - parameter has a non-classname type.
	 *
	 * @param array $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsParamNonClassType( array $other ) {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - parameter has a non-existent classname type.
	 *
	 * @param ClassWhichDoesntExist $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsParamNonExistentClassType( ClassWhichDoesntExist $other ) {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - non-boolean return type/value.
	 *
	 * @param self $other Object to compare.
	 *
	 * @return int
	 */
	public function equalsNonBooleanReturnType( self $other ) {
		if ( $this->value === $other->value ) {
			return 0;
		}

		if ( $this->value > $other->value ) {
			return 1;
		}

		return -1;
	}
}
