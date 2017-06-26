<?php
/**
 * Shared validator class
 *
 * @link       philadelphiavotes.com
 * @since      1.0.0
 *
 * @package    Pv_Elections_Core
 * @subpackage Pv_Elections_Core/db
 * @author     matthew murphy <matthew.e.murphy@phila.gov>
 */

require_once WP_PLUGIN_DIR . '/pv-core/shared/class-pv-core-validation.php';

if ( class_exists( 'Pv_Core_Validation' ) && ! class_exists('Pv_Machine_Inspector_Signup_Validation') ) {
	class Pv_Machine_Inspector_Signup_Validation extends Pv_Core_Validation {

		private $data;
		private $messages;
		private $processing = array(
			'id' =>'',
			'division' =>array(
				'label'=>'Division',
				'required'=>false, 
				'sanitize'=>array('sanitize_text_field'), 
				'validate'=>array('is_numeric')),
			'first_name' =>array(
				'label'=>'First name',
				'required'=>true,  
				'sanitize'=>array('sanitize_text_field'), 
				'validate'=>array('is_alphabetic')),
			'middle_name' =>array(
				'label'=>'Middle name',
				'required'=>false, 
				'sanitize'=>array('sanitize_text_field'), 
				'validate'=>array('is_alphabetic')),
			'last_name' =>array(
				'label'=>'Last name',
				'required'=>true,  
				'sanitize'=>array('sanitize_text_field'), 
				'validate'=>array('is_alphabetic')),
			'address1' =>array(
				'label'=>'Address',
				'required'=>true,  
				'sanitize'=>array('sanitize_text_field'), 
				'validate'=>'',
			'address2' =>array(
				'label'=>'Address 2'
				'required'=>false, 
				'sanitize'=>array('sanitize_text_field'), 
				'validate'=>'',
			'city' =>array(
				'label'=>'City',
				'required'=>true,  
				'sanitize'=>array('sanitize_text_field'), 
				'validate'=>array('is_alphabetic')),
			'region' =>array(
				'label'=>'State',
				'required'=>true,  
				'sanitize'=>array('sanitize_text_field'), 
				'validate'=>array('is_us_state')),
			'postcode' =>array(
				'label'=>'Zip',
				'required'=>true,  
				'sanitize'=>array('sanitize_text_field'), 
				'validate'=>array('is_us_zip_code')),
			'email' =>array(
				'label'=>'Email',
				'required'=>false, 
				'sanitize'=>array('sanitize_email'), 
				'validate'=>array('is_email')),
			'phone' =>array(
				'label'=>'Phone',
				'required'=>false, 
				'sanitize'=>array('sanitize_text_field', 'sanitize_phone'),
				'validate'=>array('is_phone')),
			'published'=>'',
		);

		private $scrubbable = true;

}