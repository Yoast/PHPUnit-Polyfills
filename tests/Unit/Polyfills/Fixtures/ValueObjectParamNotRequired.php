<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures;

/**
 * Fixture to test the AssertObjectEquals trait.
 *
 * The `equalsParamNotRequired()` method needs to be in this separate fixture as it needs
 * a nullable type declaration (PHP 7.1+) to prevent a deprecation about an implicitely nullable
 * type on PHP 8.4.
 */
class ValueObjectParamNotRequired {

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
	 * Comparator method: incorrectly declared - parameter is not required.
	 *
	 * @param self|null $other Object to compare.
	 *
	 * @return bool
	 */
	public function equalsParamNotRequired( ?self $other = null ): bool {
		return ( $this->value === $other->value );
	}
}
