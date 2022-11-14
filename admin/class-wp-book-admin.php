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
			'name'               => _x( 'Books', 'Post type general wp-book', 'wp-book' ),
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
	/**
	 * Register custom metabox for books.
	 *
	 * @param object $post Conatain all information about CPT 'book'.
	 */
	public function register_metabox_book( $post ) {
		add_meta_box( 'books-details', __( 'Books Information', ' wp-book ' ), array( $this, 'wp_custom_metabox_book_cb' ), array( 'book' ), 'normal', 'high' );

	}
	/**
	 * Register custom metabox for books.
	 *
	 * @param object $post Conatain all information about CPT 'book'.
	 */
	public function wp_custom_metabox_book_cb( $post ) {
		$get_book_metadata = get_metadata( 'book', $post->ID );
		if ( count( $get_book_metadata ) > 0 ) {
			$author    = $get_book_metadata['author_name'][0];
			$price     = $get_book_metadata['price'][0];
			$publisher = $get_book_metadata['publisher'][0];
			$year      = $get_book_metadata['year'][0];
			$edition   = $get_book_metadata['edition'][0];
			$url       = $get_book_metadata['url'][0];
		} else {
			$author    = '';
			$price     = '';
			$publisher = '';
			$year      = '';
			$edition   = '';
			$url       = '';
		}
		wp_nonce_field( basename( __FILE__ ), 'custom_books_info_nonce' );
		?>
		<table class="form-table">
			<tbody>
				<tr>
					<th scope="row"><label for="wpb-custom-author-name">
					<?php
						esc_html_e( 'Author Name', 'wp-book' );
					?>
					</label>
				</th>
					<td><input name="wpb-custom-author-name" type="text" id="wpb-custom-author-name" value="<?php echo esc_attr( $author ); ?>" placeholder= "<?php esc_html_e( 'Author Name', 'wp-book' ); ?>" class="regular-text" autocomplete="off"></td>
				</tr>
				<tr>
					<th scope="row"><label for="wpb-custom-price">
					<?php
						esc_html_e( 'Book Price', 'wp-book' );
					?>
					</label></th>
					<td><input name="wpb-custom-price" type="text" id="wpb-custom-price" value="<?php echo esc_attr( $price ); ?>" placeholder="<?php echo esc_html_e( 'Book Price', 'wp-book' ); ?> " class="regular-text" autocomplete="off"></td>
				</tr>
				<tr>
					<th scope="row"><label for="wpb-custom-publisher">
					<?php
						esc_html_e( 'Publisher', 'wp-book' );
					?>
					</label></th>
					<td><input name="wpb-custom-publisher" type="text" id="wpb-custom-publisher" value="<?php echo esc_attr( $publisher ); ?>" placeholder="<?php echo esc_html_e( 'Publisher', 'wp-book' ); ?> " class="regular-text" autocomplete="off"></td>
				</tr>
				<tr>
					<th scope="row"><label for="wpb-custom-year">
					<?php
						esc_html_e( 'Year', 'wp-book' );
					?>
					</label></th>
					<td><input name="wpb-custom-year" type="number" id="wpb-custom-year" value="<?php echo esc_attr( $year ); ?>" placeholder="<?php esc_html_e( 'Year', 'wp-book' ); ?>" class="regular-text" autocomplete="off"></td>
				</tr>
				<tr>
					<th scope="row"><label for="wpb-custom-edition">
					<?php
						esc_html_e( 'Edition', 'wp-book' );
					?>
					</label></th>
					<td><input name="wpb-custom-edition" type="text" id="wpb-custom-edition" value="<?php echo esc_attr( $edition ); ?>" placeholder="<?php echo esc_html_e( 'Edition', 'wp-book' ); ?>" class="regular-text" autocomplete="off"></td>
				</tr>
				<tr>
					<th scope="row"><label for="wpb-custom-url">
					<?php
						esc_html_e( 'URL', 'wp-book' );
					?>
					</label></th>
					<td><input name="wpb-custom-url" type="url" id="wpb-custom-url" value="<?php echo esc_attr( $url ); ?>" placeholder="<?php echo esc_html_e( 'URL eg. https://example.com', 'wp-book' ); ?>" class="regular-text" autocomplete="off"></td>
				</tr>
			</tbody>
		</table>
		<?php
	}
	/**
	 * Registers the custom table named bookmeta.
	 *
	 * @return void
	 */
	public function register_bookmeta_table() {
		global $wpdb;
		$wpdb->bookmeta = $wpdb->prefix . 'bookmeta';
	}
	/**
	 * Saving data into metabox
	 *
	 * @param object $post_id return id of current post.
	 * @param object $post Conatain all information about CPT.
	 */
	public function save_metabox_book( $post_id, $post ) {
		if ( ! isset( $_POST['custom_books_info_nonce'] ) || ! wp_verify_nonce( sanitize_key( $_POST['custom_books_info_nonce'] ), basename( __FILE__ ) ) ) {
			return $post_id;
		}

		$post_slug = 'book';

		if ( $post_slug != $post->post_type ) {
			return;
		}

		$author = '';
		if ( isset( $_POST['wpb-custom-author-name'] ) ) {
			$author = sanitize_text_field( wp_unslash( $_POST['wpb-custom-author-name'] ) );
		} else {
			$author = '';
		}

		$price = '';
		if ( isset( $_POST['wpb-custom-price'] ) ) {
			$price = sanitize_text_field( wp_unslash( $_POST['wpb-custom-price'] ) );
		} else {
			$price = '';
		}

		$publisher = '';
		if ( isset( $_POST['wpb-custom-publisher'] ) ) {
			$publisher = sanitize_text_field( wp_unslash( $_POST['wpb-custom-publisher'] ) );
		} else {
			$publisher = '';
		}

		$year = '';
		if ( isset( $_POST['wpb-custom-year'] ) ) {
			$year = sanitize_text_field( wp_unslash( $_POST['wpb-custom-year'] ) );
		} else {
			$year = '';
		}

		$edition = '';
		if ( isset( $_POST['wpb-custom-edition'] ) ) {
			$edition = sanitize_text_field( wp_unslash( $_POST['wpb-custom-edition'] ) );
		} else {
			$edition = '';
		}

		$url = '';
		if ( isset( $_POST['wpb-custom-url'] ) ) {
			$url = sanitize_text_field( wp_unslash( $_POST['wpb-custom-url'] ) );
		} else {
			$url = '';
		}

		update_metadata( 'book', $post_id, 'author_name', $author );
		update_metadata( 'book', $post_id, 'price', $price );
		update_metadata( 'book', $post_id, 'publisher', $publisher );
		update_metadata( 'book', $post_id, 'year', $year );
		update_metadata( 'book', $post_id, 'edition', $edition );
		update_metadata( 'book', $post_id, 'url', $url );

	}
	/**
	 * Create menu method.
	 *
	 * @return void
	 */
	public function book_menu() {
		add_menu_page( __( 'Booksmenu', 'wp-book' ), 'Booksmenu', 'manage_options', 'books-menu', array( $this, 'book_dashboard' ), 'dashicons-book-alt', 76 );
	}

	/**
	 * "Booksmenu" menu callback function.
	 *
	 * @return void
	 */
	public function book_dashboard() {
		ob_start();
		?>
		<div class="wrap">
		<?php
		if ( isset( $_GET['settings-updated'] ) && true == $_GET['settings-updated'] ) {
			?>
			<div class="notice notice-success"><p> 
			<?php
			esc_html_e( 'Settings Saved Successfully', 'wp-book' );
			?>
			</p></div>
			<?php
		}
		?>
			<h2>
			<?php
			esc_html_e( 'Book Settings', 'wp-book' );
			?>
			</h2>
			<p>
			<?php
			esc_html_e( 'Manages all the settings of book plugin', 'wp-book' );
			?>
			</p>

			<form method="post" action="options.php">
				<?php settings_fields( 'book_settings_group' ); ?>
				<table class="form-table">
					<tbody>
						<tr>
							<th scope="row"><label for="book_currency">
							<?php
								esc_html_e( 'Currency', 'wp-book' );
							?>
								</label></th>
							<?php $currency_option = get_option( 'book_currency' ); ?>
							<td>
								<select name="book_currency" id="book_currency" class="regular-text">
									<option value="Indian Rupees" <?php selected( $currency_option, 'Indian Rupees' ); ?> >
									<?php
										esc_html_e( 'Indian Rupees', 'wp-book' );
									?>
									</option>
									<option value="US Dollar" <?php selected( $currency_option, 'US Dollar' ); ?> >
									<?php
										esc_html_e( 'US Dollar', 'wp-book' );
									?>
									</option>
									<option value="UK Pound Sterling" <?php selected( $currency_option, 'UK Pound Sterling' ); ?> >
									<?php
										esc_html_e( 'UK Pound Sterling', 'wp-book' );
									?>
									</option>
								</select>
							</td>
						</tr>
						<tr>
							<th scope="row"><label for="book_no_pages">
							<?php
								esc_html_e( 'No. of Books (per page)', 'wp-book' );
							?>
							</label></th>
							<td><input type="text" class="regular-text" name="book_no_pages" id="book_no_pages" placeholder="<?php esc_html_e( 'No.of Books', 'wp-book' ); ?>" value="<?php echo esc_attr( get_option( 'book_no_pages' ) ); ?>"></td>
						</tr>
						<tr>
							<td><input type="submit" value="
							<?php esc_html_e( 'Save Changes' ); ?>
							" class="button-primary"></td>
						</tr>
					</tbody>
				</table>
			</form>
		</div>
		<?php
		echo ob_get_clean();
	}
	/**
	 * Registers the settings group for each input field.
	 */
	public function register_book_settings() {
		register_setting( 'book_settings_group', 'book_currency' );
		register_setting( 'book_settings_group', 'book_no_pages' );
	}

	/**
	 * Create a custom widget for dashboard
	 *
	 * @return void
	 */
	public function custom_dashboard_widgets() {
		global $wp_meta_boxes;
		wp_add_dashboard_widget( 'book_widget', 'Top 5 Book Categories', array( $this, 'custom_dashboard_help' ) );
	}

	/**
	 * Provides Top 5 categories of book post type based on their count.
	 *
	 * @return void
	 */
	public function custom_dashboard_help() {
		global $wpdb;
		$get_term_ids   = $wpdb->get_col( "SELECT term_id FROM `wp_term_taxonomy` WHERE taxonomy = 'Book Category' ORDER BY count DESC LIMIT 5" );
		$top_terms_name = array();
		$top_terms_slug = array();
		foreach ( $get_term_ids as $id ) {
			$get_term = $wpdb->get_row( "SELECT name, slug FROM wp_terms WHERE term_id = $id", 'ARRAY_A' );
			array_push( $top_terms_name, $get_term['name'] );
			array_push( $top_terms_slug, $get_term['slug'] );
		}
		?>
		<ol>
			<?php
			$len = count( $top_terms_name );
			for ( $i = 0; $i < $len; $i++ ) {
				echo "<li style='font-size:15px;'> <a target='_blank' href=" . get_site_url() . "/book-category/$top_terms_slug[$i]>$top_terms_name[$i] </li>";
			}
			?>
		</ol>
		<?php
	}

}
