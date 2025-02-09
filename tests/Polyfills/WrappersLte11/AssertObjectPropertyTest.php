<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertObjectProperty;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertObjectPropertyTestCase;

/**
 * Test for the functions polyfilled by the AssertObjectProperty trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertObjectProperty
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( AssertObjectProperty::class )]
#[RequiresPhpunit( '< 12' )]
final class AssertObjectPropertyTest extends AssertObjectPropertyTestCase {}
