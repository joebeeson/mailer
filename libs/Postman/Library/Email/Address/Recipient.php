<?php

	namespace Postman\Library\Email\Address;

	/**
	 * Recipient
	 *
	 * Represents an email address that is to become a recipient.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Recipient extends \Postman\Library\Email\Address {

		/**
		 * Holds our recipient "type" -- defaults to 'to'
		 *
		 * @var string
		 * @access protected
		 */
		protected $_type = 'to';

		/**
		 * Construction method
		 *
		 * @param string $address
		 * @param string $type
		 * @return null
		 * @access public
		 */
		public function __construct($address = '', $type = 'to') {
			if (!empty($type)) {
				if (!$this->_isValidRecipientType($type)) {
					throw new \InvalidArgumentException(
						"'$type' is an invalid recipient mailing type"
					);
				} else {
					$this->_type = $type;
					parent::__construct($address);
				}
			}
		}

		/**
		 * Sets the parameter value as our given new `$_type` member variable if
		 * it's valid.
		 *
		 * @param string $type
		 * @return null
		 * @access public
		 */
		public function setType($type) {
			if (!$this->_isValidRecipientType($type)) {
				throw new \InvalidArgumentException(
					"'$type' is an invalid recipient mailing type"
				);
			} else {
				$this->_type = $type;
			}
		}

		/**
		 * Convenience method for checking if the given parameter is a valid
		 * recipient "type"
		 *
		 * @param string $type
		 * @return boolean
		 * @access protected
		 */
		protected function _isValidRecipientType($type) {
			return in_array(
				$type,
				array(
					'to',
					'bcc',
					'cc'
				)
			);
		}

	}
