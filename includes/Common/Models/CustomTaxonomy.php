<?php
/**
 * Model Class: Custom Taxonomy
 *
 * This class is responsible for creating a Custom Taxonomy.
 *
 * @package ThemeStarter\Signature
 * @since   1.0.0
 */

declare( strict_types = 1 );

namespace ThemeStarter\Signature\Common\Models;

use ThemeStarter\Signature\Common\Functions\Helpers;

/**
 * Class: Taxonomy
 *
 * @since  1.0.0
 */
class CustomTaxonomy {
	/**
	 * Taxonomy name.
	 *
	 * @var string
	 * @since  1.0.0
	 */
	public $taxonomyName;

	/**
	 * Custom Post Type name.
	 *
	 * @var array
	 * @since  1.0.0
	 */
	public $postTypeName = [];

	/**
	 * Taxonomy slug.
	 *
	 * @var string
	 * @since  1.0.0
	 */
	public $taxonomySlug;

	/**
	 * Taxonomy args.
	 *
	 * @var array
	 * @since  1.0.0
	 */
	public $taxonomyArgs;

	/**
	 * Taxonomy labels.
	 *
	 * @var array
	 * @since  1.0.0
	 */
	public $taxonomyLabels;

	/**
	 * Class Constructor.
	 *
	 * Registers a custom taxonomy.
	 *
	 * @param string $name Taxonomy name.
	 * @param string $postType Post type name.
	 * @param string $slug Taxonomy slug.
	 * @param array  $labels Taxonomy labels.
	 * @param array  $args Taxonomy args.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function __construct( $name, $postType, $slug, $labels = [], $args = [] ) {
		$this->taxonomyName   = Helpers::uglify( $name );
		$this->postTypeName   = $postType;
		$this->taxonomySlug   = $slug;
		$this->taxonomyArgs   = $args;
		$this->taxonomyLabels = $labels;

		// Register the taxonomy, if the taxonomy does not already exist.
		if ( ! taxonomy_exists( $this->taxonomyName ) ) {
			// Registering the Custom Taxonomy.
			add_action( 'init', [ $this, 'register' ] );
		} else {
			// If the taxonomy already exists, attaching it to the post type.
			add_action( 'init', [ $this, 'attach' ] );
		}
	}

	/**
	 * Method to register the taxonomy.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function register() {

		// Capitalize the words and make it plural.
		$name     = Helpers::beautify( $this->taxonomyName );
		$plural   = Helpers::pluralize( $name );
		$menuName = strpos( $this->taxonomyName, 'tag' ) !== false ? Helpers::pluralize( 'Tag' ) : Helpers::pluralize( 'Category' );

		// Setting the default labels.
		$labels = array_merge(
			[
				'name'              => sprintf(
					/* translators: %s: taxonomy plural name */
					esc_html_x( 'Name: %s', 'taxonomy general name', 'signature' ),
					$plural
				),
				'singular_name'     => sprintf(
					/* translators: %s: taxonomy singular name */
					esc_html_x( 'Name: %s', 'taxonomy singular name', 'signature' ),
					$name
				),
				/* translators: %s: taxonomy plural name */
				'search_items'      => sprintf( esc_html__( 'Search %s', 'signature' ), $plural ),
				/* translators: %s: taxonomy plural name */
				'all_items'         => sprintf( esc_html__( 'All %s', 'signature' ), $plural ),
				/* translators: %s: taxonomy name */
				'parent_item'       => sprintf( esc_html__( 'Parent %s', 'signature' ), $name ),
				/* translators: %s: taxonomy name */
				'parent_item_colon' => sprintf( esc_html__( 'Parent %s:', 'signature' ), $name ),
				/* translators: %s: taxonomy name */
				'edit_item'         => sprintf( esc_html__( 'Edit %s', 'signature' ), $name ),
				/* translators: %s: taxonomy name */
				'update_item'       => sprintf( esc_html__( 'Update %s', 'signature' ), $name ),
				/* translators: %s: taxonomy name */
				'add_new_item'      => sprintf( esc_html__( 'Add New %s', 'signature' ), $name ),
				/* translators: %s: taxonomy name */
				'new_item_name'     => sprintf( esc_html__( 'New %s Name', 'signature' ), $name ),
				'menu_name'         => sprintf(
					/* translators: %s: taxonomy modified name */
					esc_html__( 'Name: %s', 'signature' ),
					$menuName
				),
			],
			$this->taxonomyLabels
		);

		// Setting the default arguments.
		$args = array_merge(
			[
				'label'             => $plural,
				'labels'            => $labels,
				'hierarchical'      => ! ( strpos( $this->taxonomyName, 'tag' ) !== false ),
				'public'            => true,
				'has_archive'       => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'show_ui'           => true,
				'show_in_nav_menus' => true,
				'rewrite'           => [
					'slug' => $this->taxonomySlug,
				],
			],
			$this->taxonomyArgs
		);

		// Register the taxonomy.
		register_taxonomy( $this->taxonomySlug, $this->postTypeName, $args );
	}

	/**
	 * Method to attach the taxonomy.
	 *
	 * @return void
	 * @since  1.0.0
	 */
	public function attach() {

		// Capitalize the words.
		$name = Helpers::beautify( $this->taxonomyName );

		// Register the taxonomy.
		register_taxonomy_for_object_type( $name, $this->postTypeName );
	}
}
