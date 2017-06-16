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
if ( ! class_exists('Pv_Validate_Signups') && class_exists( 'Pv_Validation' ) ) {
	class Pv_Validate_Signups extends Pv_Validation {
		private $processing = array(
					'id' =>'',
					'division' =>array(
						'required'=>false, 
						'sanitize'=>array('sanitize_text_field'), 
						'validate'=>array('is_extant', 'is_numeric')),
					'first_name' =>array(
						'required'=>true,  
						'sanitize'=>array('sanitize_text_field'), 
						'validate'=>array('is_extant', 'is_alphabetic')),
					'middle_name' =>array(
						'required'=>false, 
						'sanitize'=>array('sanitize_text_field'), 
						'validate'=>array('is_extant', 'is_alphabetic')),
					'last_name' =>array(
						'required'=>true,  
						'sanitize'=>array('sanitize_text_field'), 
						'validate'=>array('is_extant', 'is_alphabetic')),
					'address1' =>array(
						'required'=>true,  
						'sanitize'=>array('sanitize_text_field'), 
						'validate'=>array('is_extant')),
					'address2' =>array(
						'required'=>false, 
						'sanitize'=>array('sanitize_text_field'), 
						'validate'=>array('is_extant')),
					'city' =>array(
						'required'=>true,  
						'sanitize'=>array('sanitize_text_field'), 
						'validate'=>array('is_extant', 'is_alphabetic')),
					'region' =>array(
						'required'=>true,  
						'sanitize'=>array('sanitize_text_field'), 
						'validate'=>array('is_extant', 'is_alphabetic', 'is_us_state')),
					'postcode' =>array(
						'required'=>true,  
						'sanitize'=>array('sanitize_text_field'), 
						'validate'=>array('is_extant', 'is_us_zip_code')),
					'email' =>array(
						'required'=>false, 
						'sanitize'=>array('sanitize_email'), 
						'validate'=>array('is_extant','is_email')),
					'phone' =>array(
						'required'=>false, 
						'sanitize'=>array('sanitize_text_field', 'sanitize_phone'),
						'validate'=>array('is_extant','is_phone')),
					'published',
					'created',
					'updated',
				);
		private $data;
		private $messages;
		private $rules;
		private $scrubable;

		/**
		 * Gets the value of messages.
		 *
		 * @return mixed
		 */
		public function getMessages() {
			return $this->messages;
		}

		/**
		 * Gets the value of data.
		 *
		 * @return mixed
		 */
		public function getData() {
			return $this->data;
		}

		/**
		 * Gets the value of rules.
		 *
		 * @return mixed
		 */
		public function getRules() {
			return $this->rules;
		}

		/**
		 * Store a message.
		 *
		 * @return mixed
		 */
		public function setMessage($value) {
			if ( ! count( $this->messages ) ) {
				$this->messages = array($value);
				return;
			}

			array_push( $this->messages, $value );
		}

		/**
		 * Set the data.
		 *
		 * @return mixed
		 */
		public function setData($data) {
			$this->data = $data;
		}

		/**
		 * Set the rules.
		 *
		 * @return mixed
		 */
		public function setRules($rules) {
			$this->rules = $rules;
		}

		/**
		 * Process data with rules, log to messages
		 *
		 * @return     bool  success of the validation operation overall
		 */
		public function run() {
			$valid = true;
			$data = $this->scrubable ? $this->scrub( $this->data ) : &$this->data;
			$rules = &$this->rules;

			// whitespace scrub for all
			$data = $this->scrub( $data );

			// loop through fields
			foreach ( $data as $field=>&$value ) {
				// is this required? 
				
				// apply rules to each

			}
			 
			return $valid;
		}

		/**
		 * Clean properties
		 */
		public function reset() {
			$this->messages = null;
			$this->data = null;
			$this->rules = rules;
		}

		/**
		 * shim for PHP ctype_alpha()
		 *
		 * @param      string   $value  a possible alphabetic value
		 *
		 * @return     boolean  True if alphabetic, False otherwise.
		 */
		public function is_alphabetic( $value ) {
			return ctype_alpha( $value );
		}

		/**
		 * negating shim for PHP empty()
		 *
		 * @param      string   $value  a possible non-empty value
		 *
		 * @return     boolean  True if extant, False otherwise.
		 */
		public function is_extant( $value ) {
			return ! empty( $value );
		}

		/**
		 * shim for PHP is_numeric().
		 *
		 * @param      string   $value  a possible numeric value
		 *
		 * @return     boolean  True if numeric, False otherwise.
		 */
		public function is_numeric( $value ) {
			return is_numeric( $value );
		}

		/**
		 * Determines if phone.
		 *
		 * @param      string   $value  a possible phone
		 *
		 * @return     boolean  True if phone, False otherwise.
		 */
		public function is_phone( $value ) {
			// todo
			return true;
		}

		/**
		 * Determines if us state.
		 *
		 * @param      string   $value  a possible US State
		 *
		 * @return     boolean  True if us state, False otherwise.
		 */
		public function is_us_state($value) {
			$states = array(
				'Alabama',
				'Alaska',
				'American Samoa',
				'Arizona',
				'Arkansas',
				'California',
				'Colorado',
				'Connecticut',
				'Delaware',
				'District of Columbia',
				'Federated States of Micronesia',
				'Florida',
				'Georgia',
				'Guam',
				'Hawaii',
				'Idaho',
				'Illinois',
				'Indiana',
				'Iowa',
				'Kansas',
				'Kentucky',
				'Louisiana',
				'Maine',
				'Marshall Islands',
				'Maryland',
				'Massachusetts',
				'Michigan',
				'Minnesota',
				'Mississippi',
				'Missouri',
				'Montana',
				'Nebraska',
				'Nevada',
				'New Hampshire',
				'New Jersey',
				'New Mexico',
				'New York',
				'North Carolina',
				'North Dakota',
				'Northern Mariana Islands',
				'Ohio',
				'Oklahoma',
				'Oregon',
				'Palau',
				'Pennsylvania',
				'Puerto Rico',
				'Rhode Island',
				'South Carolina',
				'South Dakota',
				'Tennessee',
				'Texas',
				'Utah',
				'Vermont',
				'Virgin Islands',
				'Virginia',
				'Washington',
				'West Virginia',
				'Wisconsin',
				'Wyoming',
				'AL',
				'AK',
				'AS',
				'AZ',
				'AR',
				'CA',
				'CO',
				'CT',
				'DE',
				'DC',
				'FM',
				'FL',
				'GA',
				'GU',
				'HI',
				'ID',
				'IL',
				'IN',
				'IA',
				'KS',
				'KY',
				'LA',
				'ME',
				'MH',
				'MD',
				'MA',
				'MI',
				'MN',
				'MS',
				'MO',
				'MT',
				'NE',
				'NV',
				'NH',
				'NJ',
				'NM',
				'NY',
				'NC',
				'ND',
				'MP',
				'OH',
				'OK',
				'OR',
				'PW',
				'PA',
				'PR',
				'RI',
				'SC',
				'SD',
				'TN',
				'TX',
				'UT',
				'VT',
				'VI',
				'VA',
				'WA',
				'WV',
				'WI',
				'WY',
			);

			return in_array($value, $states);
		}

		/**
		 * Determines if us zip code.
		 *
		 * @param      string   $value  a possible zip code
		 *
		 * @return     boolean  True if us zip code, False otherwise.
		 */
		public function is_us_zip_code($value) {
			if (strlen(trim($value)) > 10) {
				return false;
			}
		 
			if (!preg_match('/^\d{5}(\-?\d{4})?$/', $value)) {
				return false;
			}
		 
			return true;
		}

		/**
		 * Scrub whitespace (trim() plus no multiple \t|\n|\s)
		 *
		 * @param      mixed  $data   all the form data
		 *
		 * @return     mixed  a less whitespacey $data array
		 */
		public function scrub( &$data ) {
			array_walk( $data, 
				function ( &$value ) {
					$value = trim( $value );
					$value = preg_replace( '!\s+!', ' ', $value );
				}
			);

			return $data;
		}

		/**
		 * shim for WP sanitize_email()
		 *
		 * @param      string  $value  a possible email
		 *
		 * @return     string  yet another possible email
		 */
		public function sanitize_email( $value ) {
			return sanitize_email( $value );
		}

		/**
		 * sanitize 'phone'/'fax' inputs
		 *
		 * @param      string  $value  a possible phone number
		 *
		 * @return     string  yet another possible phone
		 */
		public function sanitize_phone( $value ) {
			// todo -- basically, strip to numbers only
			return $value;
		}

		/**
		 * shim for WP sanitize_text_field()
		 *
		 * @param      string  $value  text input value
		 *
		 * @return     string  a sanitized text input value
		 */
		public function sanitize_text_field( $value ) {
			return sanitize_text_field( $value );
		}

	}

}