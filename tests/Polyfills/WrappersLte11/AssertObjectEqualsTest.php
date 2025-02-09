<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Helpers\ComparatorValidator;
use Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertObjectEqualsTestCase;

/**
 * Availability test for the function polyfilled by the AssertObjectEquals trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ComparatorValidator
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( AssertObjectEquals::class )]
#[CoversClass( ComparatorValidator::class )]
#[RequiresPhpunit( '< 12' )]
final class AssertObjectEqualsTest extends AssertObjectEqualsTestCase {}
