<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertFileEqualsSpecializations;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertFileEqualsSpecializationsTestCase;

/**
 * Availability test for the functions polyfilled by the AssertFileEqualsSpecializations trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( AssertFileEqualsSpecializations::class )]
#[RequiresPhpunit( '12' )]
final class AssertFileEqualsSpecializationsTest extends AssertFileEqualsSpecializationsTestCase {}
