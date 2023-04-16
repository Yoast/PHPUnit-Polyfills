<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\Fixtures;

/**
 * Fixture to test the AssertObjectProperty trait.
 */
class ObjectWithProperties {

	/**
	 * Property for use in the tests.
	 *
	 * @var mixed
	 */
	public $publicNoDefaultValue;

	/**
	 * Property for use in the tests.
	 *
	 * @var mixed
	 */
	protected $protectedNoDefaultValue;

	/**
	 * Property for use in the tests.
	 *
	 * @var mixed
	 */
	private $privateNoDefaultValue;

	/**
	 * Property for use in the tests.
	 *
	 * @var mixed
	 */
	public $publicWithDefaultValue = true;

	/**
	 * Property for use in the tests.
	 *
	 * @var mixed
	 */
	protected $protectedWithDefaultValue = 10;

	/**
	 * Property for use in the tests.
	 *
	 * @var mixed
	 */
	private $privateWithDefaultValue = 'string';

	/**
	 * Property for use in the tests.
	 *
	 * @var mixed
	 */
	public $unsetPublic = true;

	/**
	 * Property for use in the tests.
	 *
	 * @var mixed
	 */
	protected $unsetProtected;

	/**
	 * Property for use in the tests.
	 *
	 * @var mixed
	 */
	private $unsetPrivate;

	/**
	 * Constructor.
	 */
	public function __construct() {
		unset(
			$this->existsButUnsetPublic,
			$this->existsButUnsetProtected,
			$this->existsButUnsetPrivate
		);
	}
}
