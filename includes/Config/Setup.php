<?php
/**
 * Config Class: Setup.
 *
 * Theme core setup actions.
 *
 * @package ThemeStarter\Signature
 * @since   1.0.0
 */

declare( strict_types=1 );

namespace ThemeStarter\Signature\Config;

use ThemeStarter\Signature\Common\Abstracts\Base;
use ThemeStarter\Signature\Common\Traits\Singleton;

// Do not allow directly accessing this file.
if ( ! defined( 'ABSPATH' ) ) {
	exit( 'This script cannot be accessed directly.' );
}

/**
 * Config Class: Setup.
 *
 * @since 1.0.0
 */
final class Setup {
	/**
	 * Singleton trait.
	 *
	 * @see Singleton
	 * @since 1.0.0
	 */
	use Singleton;

	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function setupCore() {
		$this
			// Register theme features.
			->registerThemeSupports()

			 // Register image sizes.
			 ->registerImageSizes()

			// Register nav menus.
			->registerMenus();

		// Register widget locations.
		Widgets::instance()->registerWidgets();
	}

	/**
	 * Register all the theme features.
	 *
	 * @return Setup
	 * @since 1.0.0
	 */
	public function registerThemeSupports() {
		/**
		 * Add default posts and comments RSS feed links to head.
		 */
		add_theme_support( 'automatic-feed-links' );

		/**
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support( 'title-tag' );

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support( 'post-thumbnails' );

		/**
		 * Add support for post formats.
		 */
		add_theme_support(
			'post-formats',
			apply_filters(
				'sd/signature/registered_post_formats',
				[
					'gallery',
					'audio',
					'video',
					'quote',
					'link',
				]
			),
		);

		/**
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			[
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			]
		);

		/**
		 * Set up the WordPress core custom header feature.
		 */
		add_theme_support(
			'custom-header',
			apply_filters(
				'sd/signature/custom_header_args',
				[
					'default-image'      => '',
					'default-text-color' => '000000',
					'width'              => 1920,
					'height'             => 1080,
					'flex-width'         => true,
					'flex-height'        => true,
					'wp-head-callback'   => [ $this, 'headerCallback' ],
				]
			)
		);

		/**
		 * Register default headers.
		 */
		register_default_headers(
			[
				'default-image' => [
					'url'           => '%s/assets/images/default-header.jpg',
					'thumbnail_url' => '%s/assets/images/default-header.jpg',
					'description'   => esc_html__( 'Default Header Image', 'signature' ),
				],
			]
		);

		/**
		 * Set up the WordPress core custom background feature.
		 */
		add_theme_support(
			'custom-background',
			apply_filters(
				'sd/signature/custom_background_args',
				[
					'default-color' => 'ffffff',
					'default-image' => '',
				]
			)
		);

		/**
		 * Add support for core custom logo.
		 *
		 * @link https://codex.wordpress.org/Theme_Logo
		 */
		add_theme_support(
			'custom-logo',
			[
				'width'       => 400,
				'height'      => 100,
				'flex-width'  => true,
				'flex-height' => true,
				'header-text' => [ 'site-title', 'site-description' ],
			]
		);

		/**
		 * Add theme support for selective refresh for widgets.
		 */
		add_theme_support( 'customize-selective-refresh-widgets' );

		/**
		 * Adding support for Block Styles.
		 */
		add_theme_support( 'wp-block-styles' );

		/**
		 * Adding Add support for full and wide align images.
		 */
		add_theme_support( 'align-wide' );

		/**
		 * Adding support for editor styles.
		 */
		add_theme_support( 'editor-styles' );

		/**
		 * Enqueue editor styles.
		 */
		add_editor_style( 'assets/css/backend/editor-style.css' );

		/**
		 * Adding support for responsive embedded content.
		 */
		add_theme_support( 'responsive-embeds' );

		/**
		 * Adding support for custom line height controls.
		 */
		add_theme_support( 'custom-line-height' );

		/**
		 * Adding support for experimental link color control.
		 */
		add_theme_support( 'experimental-link-color' );

		/**
		 * Adding support for experimental cover block spacing.
		 */
		add_theme_support( 'custom-spacing' );

		/**
		 * Adding support for appearance tools.
		 */
		add_theme_support( 'appearance-tools' );

		/**
		 * Adding support for borders.
		 */
		add_theme_support( 'border' );

		/**
		 * Adding support for link color.
		 */
		add_theme_support( 'link-color' );

		/**
		 * Adding support for custom units.
		 *
		 * This was removed in WordPress 5.6 but is still required to
		 * properly support WP 5.5.
		 */
		add_theme_support( 'custom-units', 'px', 'rem', 'em' );

		/**
		 * Add theme support for custom editor color palette.
		 */
		add_theme_support(
			'editor-color-palette',
			[
				[
					'name'  => esc_html__( 'Primary Color', 'signature' ),
					'slug'  => 'signature-primary',
					'color' => '#0074d9',
				],
				[
					'name'  => esc_html__( 'Secondary Color', 'signature' ),
					'slug'  => 'signature-secondary',
					'color' => '#ff4136',
				],
				[
					'name'  => esc_html__( 'Dark Gray', 'signature' ),
					'slug'  => 'signature-button-dark-gray',
					'color' => '#00235a',
				],
				[
					'name'  => esc_html__( 'Light Gray', 'signature' ),
					'slug'  => 'signature-button-light-gray',
					'color' => '#a5a6aa',
				],
				[
					'name'  => esc_html__( 'White', 'signature' ),
					'slug'  => 'signature-button-white',
					'color' => '#ffffff',
				],
			]
		);

		/**
		 * Add theme support for custom editor gradient presets.
		 */
		add_theme_support(
			'editor-gradient-presets',
			[
				[
					'name'     => esc_html__( 'Gradient Color', 'signature' ),
					'gradient' => 'linear-gradient(135deg, #0074d9 0%, #3ba4ff 100%)',
					'slug'     => 'signature_gradient_color',
				],
			]
		);

		/**
		 * Add theme support for custom editor font sizes.
		 */
		add_theme_support(
			'editor-font-sizes',
			[
				[
					'name' => esc_html__( 'Small', 'signature' ),
					'size' => 12,
					'slug' => 'small',
				],
				[
					'name' => esc_html__( 'Normal', 'signature' ),
					'size' => 16,
					'slug' => 'normal',
				],
				[
					'name' => esc_html__( 'Large', 'signature' ),
					'size' => 36,
					'slug' => 'large',
				],
				[
					'name' => esc_html__( 'Huge', 'signature' ),
					'size' => 44,
					'slug' => 'huge',
				],
			]
		);

		return $this;
	}

	/**
	 * Registering Nav menu Locations.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function registerMenus() {
		$args = [
			'primary_nav'  => esc_html__( 'Primary Navigation Menu', 'signature' ),
			'handheld_nav' => esc_html__( 'Mobile Navigation Menu', 'signature' ),
		];

		register_nav_menus( $args );
	}

	/**
	 * Register all the theme image sizes.
	 *
	 * @return Setup
	 * @since 1.0.0
	 */
	public function registerImageSizes() {
		$imageSizes = apply_filters(
			'sd/signature/registered_image_sizes',
			[
				'signature-featured-image' => [
					'width'  => 800,
					'height' => 533,
					'crop'   => true,
				],
				'signature-square-image'   => [
					'width'  => 800,
					'height' => 800,
					'crop'   => true,
				],
			]
		);

		foreach ( $imageSizes as $name => $size ) {
			$width  = isset( $size['width'] ) ? absint( $size['width'] ) : 0;
			$height = isset( $size['height'] ) ? absint( $size['height'] ) : 0;
			$crop   = isset( $size['crop'] ) && $size['crop'];

			add_image_size( sanitize_text_field( $name ), $width, $height, $crop );
		}

		return $this;
	}

	/**
	 * Styles the header image and text displayed on the blog.
	 *
	 * @return void
	 * @since 1.0.0
	 */
	public function headerCallback() {
		$headerTextColor = get_header_textcolor();

		/*
		 * If no custom options for text are set, let's bail.
		 * get_header_textcolor() options: Any hex value, 'blank' to hide text.
		 * Default: add_theme_support( 'custom-header' ).
		 */
		if ( get_theme_support( 'custom-header', 'default-text-color' ) === $headerTextColor ) {
			return;
		}

		// If we get this far, we have custom styles. Let's do this.
		?>
		<style>
			<?php
			// Has the text been hidden?
			if ( ! display_header_text() ) {
				?>
				.site-title,
				.site-description {
					position: absolute;
					clip: rect(1px, 1px, 1px, 1px);
				}
				<?php
				// If the user has set a custom color for the text use that.
			} else {
				?>
				.site-title a,
				.site-description {
					color: #<?php echo esc_attr( $headerTextColor ); ?>;
				}
				<?php
			}
			?>
		</style>
		<?php
	}
}
