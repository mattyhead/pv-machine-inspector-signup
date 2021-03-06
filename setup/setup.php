<?php
/**
 * The manage database install and update.
 *
 * @link  philadelphiavotes.com
 * @since 1.0.0
 *
 * @package    Pv_Machine_Inspector_Signup
 * @subpackage Pv_Machine_Inspector_Signup/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Pv_Machine_Inspector_Signup
 * @subpackage Pv_Machine_Inspector_Signup/admin
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */
class Pv_Machine_Inspector_Signup_Db {


	/**
	 * The ID of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $plugin_name    The ID of this plugin.
	 */
	public $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $version    The current version of this plugin.
	 */
	public $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 */
	public function __construct() {
		require_once 'config.php';

		$config = new Pv_Machine_Inspector_Signup_Config();
		$this->plugin_name = $config->plugin_name;
		$this->version = $config->version;
	}

	/**
	 * Create
	 *
	 * @return boolean  ( description_of_the_return_value )
	 */
	public function create() {

		$current_db_version = get_option( $this->plugin_name . '_db_version' );
		if ( ! $current_db_version ) {

			// Perform any databases modifications related to plugin activation here, if necessary.
			include_once ABSPATH . 'wp-admin/includes/upgrade.php' ;

			add_option( $this->plugin_name . '_db_version', $this->version );

			global $wpdb;

			$table_name = $wpdb->prefix . 'pv_machine_inspector_signups';
			$sql = "DROP TABLE IF EXISTS `$table_name` ";

			$wpdb->query( $sql );

			$schema = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'schema.sql';
			$data = dirname( __FILE__ ) . DIRECTORY_SEPARATOR . 'data.sql';

			if ( $sql = file_get_contents( $schema ) ) {
				dbDelta( str_replace( '[[db_prefix]]', $wpdb->prefix, $sql ) );
			}
			if ( $sql = file_get_contents( $data ) ) {
				dbDelta( str_replace( '[[db_prefix]]', $wpdb->prefix, $sql ) );
			}

			return true;

		} elseif ( $current_db_version !== $this->version ) {

			return $this->update();

		}

		return false;
	}

	/**
	 * Delete
	 *
	 * @return boolean  ( description_of_the_return_value )
	 */
	public function delete() {

		global $wpdb;

		include_once ABSPATH . 'wp-admin/includes/upgrade.php' ;

		delete_option( $this->plugin_name . '_db_version', $this->version );
		$table_name = $wpdb->prefix . 'pv_machine_inspector_signups';
		$sql = "DROP TABLE IF EXISTS `$table_name` ";

		$wpdb->query( $sql );

		return true;
	}

	/**
	 * Update
	 *
	 * @return boolean  ( description_of_the_return_value )
	 */
	public function update() {

		global $wpdb;

		include_once ABSPATH . 'wp-admin/includes/upgrade.php' ;

		$update = plugin_dir_path( __FILE__ ) . 'update.sql';

		if ( $sql = file_get_contents( $update ) ) {
			dbDelta( str_replace( '[[db_prefix]]', $wpdb->prefix, $sql ) );
		}

		return true;
	}
}
