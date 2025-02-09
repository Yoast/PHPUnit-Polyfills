<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertionRenamesTestCase;

/**
 * Availability test for the functions polyfilled by the AssertionRenames trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( AssertionRenames::class )]
#[RequiresPhpunit( '< 12' )]
final class AssertionRenamesTest extends AssertionRenamesTestCase {}
