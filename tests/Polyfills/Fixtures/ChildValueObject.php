<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures;

/**
 * Fixture to test the AssertObjectEquals trait.
 */
class ChildValueObject extends ValueObject {

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
	 * @param ValueObject $other Object to compare.
	 *
	 * @return bool
	 */
	public function equals( ValueObject $other ): bool {
		return ( $this->value === $other->value );
	}
}
