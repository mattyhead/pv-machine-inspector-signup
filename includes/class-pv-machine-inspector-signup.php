<?php
/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link  philadelphiavotes.com
 * @since 1.0.0
 *
 * @package    Pv_Machine_Inspector_Signup
 * @subpackage Pv_Machine_Inspector_Signup/includes
 */

if ( ! class_exists( 'Pv_Machine_Inspector_Signup' ) ) {
	/**
	 * The core plugin class.
	 *
	 * This is used to define internationalization, admin-specific hooks, and
	 * public-facing site hooks.
	 *
	 * Also maintains the unique identifier of this plugin as well as the current
	 * version of the plugin.
	 *
	 * @since      1.0.0
	 * @package    Pv_Machine_Inspector_Signup
	 * @subpackage Pv_Machine_Inspector_Signup/includes
	 * @author     matthew murphy <matthew.e.murphy@phila.gov>
	 */
	class Pv_Machine_Inspector_Signup {


		/**
		 * Loader
		 *
		 * @var mixed $loader
		 */
		protected $loader;

		/**
		 * Plugin name
		 *
		 * @var string $plugin_name
		 */
		protected $plugin_name;

		/**
		 * Version
		 *
		 * @var string $version
		 */
		protected $version;

		/**
		 * Define the core functionality of the plugin.
		 *
		 * Set the plugin name and the plugin version that can be used throughout the plugin.
		 * Load the dependencies, define the locale, and set the hooks for the admin area and
		 * the public-facing side of the site.
		 *
		 * @since 1.0.0
		 */
		public function __construct() {

			$this->plugin_name = 'pv-machine-inspector-signup';
			$this->version = '1.0.0';
			$this->load_dependencies();
			$this->set_locale();
			$this->define_admin_hooks();
			$this->define_public_hooks();

		}

		/**
		 * Load the required dependencies for this plugin.
		 *
		 * Include the following files that make up the plugin:
		 *
		 * - Pv_Machine_Inspector_Signup_Loader. Orchestrates the hooks of the plugin.
		 * - Pv_Machine_Inspector_Signup_i18n. Defines internationalization functionality.
		 * - Pv_Machine_Inspector_Signup_Admin. Defines all hooks for the admin area.
		 * - Pv_Machine_Inspector_Signup_Public. Defines all hooks for the public side of the site.
		 *
		 * Create an instance of the loader which will be used to register the hooks
		 * with WordPress.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function load_dependencies() {

			/**
			 * The class responsible for orchestrating the actions and filters of the
			 * core plugin.
			 */
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pv-machine-inspector-signup-loader.php';

			/**
			 * The class responsible for defining internationalization functionality
			 * of the plugin.
			 */
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-pv-machine-inspector-signup-i18n.php';

			/**
			 * The class responsible for defining all actions that occur in the admin area.
			 */
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-pv-machine-inspector-signup-admin.php';

			/**
			 * The class responsible for defining all actions that occur in the public-facing
			 * side of the site.
			 */
			include_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-pv-machine-inspector-signup-public.php';

			$this->loader = new Pv_Machine_Inspector_Signup_Loader();

		}

		/**
		 * Define the locale for this plugin for internationalization.
		 *
		 * Uses the Pv_Machine_Inspector_Signup_i18n class in order to set the domain and to register the hook
		 * with WordPress.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function set_locale() {

			$plugin_i18n = new Pv_Machine_Inspector_Signup_i18n();

			$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

		}

		/**
		 * Register all of the hooks related to the admin area functionality
		 * of the plugin.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function define_admin_hooks() {

			$plugin_admin = new Pv_Machine_Inspector_Signup_Admin( $this->get_plugin_name(), $this->get_version() );
			$plugin_basename = plugin_basename( plugin_dir_path( __DIR__ ) . $this->plugin_name . '.php' );

			// bind in our parent menu item.
			$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_child_menu' );

			// options processing.
			$this->loader->add_action( 'admin_init', $plugin_admin, 'options_update' );
			$this->loader->add_filter( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

			// script and style loads.
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
			$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

			// form processing.
			register_setting( $this->plugin_name, $this->plugin_name, array( $plugin_admin, 'validate_config' ) );
			$this->loader->add_action( 'admin_post_pvmi_admin_create', $plugin_admin, 'create' );
			$this->loader->add_action( 'admin_post_pvmi_admin_delete', $plugin_admin, 'delete' );
			$this->loader->add_action( 'admin_post_pvmi_admin_delete_all', $plugin_admin, 'delete_all' );
			$this->loader->add_action( 'admin_post_pvmi_admin_update', $plugin_admin, 'update' );

		}

		/**
		 * Register all of the hooks related to the public-facing functionality
		 * of the plugin.
		 *
		 * @since  1.0.0
		 * @access private
		 */
		private function define_public_hooks() {

			$plugin_public = new Pv_Machine_Inspector_Signup_Public( $this->get_plugin_name(), $this->get_version() );

			// script and style loads.
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
			$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

			// form processing.
			$this->loader->add_action( 'public_create', $plugin_public, 'create' );

		}

		/**
		 * Run the loader to execute all of the hooks with WordPress.
		 *
		 * @since 1.0.0
		 */
		public function run() {
			$this->loader->run();
		}

		/**
		 * The name of the plugin used to uniquely identify it within the context of
		 * WordPress and to define internationalization functionality.
		 *
		 * @since  1.0.0
		 * @return string    The name of the plugin.
		 */
		public function get_plugin_name() {
			return $this->plugin_name;
		}

		/**
		 * The reference to the class that orchestrates the hooks with the plugin.
		 *
		 * @since  1.0.0
		 * @return Pv_Machine_Inspector_Signup_Loader    Orchestrates the hooks of the plugin.
		 */
		public function get_loader() {
			return $this->loader;
		}

		/**
		 * Retrieve the version number of the plugin.
		 *
		 * @since  1.0.0
		 * @return string    The version number of the plugin.
		 */
		public function get_version() {
			return $this->version;
		}

	}
}
