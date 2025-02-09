<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills\WrappersGte12;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversTrait;
use PHPUnit\Framework\Attributes\RequiresPhpunit;
use Yoast\PHPUnitPolyfills\Helpers\ResourceHelper;
use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;
use Yoast\PHPUnitPolyfills\Tests\Polyfills\AssertClosedResourceFileTestCase;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * @requires PHPUnit 12
 */
#[CoversTrait( AssertClosedResource::class )]
#[CoversClass( ResourceHelper::class )]
#[RequiresPhpunit( '12' )]
final class AssertClosedResourceFileTest extends AssertClosedResourceFileTestCase {}
