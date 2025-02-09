<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Helpers\ResourceHelper;
use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertClosedResourceZlibTestCase;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( AssertClosedResource::class )]
#[CoversClass( ResourceHelper::class )]
#[RequiresPhpExtension( 'zlib' )]
#[RequiresPhpunit( '12' )]
final class AssertClosedResourceZlibTest extends AssertClosedResourceZlibTestCase {}
