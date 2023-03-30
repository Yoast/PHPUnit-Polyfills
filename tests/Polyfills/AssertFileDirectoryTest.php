<?php

namespace Yoast\PHPUnitPolyfills\Tests\Polyfills;

use PHPUnit\Framework\Exception as PHPUnit_Exception;
use PHPUnit\Framework\TestCase;
use stdClass;
use TypeError;
use Yoast\PHPUnitPolyfills\Polyfills\AssertFileDirectory;
use Yoast\PHPUnitPolyfills\Polyfills\AssertionRenames;
use Yoast\PHPUnitPolyfills\Polyfills\AssertIsType;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectException;
use Yoast\PHPUnitPolyfills\Polyfills\ExpectExceptionMessageMatches;

/**
 * Availability test for the functions polyfilled by the AssertFileDirectory trait.
 *
 * @covers \Yoast\PHPUnitPolyfills\Polyfills\AssertFileDirectory
 */
final class AssertFileDirectoryTest extends TestCase {

	use AssertFileDirectory;
	use AssertionRenames;
	use AssertIsType;
	use ExpectException; // Needed for PHPUnit < 5.2.0 support.
	use ExpectExceptionMessageMatches;

	/**
	 * Verify availability of the assertIsReadable() method.
	 *
	 * @return void
	 */
	public function testAssertIsReadable() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'Fixtures/AssertFileDirectory_Readable.txt';
		$this->assertIsReadable( $path );
	}

	/**
	 * Test the "invalid argument" exception if a non-string exception code is passed.
	 *
	 * This exception was thrown until PHP 7.0.0. Since PHP 7.0.0, a PHP native TypeError will
	 * be thrown based on the type declaration.
	 */
	public function testAssertIsReadableException() {
		try {
			$this->assertIsReadable( null );
		} catch ( PHPUnit_Exception $e ) {
			// PHPUnit < 7.0.0.
			$this->assertMatchesRegularExpression(
				'`^Argument #1 \([^)]+\) of [^:]+::assertIsReadable\(\) must be a string`',
				$e->getMessage()
			);
			return;
		} catch ( TypeError $e ) {
			// PHPUnit >= 7.0.0.
			$regex = '`^Argument 1 passed to [^:]+::assertIsReadable\(\) must be of the type string`';
			if ( \PHP_MAJOR_VERSION === 8 ) {
				$regex = '`^[^:]+::assertIsReadable\(\): Argument \#1 \([^)]+\) must be of type string`';
			}

			$this->assertMatchesRegularExpression( $regex, $e->getMessage() );
			return;
		}

		$this->fail( 'Failed to assert that the expected "invalid argument" exception was thrown' );
	}

	/**
	 * Verify that the assertIsReadable() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testAssertIsReadableFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that ".+?" is readable`';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting.php';
		$this->assertIsReadable( $path, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify availability of the assertNotIsReadable() method.
	 *
	 * @requires PHPUnit < 9.1.0
	 *
	 * @return void
	 */
	public function testAssertNotIsReadable() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting.php';
		static::assertNotIsReadable( $path );
	}

	/**
	 * Test the "invalid argument" exception if a non-string exception code is passed.
	 *
	 * This exception was thrown until PHP 7.0.0. Since PHP 7.0.0, a PHP native TypeError will
	 * be thrown based on the type declaration.
	 *
	 * @requires PHPUnit < 10.0.0
	 */
	public function testAssertNotIsReadableException() {
		try {
			$this->assertNotIsReadable( [ 123 ] );
		} catch ( PHPUnit_Exception $e ) {
			// PHPUnit < 7.0.0.
			$this->assertMatchesRegularExpression(
				'`^Argument #1 \([^)]+\) of [^:]+::assertNotIsReadable\(\) must be a string`',
				$e->getMessage()
			);
			return;
		} catch ( TypeError $e ) {
			// PHPUnit >= 7.0.0.
			$regex = '`^Argument 1 passed to [^:]+::assertNotIsReadable\(\) must be of the type string`';
			if ( \PHP_MAJOR_VERSION === 8 ) {
				$regex = '`^[^:]+::assertNotIsReadable\(\): Argument \#1 \([^)]+\) must be of type string`';
			}

			$this->assertMatchesRegularExpression( $regex, $e->getMessage() );
			return;
		}

		$this->fail( 'Failed to assert that the expected "invalid argument" exception was thrown' );
	}

	/**
	 * Verify that the assertNotIsReadable() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @requires PHPUnit < 9.1.0
	 *
	 * @return void
	 */
	public function testAssertNotIsReadableFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that ".+?" is not readable`';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'Fixtures/AssertFileDirectory_Readable.txt';
		$this->assertNotIsReadable( $path, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify availability of the assertIsWritable() method.
	 *
	 * @return void
	 */
	public function testAssertIsWritable() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'Fixtures/AssertFileDirectory_Readable.txt';
		$this->assertIsWritable( $path );
	}

	/**
	 * Test the "invalid argument" exception if a non-string exception code is passed.
	 *
	 * This exception was thrown until PHP 7.0.0. Since PHP 7.0.0, a PHP native TypeError will
	 * be thrown based on the type declaration.
	 */
	public function testAssertIsWritableException() {
		try {
			self::assertIsWritable( new stdClass() );
		} catch ( PHPUnit_Exception $e ) {
			// PHPUnit < 7.0.0.
			$this->assertMatchesRegularExpression(
				'`^Argument #1 \([^)]+\) of [^:]+::assertIsWritable\(\) must be a string`',
				$e->getMessage()
			);
			return;
		} catch ( TypeError $e ) {
			// PHPUnit >= 7.0.0.
			$regex = '`^Argument 1 passed to [^:]+::assertIsWritable\(\) must be of the type string`';
			if ( \PHP_MAJOR_VERSION === 8 ) {
				$regex = '`^[^:]+::assertIsWritable\(\): Argument \#1 \([^)]+\) must be of type string`';
			}

			$this->assertMatchesRegularExpression( $regex, $e->getMessage() );
			return;
		}

		$this->fail( 'Failed to assert that the expected "invalid argument" exception was thrown' );
	}

	/**
	 * Verify that the assertIsWritable() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testAssertIsWritableFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that ".+?" is writable`';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting' . \DIRECTORY_SEPARATOR;
		$this->assertIsWritable( $path, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify availability of the assertNotIsWritable() method.
	 *
	 * @requires PHPUnit < 9.1.0
	 *
	 * @return void
	 */
	public function testAssertNotIsWritable() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting' . \DIRECTORY_SEPARATOR;
		self::assertNotIsWritable( $path );
	}

	/**
	 * Test the "invalid argument" exception if a non-string exception code is passed.
	 *
	 * This exception was thrown until PHP 7.0.0. Since PHP 7.0.0, a PHP native TypeError will
	 * be thrown based on the type declaration.
	 *
	 * @requires PHPUnit < 10.0.0
	 */
	public function testAssertNotIsWritableException() {
		try {
			$this->assertNotIsWritable( null );
		} catch ( PHPUnit_Exception $e ) {
			// PHPUnit < 7.0.0.
			$this->assertMatchesRegularExpression(
				'`^Argument #1 \([^)]+\) of [^:]+::assertNotIsWritable\(\) must be a string`',
				$e->getMessage()
			);
			return;
		} catch ( TypeError $e ) {
			// PHPUnit >= 7.0.0.
			$regex = '`^Argument 1 passed to [^:]+::assertNotIsWritable\(\) must be of the type string`';
			if ( \PHP_MAJOR_VERSION === 8 ) {
				$regex = '`^[^:]+::assertNotIsWritable\(\): Argument \#1 \([^)]+\) must be of type string`';
			}

			$this->assertMatchesRegularExpression( $regex, $e->getMessage() );
			return;
		}

		$this->fail( 'Failed to assert that the expected "invalid argument" exception was thrown' );
	}

	/**
	 * Verify that the assertNotIsWritable() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @requires PHPUnit < 9.1.0
	 *
	 * @return void
	 */
	public function testAssertNotIsWritableFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that ".+?" is not writable`';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'Fixtures/AssertFileDirectory_Readable.txt';
		$this->assertNotIsWritable( $path, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify availability of the assertDirectoryExists() method.
	 *
	 * @return void
	 */
	public function testAssertDirectoryExists() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'Fixtures' . \DIRECTORY_SEPARATOR;
		$this->assertDirectoryExists( $path );
	}

	/**
	 * Test the "invalid argument" exception if a non-string exception code is passed.
	 *
	 * This exception was thrown until PHP 7.0.0. Since PHP 7.0.0, a PHP native TypeError will
	 * be thrown based on the type declaration.
	 */
	public function testAssertDirectoryExistsException() {
		try {
			$this->assertDirectoryExists( [] );
		} catch ( PHPUnit_Exception $e ) {
			// PHPUnit < 7.0.0.
			$this->assertMatchesRegularExpression(
				'`^Argument #1 \([^)]+\) of [^:]+::assertDirectoryExists\(\) must be a string`',
				$e->getMessage()
			);
			return;
		} catch ( TypeError $e ) {
			// PHPUnit >= 7.0.0.
			$regex = '`^Argument 1 passed to [^:]+::assertDirectoryExists\(\) must be of the type string`';
			if ( \PHP_MAJOR_VERSION === 8 ) {
				$regex = '`^[^:]+::assertDirectoryExists\(\): Argument \#1 \([^)]+\) must be of type string`';
			}

			$this->assertMatchesRegularExpression( $regex, $e->getMessage() );
			return;
		}

		$this->fail( 'Failed to assert that the expected "invalid argument" exception was thrown' );
	}

	/**
	 * Verify that the assertDirectoryExists() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @return void
	 */
	public function testAssertDirectoryExistsFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that directory ".+?" exists`';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting' . \DIRECTORY_SEPARATOR;
		$this->assertDirectoryExists( $path, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify availability of the assertDirectoryNotExists() method.
	 *
	 * @requires PHPUnit < 9.1.0
	 *
	 * @return void
	 */
	public function testAssertDirectoryNotExists() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'NotExisting' . \DIRECTORY_SEPARATOR;
		static::assertDirectoryNotExists( $path );
	}

	/**
	 * Test the "invalid argument" exception if a non-string exception code is passed.
	 *
	 * This exception was thrown until PHP 7.0.0. Since PHP 7.0.0, a PHP native TypeError will
	 * be thrown based on the type declaration.
	 *
	 * @requires PHPUnit < 10.0.0
	 */
	public function testAssertDirectoryNotExistsException() {
		try {
			$this->assertDirectoryNotExists( new stdClass() );
		} catch ( PHPUnit_Exception $e ) {
			// PHPUnit < 7.0.0.
			$this->assertMatchesRegularExpression(
				'`^Argument #1 \([^)]+\) of [^:]+::assertDirectoryNotExists\(\) must be a string`',
				$e->getMessage()
			);
			return;
		} catch ( TypeError $e ) {
			// PHPUnit >= 7.0.0.
			$regex = '`^Argument 1 passed to [^:]+::assertDirectoryNotExists\(\) must be of the type string`';
			if ( \PHP_MAJOR_VERSION === 8 ) {
				$regex = '`^[^:]+::assertDirectoryNotExists\(\): Argument \#1 \([^)]+\) must be of type string`';
			}

			$this->assertMatchesRegularExpression( $regex, $e->getMessage() );
			return;
		}

		$this->fail( 'Failed to assert that the expected "invalid argument" exception was thrown' );
	}

	/**
	 * Verify that the assertDirectoryNotExists() method fails a test with the correct custom failure message,
	 * when the custom $message parameter has been passed.
	 *
	 * @requires PHPUnit < 9.1.0
	 *
	 * @return void
	 */
	public function testAssertDirectoryNotExistsFailsWithCustomMessage() {
		$pattern = '`^This assertion failed for reason XYZ\s+Failed asserting that directory ".+?" does not exist`';

		$this->expectException( $this->getAssertionFailedExceptionName() );
		$this->expectExceptionMessageMatches( $pattern );

		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'Fixtures' . \DIRECTORY_SEPARATOR;
		$this->assertDirectoryNotExists( $path, 'This assertion failed for reason XYZ' );
	}

	/**
	 * Verify availability of the assertDirectoryIsReadable() method.
	 *
	 * @return void
	 */
	public function testAssertDirectoryIsReadable() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'Fixtures' . \DIRECTORY_SEPARATOR;
		$this->assertDirectoryIsReadable( $path );
	}

	/**
	 * Verify availability of the assertDirectoryNotIsReadable() method.
	 *
	 * @requires PHPUnit < 9.1.0
	 *
	 * @return void
	 */
	public function testAssertDirectoryNotIsReadable() {
		if ( \DIRECTORY_SEPARATOR === '\\' ) {
			// The actual behaviour of the assertion cannot be tested on Windows.
			$this->assertIsCallable(
				[ $this, 'assertDirectoryNotIsReadable' ],
				'Assertion "assertDirectoryNotIsReadable()" is not callable'
			);
			return;
		}

		$dirName = \sys_get_temp_dir() . \DIRECTORY_SEPARATOR . \uniqid( 'unreadable_dir_', true );
		\mkdir( $dirName, \octdec( '0' ) );

		$this->assertDirectoryNotIsReadable( $dirName );

		\rmdir( $dirName );
	}

	/**
	 * Verify availability of the assertDirectoryIsWritable() method.
	 *
	 * @return void
	 */
	public function testAssertDirectoryIsWritable() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'Fixtures' . \DIRECTORY_SEPARATOR;
		self::assertDirectoryIsWritable( $path );
	}

	/**
	 * Verify availability of the assertDirectoryNotIsWritable() method.
	 *
	 * @requires PHPUnit < 9.1.0
	 *
	 * @return void
	 */
	public function testAssertDirectoryNotIsWritable() {
		if ( \DIRECTORY_SEPARATOR === '\\' ) {
			// The actual behaviour of the assertion cannot be tested on Windows.
			$this->assertIsCallable(
				[ $this, 'assertDirectoryNotIsWritable' ],
				'Assertion "assertDirectoryNotIsWritable()" is not callable'
			);
			return;
		}

		$dirName = \sys_get_temp_dir() . \DIRECTORY_SEPARATOR . \uniqid( 'not_writable_dir_', true );
		\mkdir( $dirName, \octdec( '444' ) );

		$this->assertDirectoryNotIsWritable( $dirName );

		\rmdir( $dirName );
	}

	/**
	 * Verify availability of the assertFileIsReadable() method.
	 *
	 * @return void
	 */
	public function testAssertFileIsReadable() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'Fixtures/AssertFileDirectory_Readable.txt';
		$this->assertFileIsReadable( $path );
	}

	/**
	 * Verify availability of the assertFileNotIsReadable() method.
	 *
	 * @requires PHPUnit < 9.1.0
	 *
	 * @return void
	 */
	public function testAssertFileNotIsReadable() {
		if ( \DIRECTORY_SEPARATOR === '\\' ) {
			// The actual behaviour of the assertion cannot be tested on Windows.
			$this->assertIsCallable(
				[ $this, 'assertFileNotIsReadable' ],
				'Assertion "assertFileNotIsReadable()" is not callable'
			);
			return;
		}

		$tempFile = \tempnam( \sys_get_temp_dir(), 'unreadable' );
		\chmod( $tempFile, \octdec( '0' ) );

		self::assertFileNotIsReadable( $tempFile );

		\chmod( $tempFile, \octdec( '755' ) );
		\unlink( $tempFile );
	}

	/**
	 * Verify availability of the assertFileIsWritable() method.
	 *
	 * @return void
	 */
	public function testAssertFileIsWritable() {
		$path = __DIR__ . \DIRECTORY_SEPARATOR . 'Fixtures/AssertFileDirectory_Readable.txt';
		self::assertFileIsWritable( $path );
	}

	/**
	 * Verify availability of the assertFileNotIsWritable() method.
	 *
	 * @requires PHPUnit < 9.1.0
	 *
	 * @return void
	 */
	public function testAssertFileNotIsWritable() {
		$tempFile = \tempnam( \sys_get_temp_dir(), 'not_writable' );
		\chmod( $tempFile, \octdec( '0' ) );

		$this->assertFileNotIsWritable( $tempFile );

		\chmod( $tempFile, \octdec( '755' ) );
		\unlink( $tempFile );
	}

	/**
	 * Helper function: retrieve the name of the "assertion failed" exception to expect (PHPUnit cross-version).
	 *
	 * @return string
	 */
	public function getAssertionFailedExceptionName() {
		$exception = 'PHPUnit\Framework\AssertionFailedError';
		if ( \class_exists( 'PHPUnit_Framework_AssertionFailedError' ) ) {
			// PHPUnit < 6.
			$exception = 'PHPUnit_Framework_AssertionFailedError';
		}

		return $exception;
	}
}
