<?php
/**
 * Fired during plugin activation
 *
 * @link       https://example.com
 * @since      1.0.0
 *
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Wp_Book
 * @subpackage Wp_Book/includes
 * @author     Divya <divya.narhe@gmail.com>
 */
class Wp_Book_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public function activate() {
		$this->init_db_myplugin();
	}
	/**
	 * Initialize DB Tables.
	 *
	 * @return void
	 */
	public function init_db_myplugin() {

		// WP Globals.
		global $table_prefix, $wpdb;

		// book Table.
		$book_table = $table_prefix . 'bookmeta';

		// Create book Table if not exist.
		if ( $wpdb->get_var( "SHOW tables like '$book_table'" ) !== $book_table ) {

			// dynamic generate table.
			$table_query = 'CREATE TABLE `' . $book_table . "` (  
				`meta_id` bigint(20) NOT NULL AUTO_INCREMENT,  
				`book_id` bigint(20) NOT NULL DEFAULT '0',  
				`meta_key` varchar(255) DEFAULT NULL,  
				`meta_value` longtext,  
				PRIMARY KEY (`meta_id`),  
				KEY `book_id` (`book_id`),  
				KEY `meta_key` (`meta_key`)) ENGINE=InnoDB DEFAULT CHARSET=utf8";

			require_once ABSPATH . 'wp-admin/includes/upgrade.php';
			dbDelta( $table_query );
		}
	}
}
