<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/admin
 * @author     Divya <divya.narhe@gmail.com>
 */
class Wp_Book_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-book-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Book_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Book_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-book-admin.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * Register a custom post type called "book".
	 *
	 * @see get_post_type_labels() for label keys.
	 */
	public function wp_custom_book_init() {
		$labels = array(
			'name'               => _x( 'Books', 'Post type generwp-bookwp-book' ),
			'singular_name'      => _x( 'Book', 'Post type singular name', 'wp-book' ),
			'menu_name'          => _x( 'Books', 'Admin Menu text', 'wp-book' ),
			'name_admin_bar'     => _x( 'Book', 'Add New on Toolbar', 'wp-book' ),
			'add_new'            => __( 'Add New', 'wp-book' ),
			'add_new_item'       => __( 'Add New Book', 'wp-book' ),
			'new_item'           => __( 'New Book', 'wp-book' ),
			'edit_item'          => __( 'Edit Book', 'wp-book' ),
			'view_item'          => __( 'View Book', 'wp-book' ),
			'all_items'          => __( 'All Books', 'wp-book' ),
			'search_items'       => __( 'Search Books', 'wp-book' ),
			'parent_item_colon'  => __( 'Parent Books:', 'wp-book' ),
			'not_found'          => __( 'No books found.', 'wp-book' ),
			'not_found_in_trash' => __( 'No books found in Trash.', 'wp-book' ),
		);

		$args = array(
			'labels'             => $labels,
			'public '            => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'query_var'          => true,
			'rewrite'            => array( 'slug' => 'book' ),
			'capability_type'    => 'post',
			'has_archive'        => true,
			'hierarchical'       => false,
			'taxonomies'         => array( 'Book Category', 'Book Tag' ),
			'menu_position'      => null,
			'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' ),
			'menu_icon'          => 'dashicons-book-alt',
		);

		register_post_type( 'book', $args );
	}
	/**
	 * Create a custom hierarchical taxonomy Book Category
	 */
	public function wp_custom_book_taxonomy_init() {

		$labels = array(
			'name'                       => _x( 'Book Categories', 'Taxonomy General Name', 'wp-book' ),
			'singular_name'              => _x( 'Book Category', 'Taxonomy Singular Name', 'wp-book' ),
			'menu_name'                  => __( 'Book Category', 'wp-book' ),
			'all_items'                  => __( 'All Items', 'wp-book' ),
			'parent_item'                => __( 'Parent Item', 'wp-book' ),
			'parent_item_colon'          => __( 'Parent Item:', 'wp-book' ),
			'new_item_name'              => __( 'Add Book Category', 'wp-book' ),
			'add_new_item'               => __( 'Add New Book Category', 'wp-book' ),
			'edit_item'                  => __( 'Edit Book Category', 'wp-book' ),
			'update_item'                => __( 'Update Book Category', 'wp-book' ),
			'view_item'                  => __( 'View Book Category', 'wp-book' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'wp-book' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'wp-book' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'wp-book' ),
			'popular_items'              => __( 'Popular Items', 'wp-book' ),
			'search_items'               => __( 'Search Items', 'wp-book' ),
			'not_found'                  => __( 'Not Found', 'wp-book' ),
			'no_terms'                   => __( 'No items', 'wp-book' ),
			'items_list'                 => __( 'Items list', 'wp-book' ),
			'items_list_navigation'      => __( 'Items list navigation', 'wp-book' ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
		);
		register_taxonomy( 'Book Category', array( 'book' ), $args );
	}
	/**
	 * Register Custom Non-Hierarchical Taxonomy Book Tag
	 *
	 * @return void
	 */
	public function wp_custom_tag_book_init() {

		$labels = array(
			'name'                       => _x( 'Book Tags', 'Taxonomy General Name', 'wp-book' ),
			'singular_name'              => _x( 'Book Tag', 'Taxonomy Singular Name', 'wp-book' ),
			'menu_name'                  => __( 'Book Tag', 'wp-book' ),
			'all_items'                  => __( 'All Book Tags', 'wp-book' ),
			'parent_item'                => __( 'Parent Item', 'wp-book' ),
			'parent_item_colon'          => __( 'Parent Item:', 'wp-book' ),
			'new_item_name'              => __( 'Add Book Tag', 'wp-book' ),
			'add_new_item'               => __( 'Add New Book Tag', 'wp-book' ),
			'edit_item'                  => __( 'Edit Book Tag', 'wp-book' ),
			'update_item'                => __( 'Update Book Tag', 'wp-book' ),
			'view_item'                  => __( 'View Book Tag', 'text_domain' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'wp-book' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'wp-book' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'wp-book' ),
			'popular_items'              => __( 'Popular Items', 'wp-book' ),
			'search_items'               => __( 'Search Book Tag', 'wp-book' ),
			'not_found'                  => __( 'Not Book Tag Found', 'wp-book' ),
			'no_terms'                   => __( 'No items', 'wp-book' ),
			'items_list'                 => __( 'Items list', 'wp-book' ),
			'items_list_navigation'      => __( 'Items list navigation', 'wp-book' ),
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
		);

		register_taxonomy( 'Book Tag', array( 'book' ), $args );
	}
}
