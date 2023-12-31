<?php
/**
 * Utility Class: Error
 *
 * Utility to show theme errors.
 *
 * @package ThemeStarter\Signature
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace ThemeStarter\Signature\Common\Utils;

use ThemeStarter\Signature\Config\Theme;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Utility Class: Error
 *
 * @since 1.0.0
 */
class Errors {
	/**
	 * Get the theme data in static form
	 *
	 * @static
	 * @return array
	 * @since 1.0.0
	 */
	public static function getThemeData() {
		return ( new Theme() )->data();
	}

	/**
	 * Shows notice error in back-end.
	 *
	 * @static
	 *
	 * @param string $title General title of the error.
	 * @param string $message The error message.
	 * @param string $source File source of the error.
	 * @param string $subtitle Specified title of the error.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	public static function errorMessage( $title = '', $message = '', $source = '', $subtitle = '' ) {
		$error = '';

		if ( $message ) {
			$theme    = self::getThemeData();
			$title    = $title ? esc_html( $title ) : $theme['name'] . ' ' . $theme['version'] . ' ' . esc_html__( '&#8594; Fatal Error', 'signature' );
			$subtitle = $subtitle ? esc_html( $subtitle ) : $theme['name'] . ' ' . $theme['version'] . ' ' . esc_html__( '&#8594; Theme Disabled', 'signature' );
			$footer   = $source ? '<small>' .
								sprintf( /* translators: %s: file path */
									esc_html__( 'Error source: %s', 'signature' ),
									esc_html( $source )
								) . '</small>' : '';
			$error    = "<h3>$title</h3><strong>$subtitle</strong><p>$message</p><hr><p>$footer</p>";
		}

		return $error;
	}

	/**
	 * Disables some actions if requirements not met.
	 *
	 * @static
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public static function disableActions() {
		add_action( 'load-customize.php', [ __CLASS__, 'disableCustomizer' ] );
		add_action( 'template_redirect', [ __CLASS__, 'disablePreview' ] );
	}

	/**
	 * Prevents the Customizer from being loaded.
	 *
	 * @static
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function disableCustomizer() {
		wp_die(
			sprintf(
				/* translators: 2. Required WordPress version, 2. Current WordPress version */
				esc_html__( 'You must be using WordPress %1$s or greater. You are currently using WordPress %2$s.', 'signature' ),
				esc_html( self::getThemeData()['required_wp'] ),
				esc_html( get_bloginfo( 'version' ) )
			),
			'',
			[
				'back_link' => true,
			]
		);
	}

	/**
	 * Prevents the Theme Preview from being loaded.
	 *
	 * @static
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public static function disablePreview() {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended
		if ( isset( $_GET['preview'] ) ) {
			wp_die(
				sprintf(
				/* translators: 2. Required WordPress version, 2. Current WordPress version */
					esc_html__( 'You must be using WordPress %1$s or greater. You are currently using WordPress %2$s.', 'signature' ),
					esc_html( self::getThemeData()['required_wp'] ),
					esc_html( get_bloginfo( 'version' ) )
				)
			);
		}
	}
}
