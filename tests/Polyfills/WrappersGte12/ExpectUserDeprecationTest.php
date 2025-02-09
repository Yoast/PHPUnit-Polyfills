<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectUserDeprecation;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\ExpectUserDeprecationTestCase;

/**
 * Availability test for the functions polyfilled by the ExpectUserDeprecation trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( ExpectUserDeprecation::class )]
#[RequiresPhpunit( '12' )]
final class ExpectUserDeprecationTest extends ExpectUserDeprecationTestCase {}
