<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertContainsOnly;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertContainsOnlyTestCase;

/**
 * Tests for the functions polyfilled by the AssertContainsOnly trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( AssertContainsOnly::class )]
#[RequiresPhpunit( '12' )]
final class AssertContainsOnlyTest extends AssertContainsOnlyTestCase {}
