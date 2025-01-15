<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

use PHPUnit\SebastianBergmann\Exporter\Exporter as Exporter_In_Phar_Old;
use PHPUnitPHAR\SebastianBergmann\Exporter\Exporter as Exporter_In_Phar;
use SebastianBergmann\Exporter\Exporter;
use Yoast\PHPUnitPolyfills\Helpers\ResourceHelper;

/**
 * Polyfill the assertContainsNotOnlyInstancesOf(), assertContainsOnlyArray(), assertContainsOnlyBool(),
 * assertContainsOnlyCallable(), assertContainsOnlyFloat(), assertContainsOnlyInt(),
 * assertContainsOnlyIterable(), assertContainsOnlyNull(), assertContainsOnlyNumeric(),
 * assertContainsOnlyObject(), assertContainsOnlyResource(), assertContainsOnlyClosedResource(),
 * assertContainsOnlyScalar(), assertContainsOnlyString(), assertContainsNotOnlyArray(),
 * assertContainsNotOnlyBool(), assertContainsNotOnlyCallable(), assertContainsNotOnlyFloat(),
 * assertContainsNotOnlyInt(), assertContainsNotOnlyIterable(), assertContainsNotOnlyNull(),
 * assertContainsNotOnlyNumeric(), assertContainsNotOnlyObject(), assertContainsNotOnlyResource(),
 * assertContainsNotOnlyClosedResource(), assertContainsNotOnlyScalar(), and assertContainsNotOnlyString() methods.
 *
 * Introduced in PHPUnit 11.5.0.
 *
 * @link https://github.com/sebastianbergmann/phpunit/commit/a726e0396e71cc77bc0b459f93481c29e726dbd8
 *
 * @since 3.1.0
 */
trait AssertContainsOnly {

	/**
	 * Asserts that $haystack does not only contain instances of class or interface $type.
	 *
	 * @param string          $className Class or interface name.
	 * @param iterable<mixed> $haystack  The variable to test.
	 * @param string          $message   Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyInstancesOf( string $className, iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( $className, $haystack, false, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type array.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyArray( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'array', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type array.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyArray( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'array', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type boolean.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyBool( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'bool', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type boolean.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyBool( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'bool', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type callable.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyCallable( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'callable', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type callable.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyCallable( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'callable', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type float.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyFloat( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'float', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type float.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyFloat( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'float', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type integer.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyInt( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'int', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type integer.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyInt( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'int', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type iterable.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyIterable( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'iterable', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type iterable.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyIterable( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'iterable', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type null.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyNull( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'null', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type null.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyNull( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'null', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type numeric.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyNumeric( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'numeric', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type numeric.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyNumeric( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'numeric', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type object.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyObject( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'object', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type object.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyObject( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'object', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type resource.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyResource( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'resource', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type resource.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyResource( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'resource', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type closed resource.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyClosedResource( iterable $haystack, string $message = '' ): void {
		$exporter = self::getPHPUnitExporterObjectForContainsOnly();
		$msg      = \sprintf( 'Failed asserting that %s contains only values of type "resource (closed)".', $exporter->export( $haystack ) );

		if ( $message !== '' ) {
			$msg = $message . \PHP_EOL . $msg;
		}

		$hasOnlyClosedResources = true;
		foreach ( $haystack as $value ) {
			if ( ResourceHelper::isClosedResource( $value ) ) {
				continue;
			}

			$hasOnlyClosedResources = false;
			break;
		}

		static::assertTrue( $hasOnlyClosedResources, $msg );
	}

	/**
	 * Asserts that $haystack does not only contain values of type closed resource.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyClosedResource( iterable $haystack, string $message = '' ): void {
		$exporter = self::getPHPUnitExporterObjectForContainsOnly();
		$msg      = \sprintf( 'Failed asserting that %s does not contain only values of type "resource (closed)".', $exporter->export( $haystack ) );

		if ( $message !== '' ) {
			$msg = $message . \PHP_EOL . $msg;
		}

		$hasOnlyClosedResources = true;
		foreach ( $haystack as $value ) {
			if ( ResourceHelper::isClosedResource( $value ) ) {
				continue;
			}

			$hasOnlyClosedResources = false;
			break;
		}

		static::assertFalse( $hasOnlyClosedResources, $msg );
	}

	/**
	 * Asserts that $haystack only contains values of type scalar.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyScalar( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'scalar', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type scalar.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyScalar( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'scalar', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type string.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyString( iterable $haystack, string $message = '' ): void {
		static::assertContainsOnly( 'string', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack does not only contain values of type string.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyString( iterable $haystack, string $message = '' ): void {
		static::assertNotContainsOnly( 'string', $haystack, true, $message );
	}

	/**
	 * Helper function to obtain an instance of the Exporter class.
	 *
	 * @return Exporter|Exporter_In_Phar|Exporter_In_Phar_Old
	 */
	private static function getPHPUnitExporterObjectForContainsOnly() {
		if ( \class_exists( Exporter::class ) ) {
			// Composer install or really old PHAR files.
			return new Exporter();
		}
		elseif ( \class_exists( Exporter_In_Phar::class ) ) {
			// PHPUnit PHAR file for 8.5.38+, 9.6.19+, 10.5.17+ and 11.0.10+.
			return new Exporter_In_Phar();
		}

		// PHPUnit PHAR file for < 8.5.38, < 9.6.19, < 10.5.17 and < 11.0.10.
		return new Exporter_In_Phar_Old();
	}
}
