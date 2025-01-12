<?php

namespace Yoast\PHPUnitPolyfills\Polyfills;

use PHPUnit\SebastianBergmann\Exporter\Exporter as Exporter_In_Phar_Old;
use PHPUnitPHAR\SebastianBergmann\Exporter\Exporter as Exporter_In_Phar;
use SebastianBergmann\Exporter\Exporter;
use Traversable;
use Yoast\PHPUnitPolyfills\Autoload;
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
	final public static function assertContainsNotOnlyInstancesOf( string $className, $haystack, string $message = '' ) {
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
	final public static function assertContainsOnlyArray( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyArray( $haystack, string $message = '' ) {
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
	final public static function assertContainsOnlyBool( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyBool( $haystack, string $message = '' ) {
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
	final public static function assertContainsOnlyCallable( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyCallable( $haystack, string $message = '' ) {
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
	final public static function assertContainsOnlyFloat( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyFloat( $haystack, string $message = '' ) {
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
	final public static function assertContainsOnlyInt( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyInt( $haystack, string $message = '' ) {
		static::assertNotContainsOnly( 'int', $haystack, true, $message );
	}

	/**
	 * Asserts that $haystack only contains values of type iterable.
	 *
	 * {@internal Support for `iterable` was only added to the `IsType` constraint
	 * in PHPUnit 7.1.0, so this polyfill can't use a direct fall-through to the PHPUnit native
	 * functionality until the minimum supported PHPUnit version of this library would be PHPUnit 7.1.0.}
	 *
	 * @link https://github.com/sebastianbergmann/phpunit/pull/3035 PR which added support for `is_iterable`.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyIterable( $haystack, string $message = '' ) {
		if ( \function_exists( 'is_iterable' ) === true
			&& \version_compare( Autoload::getPHPUnitVersion(), '7.1.0', '>=' )
		) {
			// PHP >= 7.1 with PHPUnit >= 7.1.0.
			static::assertContainsOnly( 'iterable', $haystack, true, $message );
		}
		else {
			// PHP < 7.1 or PHPUnit 6.x/7.0.0.
			$exporter = self::getPHPUnitExporterObjectForContainsOnly();
			$msg      = \sprintf( 'Failed asserting that %s contains only values of type "iterable".', $exporter->export( $haystack ) );

			if ( $message !== '' ) {
				$msg = $message . \PHP_EOL . $msg;
			}

			$hasOnlyIterable = true;
			foreach ( $haystack as $value ) {
				if ( \is_array( $value ) || $value instanceof Traversable ) {
					continue;
				}

				$hasOnlyIterable = false;
				break;
			}

			static::assertTrue( $hasOnlyIterable, $msg );
		}
	}

	/**
	 * Asserts that $haystack does not only contain values of type iterable.
	 *
	 * {@internal Support for `iterable` was only added to the `IsType` constraint
	 * in PHPUnit 7.1.0, so this polyfill can't use a direct fall-through to the PHPUnit native
	 * functionality until the minimum supported PHPUnit version of this library would be PHPUnit 7.1.0.}
	 *
	 * @link https://github.com/sebastianbergmann/phpunit/pull/3035 PR which added support for `is_iterable`.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsNotOnlyIterable( $haystack, string $message = '' ) {
		if ( \function_exists( 'is_iterable' ) === true
			&& \version_compare( Autoload::getPHPUnitVersion(), '7.1.0', '>=' )
		) {
			// PHP >= 7.1 with PHPUnit >= 7.1.0.
			static::assertNotContainsOnly( 'iterable', $haystack, true, $message );
		}
		else {
			// PHP < 7.1 or PHPUnit 6.x/7.0.0.
			$exporter = self::getPHPUnitExporterObjectForContainsOnly();
			$msg      = \sprintf( 'Failed asserting that %s does not contain only values of type "iterable".', $exporter->export( $haystack ) );

			if ( $message !== '' ) {
				$msg = $message . \PHP_EOL . $msg;
			}

			$hasOnlyIterable = true;
			foreach ( $haystack as $value ) {
				if ( \is_array( $value ) || $value instanceof Traversable ) {
					continue;
				}

				$hasOnlyIterable = false;
				break;
			}

			static::assertFalse( $hasOnlyIterable, $msg );
		}
	}

	/**
	 * Asserts that $haystack only contains values of type null.
	 *
	 * @param iterable<mixed> $haystack The variable to test.
	 * @param string          $message  Optional failure message to display.
	 *
	 * @return void
	 */
	final public static function assertContainsOnlyNull( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyNull( $haystack, string $message = '' ) {
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
	final public static function assertContainsOnlyNumeric( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyNumeric( $haystack, string $message = '' ) {
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
	final public static function assertContainsOnlyObject( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyObject( $haystack, string $message = '' ) {
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
	final public static function assertContainsOnlyResource( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyResource( $haystack, string $message = '' ) {
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
	final public static function assertContainsOnlyClosedResource( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyClosedResource( $haystack, string $message = '' ) {
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
	final public static function assertContainsOnlyScalar( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyScalar( $haystack, string $message = '' ) {
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
	final public static function assertContainsOnlyString( $haystack, string $message = '' ) {
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
	final public static function assertContainsNotOnlyString( $haystack, string $message = '' ) {
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
