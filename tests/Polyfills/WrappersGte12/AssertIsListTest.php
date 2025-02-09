<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsList;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertIsListTestCase;

/**
 * Availability test for the functions polyfilled by the AssertIsList trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( AssertIsList::class )]
#[RequiresPhpunit( '12' )]
final class AssertIsListTest extends AssertIsListTestCase {}
