<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\ExpectExceptionMessageMatchesTestCase;

/**
 * Availability test for the function polyfilled by the ExpectExceptionMessageMatches trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( ExpectExceptionMessageMatches::class )]
#[RequiresPhpunit( '< 12' )]
final class ExpectExceptionMessageMatchesTest extends ExpectExceptionMessageMatchesTestCase {}
