<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertObjectProperty;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertObjectPropertyTestCase;

/**
 * Test for the functions polyfilled by the AssertObjectProperty trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( AssertObjectProperty::class )]
#[RequiresPhpunit( '12' )]
final class AssertObjectPropertyTest extends AssertObjectPropertyTestCase {}
