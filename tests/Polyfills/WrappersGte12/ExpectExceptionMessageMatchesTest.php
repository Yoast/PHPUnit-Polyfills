<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\ExpectExceptionMessageMatchesTestCase;

/**
 * Availability test for the function polyfilled by the ExpectExceptionMessageMatches trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( ExpectExceptionMessageMatches::class )]
#[RequiresPhpunit( '12' )]
final class ExpectExceptionMessageMatchesTest extends ExpectExceptionMessageMatchesTestCase {}
