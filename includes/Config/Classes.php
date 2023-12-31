<?php
/**
 * Config Class: Classes.
 *
 * This array of classes is being used in the Bootstrap file
 * to instantiate the classes.
 *
 * @package ThemeStarter\Signature
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace ThemeStarter\Signature\Config;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Config Class: Classes.
 *
 * @since 1.0.0
 */
final class Classes {
	/**
	 * Init the classes inside these folders based on type of request.
	 *
	 * @return array
	 * @since 1.0.0
	 */
	public static function register() {
		// phpcs:disable
		// Ignore for readable array values on a single line.
		return [
			[ 'register' => 'App\\General' ],
			[ 'register' => 'App\\Rest' ],
			[ 'register' => 'App\\Backend', 'onRequest' => 'backend' ],
			[ 'register' => 'App\\Frontend', 'onRequest' => 'frontend' ],
		];
		// phpcs:enable
	}
}
