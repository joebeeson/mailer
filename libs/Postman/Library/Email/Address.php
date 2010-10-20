<?php

	namespace Postman\Library\Email;

	/**
	 * Address
	 *
	 * Represents an email address.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Address {

		/**
		 * Holds our address.
		 *
		 * @var string
		 * @access protected
		 */
		protected $_address = 'Noone <noone@example.com>';

		/**
		 * Construction method.
		 *
		 * @param string $address
		 * @return null
		 * @access public
		 */
		public function __construct($address = '') {
			if (!empty($address)) {
				$this->setAddress($address);
			}
		}

		/**
		 * Sets the given parameter as our `$_address` member variable.
		 *
		 * @param string $address
		 * @return null
		 * @access public
		 */
		public function setAddress($address) {
			$this->_address = $address;
		}

	}
