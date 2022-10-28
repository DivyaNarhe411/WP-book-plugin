<?php
/**
 * This class extends from WP_Widget class defines all code necessary to run this custom widget.
 *
 * @since           1.0.0
 * @package         Wpb
 * @subpackage      Wpb/widgets
 * @author          Tejas Sonawane <sonawane.tejas.21@gmail.com>
 * Description      Create custom widget to display books of selected category in the sidebar.
 */

/**
 * Register custom widget named WP Book Widget .
 *
 * @return void
 */
function wp_book_widget_init() {
	register_widget( 'WPB_Book_Widget' );
}
/**
 * Class to display widgets.
 */
class WPB_Book_Widget extends WP_Widget {

	/**
	 * Construct Widget Options.
	 */
	public function __construct() {
		$widget_ops = array(
			'classname'                   => 'wp_book_widget',
			'description'                 => 'To display books of selected category.',
			'customize_selective_refresh' => true,
		);
		parent::__construct( 'wp_book_widget', 'WP Book Widget', $widget_ops );

	}


	/**
	 * The widget create form (for the backend ).
	 *
	 * @param      array $instance   Current settings.
	 *
	 * @return     void.
	 */
	public function form( $instance ) {
		// Set widget defaults.
		$defaults = array(
			'title'  => '',
			'text'   => '',
			'select' => '',
		);
		// Parse current settings with defaults.
		extract( wp_parse_args( (array) $instance, $defaults ) ); ?>

		<?php
		// Text Field.
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>"><?php __( 'Text:', 'wp-book' ); ?></label>
			<input class="widefat" id="<?php echo esc_attr( $this->get_field_id( 'text' ) ); ?>" name="<?php echo esc_attr( $this->get_field_name( 'text' ) ); ?>" type="text" value="<?php echo esc_attr( $text ); ?>" />
		</p>

		<?php
		// Dropdown.
		?>
		<p>
			<label for="<?php echo esc_attr( $this->get_field_id( 'select' ) ); ?>"><?php __( 'Select', 'wp-book' ); ?></label>
			<select name="<?php echo esc_attr( $this->get_field_name( 'select' ) ); ?>" id="<?php echo esc_attr( $this->get_field_id( 'select' ) ); ?>" class="widefat">
				<?php
				$categories = get_terms( array( 'taxonomy' => 'Book Category' ) );
				foreach ( $categories as $category ) {
					echo '<option value="' . esc_attr( $category->name ) . '" id="' . esc_attr( $category->name ) . '" ' . selected( $select, $category->name, false ) . '>' . esc_attr( $category->name ) . '</option>';
				}
				?>
			</select>
			</ul>
		</p>
		<?php

	}


	/**
	 * The widget update form (for the backend ).
	 *
	 * @param    array $new_instance New settings for this instance as input by the user via WP_Widget::form().
	 * @param    array $old_instance Old settings for this instance.
	 *
	 * @return instance.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance          = $old_instance;
		$instance['title'] = '';
		if ( isset( $new_instance['title'] ) ) {
			$instance['title'] = wp_strip_all_tags( $new_instance['title'] );
		}

		$instance['text'] = '';
		if ( isset( $new_instance['text'] ) ) {
			$instance['text'] = wp_strip_all_tags( $new_instance['text'] );
		}

		$instance['select'] = '';
		if ( isset( $new_instance['select'] ) ) {
			$instance['select'] = wp_strip_all_tags( $new_instance['select'] );
		}

		return $instance;

	}//end update()


	/**
	 * The widget display form (for the backend ).
	 *
	 * @param    array $args     Display arguments including 'before_title', 'after_title', 'before_widget', and 'after_widget'.
	 * @param    array $instance The settings for the particular instance of the widget.
	 *
	 * @return void.
	 */
	public function widget( $args, $instance ) {
		extract( $args );

		// Check the widget options.
		$text = '';
		if ( isset( $instance['text'] ) ) {
			$text = $instance['text'];
		}

		$select = '';
		if ( isset( $instance['select'] ) ) {
			$select = $instance['select'];

		}

		// Display text field.
		if ( $text ) {
			echo $args['before_widget'] . $args['before_title'] . esc_attr( $text ) . $args['after_title'];
		}

		// Display select field.new books.
		$id_count = 0;
		if ( $select ) {
			$args  = array(
				'post_type'   => 'book',
				'post_status' => 'publish',
				'tax_query'   => array(
					array(
						'taxonomy' => 'Book Category',
						'field'    => 'slug',
						'terms'    => $select,
					),
				),
			);
			$query = new WP_Query( $args );

			if ( $query->have_posts() ) {

				while ( $query->have_posts() == true ) {
					$query->the_post();
					$id_count++;
					?>
					<h5><a href="<?php the_permalink(); ?>"><?php echo esc_attr( $id_count ) . '.' . get_the_title(); ?></a></h5>
					<?php
				}
			}
			wp_reset_query();
		}
	}
}
