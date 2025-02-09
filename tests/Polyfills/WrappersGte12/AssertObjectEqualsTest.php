<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Helpers\ComparatorValidator;
use Yoast\PHPUnitPolyfills\Polyfills\AssertObjectEquals;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertObjectEqualsTestCase;

/**
 * Availability test for the function polyfilled by the AssertObjectEquals trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( AssertObjectEquals::class )]
#[CoversClass( ComparatorValidator::class )]
#[RequiresPhpunit( '12' )]
final class AssertObjectEqualsTest extends AssertObjectEqualsTestCase {}
