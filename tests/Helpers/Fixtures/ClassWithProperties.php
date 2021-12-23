<?php

namespace Yoast\PHPUnitPolyfills\Tests\Helpers\Fixtures;

use AllowDynamicProperties;

/**
 * Fixture to test the AssertAttributeHelper.
 */
#[AllowDynamicProperties]
class ClassWithProperties {

	/**
	 * Public property.
	 *
	 * @var string|null
	 */
	public $public_prop = null;

	/**
	 * Protected property.
	 *
	 * @var int|null
	 */
	protected $protected_prop;

	/**
	 * Private property.
	 *
	 * @var bool
	 */
	private $private_prop = false;

	/**
	 * Set values for the properties to allow for testing the AssertAttributeHelper.
	 *
	 * @return void
	 */
	public function setProperties() {
		$this->public_prop    = 'public';
		$this->protected_prop = 100;
		$this->private_prop   = true;

		// Set a non-predefined property.
		$this->dynamic = new self();
	}
}
