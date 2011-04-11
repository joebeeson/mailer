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
		 * Catches any requests for non-existant or non-visible methods.
		 *
		 * @param string $method
		 * @param array $arguments
		 * @return mixed
		 * @access public
		 * @see http://php.net/manual/en/language.oop5.magic.php
		 */
		public function __call($method, $arguments) {
			if (substr($method, 0, 3) == 'get') {
				$variable = '_' . lcfirst(substr($method, 3));
				if (isset($this->$variable)) {
					return $this->$variable;
				}
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
