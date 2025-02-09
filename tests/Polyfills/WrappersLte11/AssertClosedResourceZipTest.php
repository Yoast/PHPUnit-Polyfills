<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersLte11;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Helpers\ResourceHelper;
use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertClosedResourceZipTestCase;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 *
 * @requires extension zip
 * @requires PHPUnit < 12
 */
#[CoversClass( AssertClosedResource::class )]
#[CoversClass( ResourceHelper::class )]
#[RequiresPhpExtension( 'zip' )]
#[RequiresPhpunit( '< 12' )]
final class AssertClosedResourceZipTest extends AssertClosedResourceZipTestCase {}
