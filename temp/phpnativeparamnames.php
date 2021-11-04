<?php

namespace Testing\Exakat;

use ArrayAccess;
use ReturnTypeWillChange;

class PHPNativeNames implements ArrayAccess {
	#[ReturnTypeWillChange]
	public function offsetExists($offset) {
		// This one has the correct parameter name.
	}

	#[ReturnTypeWillChange]
	public function offsetGet($key) {
		// Incorrect param name.
	}

	#[ReturnTypeWillChange]
	public function offsetSet($offset, $newValue) {
		// One correct, one incorrect param name.
	}

	#[ReturnTypeWillChange]
	public function offsetUnset($offset) {
		// This one has the correct parameter name again.
	}
}
