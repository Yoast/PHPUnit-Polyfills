<?php

namespace Testing\Exakat;

class Foo {
	public function bar($text, $data) {}
}

class UserlandNamesA extends Foo {
	public function bar($text, $data) {}
}

class UserlandNamesB extends Foo {
	public function bar($string, $otherdata) {
		// Make sure at least one other issue is triggered.
		var_dump(\class_exists('Dummy'));
	}
}
