<?php
/**
 * The admin-specific functionality of the plugin.
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
 **/
class Pv_Machine_Inspector_Signup_Admin {

	/**
	 * The configurator object.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    mixed
	 */
	private $config;

	/**
	 * The helpers object.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    mixed
	 */
	private $helpers;

	/**
	 * The messaging object.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    mixed
	 */
	private $messaging;

	/**
	 * The .
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    mixed
	 */
	private $models;

	/**
	 * The ID of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The admin form actions of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    mixed
	 */
	private $validators;

	/**
	 * The version of this plugin.
	 *
	 * @since  1.0.0
	 * @access private
	 * @var    string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since 1.0.0
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->config = get_option( $this->plugin_name );

		// needed admin classes.
		$this->get_helpers();
		$this->get_messaging();
		$this->get_models();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_styles() {

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/pv-machine-inspector-signup-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( $this->plugin_name . '-pv-core', plugins_url( 'pv-core/css/pv-core-admin.css', 'pv-core' ), array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since 1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/pv-machine-inspector-signup-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( $this->plugin_name . '-pv-core', plugins_url( 'pv-core/js/pv-core-admin.js', 'pv-core' ), array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since 1.0.0
	 */
	public function add_plugin_admin_child_menu() {

		if ( isset( $GLOBALS['admin_page_hooks']['phillyvotes'] ) ) {
			// parent exists.  write just a child menu.
			add_submenu_page(
				'phillyvotes', __( 'Machine Inspector Signup', $this->plugin_name ), 'Machine Inspectors', 'manage_options', $this->plugin_name, array( $this, 'display_plugin_manage_display_page' )
			);
		} else {
			// woops.  no parent.  wire parent and child to display page.
			add_menu_page( __( 'Machine Inspectors', $this->plugin_name ), 'Phillyvotes', 'manage_options', 'phillyvotes', array( $this, 'display_plugin_manage_display_page' ) );
			add_submenu_page( 'phillyvotes', __( 'Machine Inspector Signup', $this->plugin_name ), 'Machine Inspectors', 'manage_options', $this->plugin_name, array( $this, 'display_plugin_manage_display_page' ) );
		}

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since 1.0.0
	 */
	public function display_plugin_manage_display_page() {

		$action = isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : false ;

		switch ( $action ) {
			case 'export':
				include_once 'partials/pv-machine-inspector-signup-admin-export.php';
				break;
			default:
				include_once 'partials/pv-machine-inspector-signup-admin-display.php';
				break;
		}

	}

	/**
	 * Load up configurator
	 *
	 * @return void
	 */
	private function get_configurator() {

		if ( ! $this->configurator ) {

			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pv-machine-inspector-signup-configurator.php';

			$this->configurator = new Pv_Machine_Inspector_Signup_Configuration( $this->plugin_name );
		}

	}

	/**
	 * Load up a model
	 *
	 * @return void
	 */
	private function get_helpers() {

		if ( ! $this->helpers ) {

			$helpers = array();

			include_once WP_PLUGIN_DIR . '/pv-core/helpers/class-pv-core-helper-select.php' ;
			include_once WP_PLUGIN_DIR . '/pv-core/helpers/class-pv-core-helper-paginator.php' ;

			$helpers['select'] = new Pv_Core_Helper_Select();
			$helpers['paginator'] = new Pv_Core_Helper_Paginator();

			$this->helpers = (object) $helpers;
		}

	}

	/**
	 * Load up messaging
	 *
	 * @return void
	 */
	private function get_messaging() {

		if ( ! $this->messaging ) {

			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pv-machine-inspector-signup-messaging.php';

			$this->messaging = new Pv_Machine_Inspector_Signup_Messaging();
		}

	}

	/**
	 * Load up a model
	 *
	 * @return void
	 */
	private function get_models() {

		if ( ! $this->models ) {

			$models = array();

			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pv-machine-inspector-signup-model-signups.php';

			$models['signups'] = new Pv_Machine_Inspector_Signup_Model_Signups( $this->get_config() );

			$this->models = (object) $models;
		}

	}

	/**
	 * Load up a validator
	 */
	private function get_validators() {

		if ( ! $this->validators ) {

			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pv-machine-inspector-signup-validation-signups.php';
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pv-machine-inspector-signup-validation-config.php';

			$validators['signups'] = new Pv_Machine_Inspector_Signup_Validation_Signups();
			$validators['config'] = new Pv_Machine_Inspector_Signup_Validation_Config();

			$this->validators = (object) $validators;
		}

	}

	// processing actions.
	/**
	 * Config plugin
	 */
	public function validate_config() {

		$data = $_REQUEST;

		if ( check_admin_referer( $this->plugin_name . '_admin_config', $this->plugin_name . '_admin_config_nonce' ) ) {

			d( 'nonce passed', $data );

			$this->get_validators();
			$validator = &$this->validator->config;

			$validator->setup( $data );
			return $validator->run();
		}
		return false;
	}

	/**
	 * Create a record
	 */
	public function create() {

		$data = $_REQUEST;

		if ( check_admin_referer( $this->plugin_name . '_admin_create', $this->plugin_name . '_admin_create_nonce' ) ) {

			$this->get_validators();
			$validator = &$this->validator->signups;
			$validator->setup( $data );
			$valid = $validator->run();

			// Overwrite alert.
			$data = $validator->get_data();

			if ( ! $valid ) {
				$status = 'error';
				// i only give a crap about the first error.
				$message = $validator->get_messages()[0];
			} elseif ( ! $this->models->signups->insert( $data ) ) {
				$status = 'error';
				$message = 'Something went wrong.';
			} else {
				$status = 'success';
				$message = 'Signup added.';
			}
		} else {
			$status = 'error';
			$message = 'Nonce failure.';
		}

		wp_redirect( admin_url( 'admin.php?page=' . $this->plugin_name . '&current=' . urlencode( $this->get_current() ) . '&pvstatus=' . urlencode( $status ) . '&pvmessage=' . urlencode( $message ) ) );

	}

	/**
	 * List records
	 */
	public function list() {
		return $this->models->signups->get_paged();
	}

	/**
	 * Read a record
	 */
	public function read() {

		if ( isset( $_REQUEST['item'] ) &&
			$item = (int) $_REQUEST['item'] ) {
			return $this->models->signups->get_row( $item );
		}

	}

	/**
	 * Update a record
	 */
	public function update() {

		if ( isset( $_REQUEST['item'] ) ) {

			$data = $_REQUEST;
			$item = wp_unslash( (int) $data['item'] );

			if ( check_admin_referer( $this->plugin_name . '_admin_update_' . $item, $this->plugin_name . '_admin_update_nonce' ) ) {

				$this->get_validators();
				$validator = &$this->validator['signups'];
				$validator->setup( $data );
				$valid = $validator->run();

				// Overwrite alert.
				$data = $validator->get_data();

				if ( ! $valid ) {
					$status = 'error';
					// i only give a crap about the first error.
					$message = $validator->get_messages()[0];
				} elseif ( ! $this->models->signups->update(
					$data, array(
						'id' => $item,
					)
				) ) {
					$status = 'error';
					$message = 'Save failure.';
				} else {
					$status = 'success';
					$message = 'Changes saved.';
				}
			} else {
				$status = 'error';
				$message = 'Nonce failure.';
			}
		}

		wp_redirect( admin_url( 'admin.php?page=' . $this->plugin_name . '&current=' . urlencode( $this->get_current() ) . '&pvstatus=' . urlencode( $status ) . '&pvmessage=' . urlencode( $message ) ) );
	}

	/**
	 * Delete a record
	 */
	public function delete() {

		if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['_wpnonce'] ), $this->plugin_name . '_admin_delete' ) ) {

			if ( isset( $_REQUEST['item'] ) &&
				$item = (int) sanitize_key( $_REQUEST['item'] ) ) {
				if ( ! $this->models->signups->delete( $item ) ) {
					$status = 'error';
					$message = 'Something went wrong.';
				} else {
					$status = 'success';
					$message = 'Deleted.';
				}
			} else {
				$status = 'error';
				$message = 'No item specified for deletion.';
			}
		} else {

			$status = 'error';
			$message = 'bad request.';

		}

		wp_redirect( admin_url( 'admin.php?page=' . $this->plugin_name . '&current=' . urlencode( $this->get_current() ) . '&pvstatus=' . urlencode( $status ) . '&pvmessage=' . urlencode( $message ) ) );
	}

	/**
	 * Delete a record
	 */
	public function delete_all() {

		if ( isset( $_REQUEST['_wpnonce'] ) && wp_verify_nonce( sanitize_key( $_REQUEST['_wpnonce'] ), $this->plugin_name . '_admin_delete_all' ) ) {
			if ( ! $this->models->signups->delete_all() ) {
				$status = 'error';
				$message = 'Something went wrong.';
			} else {
				$status = 'success';
				$message = 'Deleted.';
			}
		} else {
			$status = 'error';
			$message = 'bad request.';
		}

		wp_redirect( admin_url( 'admin.php?page=' . $this->plugin_name . '&current=' . urlencode( $this->get_current() ) . '&pvstatus=' . urlencode( $status ) . '&pvmessage=' . urlencode( $message ) ) );
	}

	/**
	 * Gets the current page.
	 *
	 * @param      string $model  The model name.
	 *
	 * @return     int The current page.
	 */
	public function get_current( $model = 'signups' ) {
		$this->get_models();
		$pagination = $this->models->$model->get_pagination();

		return $pagination->current;
	}

	/**
	 * Write Configuration
	 */
	public function get_config() {
		return $this->config;
	}

	/**
	 * Show config form
	 */
	public function show_config_form() {
		include_once 'partials/pv-machine-inspector-signup-admin-config.php' ;
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @param mixed $links supposedly, links.
	 *
	 * @return  mixed merged links.
	 */
	public function add_action_links( $links ) {
		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __( 'Settings', $this->plugin_name ) . '</a>',
			),
			$links
		);
	}

	/**
	 *  Save the plugin options
	 *
	 * @since    1.0.0
	 */
	public function options_update() {
		register_setting( $this->plugin_name, $this->plugin_name, array( $this, 'validate_config' ) );
	}

}
