<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIgnoringLineEndings;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertIgnoringLineEndingsTestCase;

/**
 * Availability test for the functions polyfilled by the AssertIgnoringLineEndings trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( AssertIgnoringLineEndings::class )]
#[RequiresPhpunit( '12' )]
final class AssertIgnoringLineEndingsTest extends AssertIgnoringLineEndingsTestCase {}
