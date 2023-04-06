<?php

namespace Yoast\PHPUnitPolyfills\Tests\TestListeners\Fixtures;

use PHPUnit\Framework\TestListener;

/**
 * TestListener implementation for testing the TestListener cross-version
 * TestListenerDefaultImplementation trait.
 *
 * This is the entry point on PHPUnit < 10.
 */
final class TestListenerEntryPoint extends TestListenerImplementation implements TestListener {}
