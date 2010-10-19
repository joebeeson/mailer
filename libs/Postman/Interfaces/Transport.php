<?php

	namespace Postman\Interfaces;

	/**
	 * Transport
	 *
	 * Defines the required methods for a `Transport` object which the rest of
	 * the system requires to ensure operations.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	interface Transport {

		/**
		 * Sends the given `\Postman\Library\Email` object. Returns boolean to
		 * indicate success of the operation.
		 *
		 * @param \Postman\Library\Email $email
		 * @return boolean
		 * @access public
		 */
		public function send(\Postman\Library\Email $email);

		/**
		 * Tells the object to utilize the provided `$settings` for any options
		 * that are to be user configurable.
		 *
		 * @param array $settings
		 * @return null
		 * @access public
		 */
		public function setSettings($settings = array());

	}
