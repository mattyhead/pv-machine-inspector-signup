<?php
/**
 * Specific DB model
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Machine_Inspector_Signup
 * @subpackage Pv_Machine_Inspector_Signup/Db
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

require_once plugin_dir_path( dirname( __FILE__ ) ) . 'helpers/pv-model.php';

if ( class_exists( 'Pv_Model' )) {
	class Pv_Model_Signups extends Pv_Model {
		public function __construct( ) {
			parent::__construct();
			$this->tablename = 'pv_mi_signups';
		}

		public function update( ) {

			parent::update( );
		}
	}	
}