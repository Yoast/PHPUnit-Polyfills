<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertArrayWithListKeys;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertArrayWithListKeysTestCase;

/**
 * Availability test for the functions polyfilled by the AssertArrayWithListKeys trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( AssertArrayWithListKeys::class )]
#[RequiresPhpunit( '12' )]
final class AssertArrayWithListKeysTest extends AssertArrayWithListKeysTestCase {}
