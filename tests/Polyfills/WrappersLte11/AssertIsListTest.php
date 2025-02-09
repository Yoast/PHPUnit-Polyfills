<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsList;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertIsListTestCase;

/**
 * Availability test for the functions polyfilled by the AssertIsList trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertIsList
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( AssertIsList::class )]
#[RequiresPhpunit( '< 12' )]
final class AssertIsListTest extends AssertIsListTestCase {}
