<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Helpers\ComparatorValidator;
use Yoast\PHPUnitPolyfills\Polyfills\AssertObjectNotEquals;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertObjectNotEqualsTestCase;

/**
 * Availability test for the function polyfilled by the AssertObjectNotEquals trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertObjectNotEquals
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ComparatorValidator
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( AssertObjectNotEquals::class )]
#[CoversClass( ComparatorValidator::class )]
#[RequiresPhpunit( '< 12' )]
final class AssertObjectNotEqualsTest extends AssertObjectNotEqualsTestCase {}
