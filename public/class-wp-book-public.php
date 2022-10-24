<?php
/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/public
 * @author     Divya <divya.narhe@gmail.com>
 */
class Wp_Book_Public {

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
	 * @param      string $plugin_name       The name of the plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-book-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-book-public.js', array( 'jquery' ), $this->version, false );

	}
	/**
	 * Returns the information of book to shortcode named book.
	 *
	 * @since    1.0.0
	 * @param      array $atts       Contains the attributes passed in shortcode.
	 */
	public function load_book_content( $atts ) {

		$attributes = shortcode_atts(
			array(
				'id'          => 0,
				'author_name' => '',
				'publisher'   => '',
				'year'        => '',
				'tag'         => '',
				'category'    => '',
				'edition'     => '',
				'url'         => '',
				'price'       => '',
			),
			$atts
		);

		if ( '' != $attributes['category'] || '' != $attributes['tag'] ) {
			$args = array(
				'p'              => $attributes['id'],
				'post_type'      => 'book',
				'post_status'    => 'publish',
				'posts_per_page' => get_option( 'book_no_pages' ),
				'tax_query'      => array(
					'relation' => 'OR',
					array(
						'taxonomy'         => 'Book Category',
						'field'            => 'slug',
						'terms'            => explode( ',', $attributes['category'] ),
						'include_children' => true,
						'operator'         => 'IN',
					),
					array(
						'taxonomy'         => 'Book Tag',
						'field'            => 'slug',
						'terms'            => explode( ',', $attributes['tag'] ),
						'include_children' => false,
						'operator'         => 'IN',
					),
				),
			);
		} elseif ( '' !== $attributes['author_name'] || '' !== $attributes['publisher'] || '' !== $attributes['year'] || '' != $attributes['edition'] || '' !== $attributes['url'] || '' !== $attributes['price'] ) {
			$args = array(
				'p'              => $attributes['id'],
				'post_type'      => 'book',
				'post_status'    => 'publish',
				'posts_per_page' => get_option( 'book_no_pages' ),
				'meta_query'     => array(
					'relation' => 'OR',
					array(
						'key'     => 'author_name',
						'value'   => explode( ',', $attributes['author_name'] ),
						'compare' => 'IN',
					),
					array(
						'key'     => 'publisher',
						'value'   => explode( ',', $attributes['publisher'] ),
						'compare' => 'IN',
					),
					array(
						'key'     => 'year',
						'value'   => explode( ',', $attributes['year'] ),
						'compare' => 'IN',
					),
					array(
						'key'     => 'edition',
						'value'   => explode( ',', $attributes['edition'] ),
						'compare' => 'IN',
					),
					array(
						'key'     => 'url',
						'value'   => explode( ',', $attributes['url'] ),
						'compare' => 'IN',
					),
					array(
						'key'     => 'price',
						'value'   => explode( ',', $attributes['price'] ),
						'compare' => 'IN',
					),
				),
			);
		} else {
			$args = array(
				'p'              => $attributes['id'],
				'post_type'      => 'book',
				'post_status'    => 'publish',
				'posts_per_page' => get_option( 'book_no_pages' ),
			);
		}

		$content = '';

		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				$currency       = get_option( 'book_currency' );
				$book_metadata  = get_metadata( 'book', get_the_ID() );
				$currency_in_no = get_metadata( 'book', get_the_ID(), 'price', true );
				if ( '' === $book_metadata['publisher'][0] || '' === $currency_in_no || '' === $book_metadata['year'][0] || '' === $book_metadata['edition'][0] || '' === $book_metadata['url'][0] ) {
					$book_metadata['publisher'][0] = 'N.A.';
					$price                         = 'N.A.';
					$book_metadata['year'][0]      = 'N.A.';
					$book_metadata['edition'][0]   = 'N.A.';
					$book_metadata['url'][0]       = '';
				} else {
					if ( 'US Dollar' == $currency ) {
						$price = '$' . (int) $currency_in_no * 0.013;
					}
					if ( 'Indian Rupees' == $currency ) {
						$price = '&#8377;' . (int) $currency_in_no;
					}
					if ( 'UK Pound Sterling' == $currency ) {
						$price = '&#163;' . (int) $currency_in_no * 0.010;
					}
				}

				$content .= '<div>';
				$content .= '<h3 style="text-align:center">' . get_the_title() . '</h3>';
				$content .= '<table>';
				$content .= '<tbody>';
				$content .= '<tr>';
				$content .= '<td colspan="2"><p>Author: ' . $book_metadata['author_name'][0] . '</p></td>';
				$content .= '</tr>';
				$content .= '<tr>';
				$content .= '<td><p>Price: ' . $price . '</p></td>';
				$content .= '<td><p>Publisher: ' . $book_metadata['publisher'][0] . '</p></td>';
				$content .= '</tr>';
				$content .= '<tr>';
				$content .= '<td><p>Year: ' . $book_metadata['year'][0] . '</p></td>';
				$content .= '<td><p>Edition: ' . $book_metadata['edition'][0] . '</p></td>';
				$content .= '</tr>';
				$content .= '<tr>';
				$content .= '<td colspan="2"><p style="text-align:center">For more information: <a href="' . $book_metadata['url'][0] . '" target="_blank">' . $book_metadata['url'][0] . '</p></td>';
				$content .= '</tr>';
				$content .= '</tbody>';
				$content .= '</table>';
				$content .= '</div>';
			}
		} else {
			$content .= '<p style="color:red; text-align:center">No Book Found....</p>';
		}

		return $content;
	}

}
