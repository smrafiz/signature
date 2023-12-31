<?php
/**
 * Config Class: Widgets.
 *
 * Register various widget locations.
 *
 * @package ThemeStarter\Signature
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace ThemeStarter\Signature\Config;

use ThemeStarter\Signature\Common\Traits\Singleton;
use ThemeStarter\Signature\Common\Functions\Helpers;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Config Class: Setup.
 *
 * @since 1.0.0
 */
final class Widgets {
	/**
	 * Singleton trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Registering Nav menu Locations.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function registerWidgets() {
		add_action( 'widgets_init', [ $this, 'widgetLocations' ] );
	}

	/**
	 * Widgets Locations.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function widgetLocations() {
		$this->sidebar()->footer();
	}

	/**
	 * Widgets: Sidebar.
	 *
	 * @return Widgets
	 * @since 1.0.0
	 */
	private function sidebar() {
		self::registerWidgetArea(
			[
				'name'        => esc_html__( 'Sidebar (General)', 'signature' ),
				'id'          => esc_attr( 'signature-sidebar-general' ),
				'description' => esc_html__( 'This sidebar will show everywhere the sidebar is enabled, both Posts and Pages.', 'signature' ),
			]
		);

		self::registerWidgetArea(
			[
				'name'        => esc_html__( 'Sidebar (Blog)', 'signature' ),
				'id'          => esc_attr( 'signature-sidebar-blog' ),
				'description' => esc_html__( 'This sidebar will show in Blog (Posts) page.', 'signature' ),
			]
		);

		if ( Helpers::hasWoocommerce() ) {
			self::registerWidgetArea(
				[
					'name'        => esc_html__( 'Sidebar (Shop)', 'signature' ),
					'id'          => esc_attr( 'signature-sidebar-shop' ),
					'description' => esc_html__( 'This sidebar will show in Shop page.', 'signature' ),
				]
			);
		}

		return $this;
	}

	/**
	 * Widgets: Footer.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	private function footer() {
		for ( $footer_col = 1; $footer_col <= 4; $footer_col++ ) {
			self::registerWidgetArea(
				[
					'name'          => esc_html__( 'Footer', 'signature' ) . ' - ' . esc_attr( $footer_col ),
					'id'            => esc_attr( 'signature-footer-col-' ) . esc_attr( $footer_col ),
					'description'   => esc_html__( 'The widget area for the footer column', 'signature' ) . ' - ' . esc_attr( $footer_col ),
					'before_widget' => '<aside id="%1$s" class="%2$s footer-widget">',
					'after_widget'  => '</aside>',
				]
			);
		}
	}

	/**
	 * Method to expedite the widget area registration process.
	 *
	 * @param array $args Widget arguments.
	 *
	 * @return string
	 * @since 1.0.0
	 */
	private static function registerWidgetArea( array $args ) {
		$defaults = [
			'before_widget' => '<section id="%1$s" class="%2$s sidebar-widget">',
			'after_widget'  => '</section>',
			'before_title'  => '<h4 class="widget-title widgettitle">',
			'after_title'   => '</h4>',
		];

		$defaults = apply_filters( 'sd/signature/widget_area_defaults', $defaults, $args );

		$args = wp_parse_args( $args, $defaults );

		return register_sidebar( $args );
	}
}
