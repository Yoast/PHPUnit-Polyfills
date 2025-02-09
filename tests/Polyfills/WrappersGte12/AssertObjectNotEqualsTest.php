<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Helpers\ComparatorValidator;
use Yoast\PHPUnitPolyfills\Polyfills\AssertObjectNotEquals;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertObjectNotEqualsTestCase;

/**
 * Availability test for the function polyfilled by the AssertObjectNotEquals trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( AssertObjectNotEquals::class )]
#[CoversClass( ComparatorValidator::class )]
#[RequiresPhpunit( '12' )]
final class AssertObjectNotEqualsTest extends AssertObjectNotEqualsTestCase {}
