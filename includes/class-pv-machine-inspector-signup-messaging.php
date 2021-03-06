<?php
/**
 * Specific DB model
 *
 * @link  philadelphiavotes.com
 * @since 1.0.0
 *
 * @package    Pv_Machine_Inspector_Signup
 * @subpackage Pv_Machine_Inspector_Signup/Db
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

// include messaging.
require_once WP_PLUGIN_DIR . '/pv-core/includes/class-pv-core-messaging.php';

if ( class_exists( 'Pv_Core_Messaging' ) && ! class_exists( 'Pv_Machine_Inspector_Signup_Messaging' ) ) {
	/**
	 * Local messaging instance
	 */
	class Pv_Machine_Inspector_Signup_Messaging extends Pv_Core_Messaging {


	}
}
