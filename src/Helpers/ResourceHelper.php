<?php

namespace Yoast\PHPUnitPolyfills\Helpers;

use Exception;
use TypeError;

/**
 * Helper functions for working with the resource type.
 *
 * ---------------------------------------------------------------------------------------------
 * This class is only intended for internal use by PHPUnit Polyfills and is not part of the public API.
 * This also means that it has no promise of backward compatibility.
 *
 * End-user should use the {@see \Yoast\PHPUnitPolyfills\Polyfills\AssertClosedResource()} trait instead.
 * ---------------------------------------------------------------------------------------------
 *
 * @internal
 */
final class ResourceHelper {

	/**
	 * Determines whether a variable represents a resource, either open or closed.
	 *
	 * @param mixed $actual The variable to test.
	 *
	 * @return bool
	 */
	public static function isResource( $actual ) {
		return ( $actual !== null
			&& \is_scalar( $actual ) === false
			&& \is_array( $actual ) === false
			&& \is_object( $actual ) === false );
	}

	/**
	 * Determines whether a variable represents a closed resource.
	 *
	 * @param mixed $actual The variable to test.
	 *
	 * @return bool
	 */
	public static function isClosedResource( $actual ) {
		$type = \gettype( $actual );

		/*
		 * PHP 7.2 introduced "resource (closed)".
		 */
		if ( $type === 'resource (closed)' ) {
			return true;
		}

		/*
		 * If gettype did not work, attempt to determine whether this is
		 * a closed resource in another way.
		 */
		$isResource       = \is_resource( $actual );
		$isNotNonResource = self::isResource( $actual );

		if ( $isResource === false && $isNotNonResource === true ) {
			return true;
		}

		if ( $isNotNonResource === true ) {
			try {
				$resourceType = @\get_resource_type( $actual );
				if ( $resourceType === 'Unknown' ) {
					return true;
				}
			} catch ( Exception $e ) {
				// Ignore. Not a resource.
			} catch ( TypeError $e ) {
				// Ignore. Not a resource.
			}
		}

		return false;
	}
}
