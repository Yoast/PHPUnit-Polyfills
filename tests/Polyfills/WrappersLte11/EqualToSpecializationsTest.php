<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Polyfills\EqualToSpecializations;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\EqualToSpecializationsTestCase;

/**
 * Availability test for the functions polyfilled by the EqualToSpecializations trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\EqualToSpecializations
 *
 * @requires PHPUnit < 12
 */
#[CoversClass( EqualToSpecializations::class )]
#[RequiresPhpunit( '< 12' )]
final class EqualToSpecializationsTest extends EqualToSpecializationsTestCase {}
