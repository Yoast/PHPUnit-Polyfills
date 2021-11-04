<?php

namespace Testing\Exakat;

use ArrayAccess;
use ReturnTypeWillChange;

class PHPNativeNames implements ArrayAccess {
	#[ReturnTypeWillChange]
	public offsetExists($offset) {
		// This one has the correct parameter name.
	}

	#[ReturnTypeWillChange]
	public offsetGet($key) {
		// Incorrect param name.
	}

	#[ReturnTypeWillChange]
	public offsetSet($offset, $newValue) {
		// One correct, one incorrect param name.
	}

	#[ReturnTypeWillChange]
	public offsetUnset($offset) {
		// This one has the correct parameter name again.
	}
}
