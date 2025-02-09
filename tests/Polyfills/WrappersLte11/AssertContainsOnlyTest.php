<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertContainsOnly;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertContainsOnlyTestCase;

/**
 * Tests for the functions polyfilled by the AssertContainsOnly trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertContainsOnly
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( AssertContainsOnly::class )]
#[RequiresPhpunit( '< 12' )]
final class AssertContainsOnlyTest extends AssertContainsOnlyTestCase {}
