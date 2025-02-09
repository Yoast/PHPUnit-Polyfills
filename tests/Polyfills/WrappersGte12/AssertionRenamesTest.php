<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertionRenamesTestCase;

/**
 * Availability test for the functions polyfilled by the AssertionRenames trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( AssertionRenames::class )]
#[RequiresPhpunit( '12' )]
final class AssertionRenamesTest extends AssertionRenamesTestCase {}
