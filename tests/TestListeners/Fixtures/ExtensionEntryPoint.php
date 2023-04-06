<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Runner\Extension\Extension;

/**
 * TestListener implementation for testing the TestListener cross-version
 * TestListenerDefaultImplementation trait.
 *
 * This is the entry point on PHPUnit >= 10.
 */
final class ExtensionEntryPoint extends TestListenerImplementation implements Extension {}
