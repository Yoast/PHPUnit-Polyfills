<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\TestCase;
use Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames;

/**
 * Availability test for the functions polyfilled by the AssertionRenames trait.
 */
abstract class AssertionRenamesTestCase extends TestCase {

	use AssertionRenames;

	private const NOT_EXISTENT_FILE = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting.php';

	private const NOT_EXISTENT_DIR = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting' . \DIRECTORY_SEPARATOR;

	/**
	 * Verify availability of the assertIsNotReadable() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotReadable() {
		$this->assertIsNotReadable( self::NOT_EXISTENT_FILE );
	}

	/**
	 * Verify availability of the assertIsNotWritable() method.
	 *
	 * @return void
	 */
	public function testAssertIsNotWritable() {
		self::assertIsNotWritable( self::NOT_EXISTENT_DIR );
	}

	/**
	 * Verify availability of the assertDirectoryDoesNotExist() method.
	 *
	 * @return void
	 */
	public function testAssertDirectoryDoesNotExist() {
		static::assertDirectoryDoesNotExist( self::NOT_EXISTENT_DIR );
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
		static::assertFileDoesNotExist( self::NOT_EXISTENT_FILE );
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
