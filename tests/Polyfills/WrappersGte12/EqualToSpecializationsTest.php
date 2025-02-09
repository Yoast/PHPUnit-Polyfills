<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\EqualToSpecializations;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\EqualToSpecializationsTestCase;

/**
 * Availability test for the functions polyfilled by the EqualToSpecializations trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( EqualToSpecializations::class )]
#[RequiresPhpunit( '12' )]
final class EqualToSpecializationsTest extends EqualToSpecializationsTestCase {}
