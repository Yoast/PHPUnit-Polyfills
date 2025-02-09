<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertFileEqualsSpecializations;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertFileEqualsSpecializationsTestCase;

/**
 * Availability test for the functions polyfilled by the AssertFileEqualsSpecializations trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertFileEqualsSpecializations
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( AssertFileEqualsSpecializations::class )]
#[RequiresPhpunit( '< 12' )]
final class AssertFileEqualsSpecializationsTest extends AssertFileEqualsSpecializationsTestCase {}
