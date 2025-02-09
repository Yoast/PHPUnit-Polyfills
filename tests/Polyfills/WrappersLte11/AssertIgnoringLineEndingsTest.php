<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIgnoringLineEndings;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertIgnoringLineEndingsTestCase;

/**
 * Availability test for the functions polyfilled by the AssertIgnoringLineEndings trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertIgnoringLineEndings
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( AssertIgnoringLineEndings::class )]
#[RequiresPhpunit( '< 12' )]
final class AssertIgnoringLineEndingsTest extends AssertIgnoringLineEndingsTestCase {}
