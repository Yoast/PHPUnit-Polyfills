<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RequiresPhp;
use PHPUnit\Framework\Attributes\RequiresPhpExtension;
use Yoast\PHPUnitPolyfills\Helpers\ResourceHelper;
use Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource;

/**
 * Functionality test for the functions polyfilled by the AssertClosedResource trait.
 *
 * Resource type: shmop
 * Extension:     shmop
 *
 * Note: the return value of the Shmop functions has changed in PHP 7.0 from `int`
 * to `resource`, which is why the tests will be skipped on PHP < 7.0.
 *
 * Note: the return value of the Shmop functions has changed in PHP 8.0 from `resource`
 * to `Shmop` (object), which is why the tests will be skipped on PHP >= 8.0.
 *
 * @covers \Yoast\PHPUnitPolyfills\Helpers\ResourceHelper
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource
 *
 * @requires extension shmop
 * @requires PHP < 8.0
 *
 * @phpcs:disable Generic.PHP.DeprecatedFunctions.Deprecated
 * @phpcs:disable PHPCompatibility.FunctionUse.RemovedFunctions.shmop_closeDeprecated
 */
#[CoversClass( AssertClosedResource::class )]
#[CoversClass( ResourceHelper::class )]
#[RequiresPhp( '< 8.0' )]
#[RequiresPhpExtension( 'shmop' )]
final class AssertClosedResourceShmopTest extends AssertClosedResourceTestCase {

	use AssertClosedResource;

	/**
	 * Verify availability of the assertIsClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithClosedResource() {
		$key      = $this->getKey( __FILE__, 't' );
		$resource = \shmop_open( $key, 'c', 0644, 100 );
		\shmop_close( $resource );

		$this->assertIsClosedResource( $resource );
	}

	/**
	 * Verify that the assertIsClosedResource() method fails the test when the variable
	 * passed is not a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsClosedResourceWithOpenResource() {
		$key      = $this->getKey( __FILE__, 't' );
		$resource = \shmop_open( $key, 'c', 0644, 100 );

		$this->isClosedResourceExpectExceptionOnOpenResource( $resource );

		\shmop_close( $resource );
	}

	/**
	 * Verify availability of the assertIsNotClosedResource() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithOpenResource() {
		$key      = $this->getKey( __FILE__, 't' );
		$resource = \shmop_open( $key, 'c', 0644, 100 );

		self::assertIsNotClosedResource( $resource );

		\shmop_close( $resource );
	}

	/**
	 * Verify that the assertIsNotClosedResource() method fails the test when the variable
	 * passed is a *closed* resource.
	 *
	 * @return void
	 */
	public function testAssertIsNotClosedResourceWithClosedResource() {
		$key      = $this->getKey( __FILE__, 't' );
		$resource = \shmop_open( $key, 'c', 0644, 100 );
		\shmop_close( $resource );

		$this->isNotClosedResourceExpectExceptionOnClosedResource( $resource );
	}

	/**
	 * Helper function: work round ftok() not always being available (on Windows).
	 *
	 * @link https://www.php.net/manual/en/function.ftok.php#43309
	 *
	 * @param string $pathname Path to file.
	 * @param string $proj_id  Project identifier.
	 *
	 * @return string
	 */
	private function getKey( $pathname, $proj_id ) {
		if ( \function_exists( 'ftok' ) ) {
			return \ftok( $pathname, $proj_id );
		}

		// phpcs:ignore WordPress.PHP.NoSilencedErrors.Discouraged
		$st = @\stat( $pathname );
		if ( ! $st ) {
			return -1;
		}

		return \sprintf( '%u', ( ( $st['ino'] & 0xffff ) | ( ( $st['dev'] & 0xff ) << 16 ) | ( ( $proj_id & 0xff ) << 24 ) ) );
	}
}
