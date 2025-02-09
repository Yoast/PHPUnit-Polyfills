<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\ExpectUserDeprecationTestCase;

/**
 * Availability test for the functions polyfilled by the ExpectUserDeprecation trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( ExpectUserDeprecation::class )]
#[RequiresPhpunit( '< 12' )]
final class ExpectUserDeprecationTest extends ExpectUserDeprecationTestCase {}
