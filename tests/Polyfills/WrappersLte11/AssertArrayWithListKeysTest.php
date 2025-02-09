<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertArrayWithListKeys;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertArrayWithListKeysTestCase;

/**
 * Availability test for the functions polyfilled by the AssertArrayWithListKeys trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertArrayWithListKeys
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( AssertArrayWithListKeys::class )]
#[RequiresPhpunit( '< 12' )]
final class AssertArrayWithListKeysTest extends AssertArrayWithListKeysTestCase {}
