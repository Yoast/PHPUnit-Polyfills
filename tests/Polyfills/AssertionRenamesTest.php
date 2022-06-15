<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertFileDirectory;
use Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;

/**
 * Availability test for the functions polyfilled by the AssertionRenames trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames
 */
final class AssertionRenamesTest extends TestCase {

	use AssertFileDirectory; // Needed for PHPUnit < 5.6.0 support.
	use AssertionRenames;
	use AssertIsType;

	/**
	 * Verify availability of the assertIsNotReadable() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotReadable() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting.php';
		$this->assertIsNotReadable( $path );
	}

	/**
	 * Verify availability of the assertIsNotWritable() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotWritable() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting' . \DIRECTORY_SEPARATOR;
		self::assertIsNotWritable( $path );
	}

	/**
	 * Verify availability of the assertDirectoryDoesNotExist() method.
	 *
	 * @return void
	 */
	public function testAssertDirectoryDoesNotExist() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting' . \DIRECTORY_SEPARATOR;
		static::assertDirectoryDoesNotExist( $path );
	}

	/**
	 * Verify availability of the assertDirectoryIsNotReadable() method.
	 *
	 * @return void
	 */
	public function testAssertDirectoryIsNotReadable() {
		if ( \DIRECTORY_SEPARATOR === '\\' ) {
			// The actual behaviour of the assertion cannot be tested on Windows.
			$this->assertIsCallable(
				[ $this, 'assertDirectoryIsNotReadable' ],
				'Assertion "assertDirectoryIsNotReadable()" is not callable'
			);
			return;
		}

		$dirName = \sys_get_temp_dir() . \DIRECTORY_SEPARATOR . \uniqid( 'unreadable_dir_', true );
		\mkdir( $dirName, \octdec( '0' ) );

		$this->assertDirectoryIsNotReadable( $dirName );

		\rmdir( $dirName );
	}

	/**
	 * Verify availability of the assertDirectoryIsNotWritable() method.
	 *
	 * @return void
	 */
	public function testAssertDirectoryIsNotWritable() {
		if ( \DIRECTORY_SEPARATOR === '\\' ) {
			// The actual behaviour of the assertion cannot be tested on Windows.
			$this->assertIsCallable(
				[ $this, 'assertDirectoryIsNotWritable' ],
				'Assertion "assertDirectoryIsNotWritable()" is not callable'
			);
			return;
		}

		$dirName = \sys_get_temp_dir() . \DIRECTORY_SEPARATOR . \uniqid( 'not_writable_dir_', true );
		\mkdir( $dirName, \octdec( '444' ) );

		$this->assertDirectoryIsNotWritable( $dirName );

		\rmdir( $dirName );
	}

	/**
	 * Verify availability of the assertFileDoesNotExist() method.
	 *
	 * @return void
	 */
	public function testAssertFileDoesNotExist() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting.php';
		static::assertFileDoesNotExist( $path );
	}

	/**
	 * Verify availability of the assertFileIsNotReadable() method.
	 *
	 * @return void
	 */
	public function testAssertFileIsNotReadable() {
		if ( \DIRECTORY_SEPARATOR === '\\' ) {
			// The actual behaviour of the assertion cannot be tested on Windows.
			$this->assertIsCallable(
				[ $this, 'assertFileIsNotReadable' ],
				'Assertion "assertFileIsNotReadable()" is not callable'
			);
			return;
		}

		$tempFile = \tempnam( \sys_get_temp_dir(), 'unreadable' );
		\chmod( $tempFile, \octdec( '0' ) );

		self::assertFileIsNotReadable( $tempFile );

		\chmod( $tempFile, \octdec( '755' ) );
		\unlink( $tempFile );
	}

	/**
	 * Verify availability of the assertFileIsNotWritable() method.
	 *
	 * @return void
	 */
	public function testAssertFileIsNotWritable() {
		$tempFile = \tempnam( \sys_get_temp_dir(), 'not_writable' );
		\chmod( $tempFile, \octdec( '0' ) );

		$this->assertFileIsNotWritable( $tempFile );

		\chmod( $tempFile, \octdec( '755' ) );
		\unlink( $tempFile );
	}

	/**
	 * Verify availability of the assertMatchesRegularExpression() method.
	 *
	 * @return void
	 */
	public function testAssertMatchesRegularExpression() {
		self::assertMatchesRegularExpression( '/foo/', 'foobar' );
	}

	/**
	 * Verify availability of the assertDoesNotMatchRegularExpression() method.
	 *
	 * @return void
	 */
	public function testAssertDoesNotMatchRegularExpression() {
		$this->assertDoesNotMatchRegularExpression( '/foo/', 'bar' );
	}
}
