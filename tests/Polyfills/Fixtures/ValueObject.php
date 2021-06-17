<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures;

use ClassWhichDoesntExist;

/**
 * Fixture to test the AssertObjectEquals trait.
 */
class ValueObject {

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
	 * @param self $other Object to compare.
	 *
	 * @return bool
	 */
	public function equals( self $other ): bool {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: correctly declared and with the class name as type instead of `self`.
	 *
	 * @param ValueObject $other Object to compare.
	 *
	 * @return bool
	 */
	public function nonDefaultName( ValueObject $other ): bool {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - more than one parameter.
	 *
	 * @param ValueObject $other Object to compare.
	 * @param mixed       $param Just testing.
	 *
	 * @return bool
	 */
	public function equalsTwoParams( $other, $param ): bool {
		return ( $param && $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - parameter is not required.
	 *
	 * @param self|null $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsParamNotRequired( self $other = null ): bool {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - parameter is not typed.
	 *
	 * @param ValueObject $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsParamNoType( $other ): bool {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - parameter has a non-classname type.
	 *
	 * @param array $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsParamNonClassType( array $other ): bool {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - parameter has a non-existent classname type.
	 *
	 * @param ClassWhichDoesntExist $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsParamNonExistentClassType( ClassWhichDoesntExist $other ): bool {
		return ( $this->value === $other->value );
	}

	/**
	 * Comparator method: incorrectly declared - non-boolean return type/value.
	 *
	 * @param self $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsNonBooleanReturnType( self $other ): int {
		return ( $this->value <=> $other->value );
	}
}
