<?php

	/**
	 * Postman
	 *
	 * Arbiter between the underlying structure of the `Postman` library and the
	 * developer. Takes care of sending multiple emails through a transport and
	 * provides a handful of methods for making the process easier.
	 *
	 * Usually one wouldn't make use of this class directly but instead via the
	 * `PostmanComponent` or `PostmanTask` objects.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Postman {

		/**
		 * Holds our `Transport` object
		 *
		 * @var \Postman\Library\Transport
		 * @access protected
		 */
		protected $_transport;

		/**
		 * Construction method.
		 *
		 * @return null
		 * @access public
		 * @final
		 */
		final public function __construct() {
			App::import(
				'Libs',
				'Mailer.Postman/bootstrap',
				array(
					'file' => 'bootstrap.php'
				)
			);
		}

		/**
		 * Fires the given `$email` off to the transport for mailing. Returns
		 * boolean to indicate success.
		 *
		 * @param mixed $email
		 * @return boolean
		 * @access public
		 */
		public function send($email) {
			if (!$this->__isValidEmailObject($email)) {
				throw new InvalidArgumentException(
					'Postman::send() expects a valid `\Postman\Library\Email` object'
				);
			} else {
				return $this->_getTransport()->send($email);
			}
		}

		/**
		 * Sets the provided `$transport` as our current transport.
		 *
		 * @param \Postman\Library\Transport $transport
		 * @return null
		 * @access public
		 */
		public function setTransport($transport) {
			if (!$this->__isValidTransportObject($transport)) {
				throw new RuntimeException(
					'Postman::setTransport() expects a string or valid `\Postman\Library\Transport` object'
				);
			}
			$this->_transport = $transport;
		}

		/**
		 * Returns the current `$_transport` member variable if it is a valid
		 * transport. In the event that it is not, we'll throw an exception.
		 *
		 * @return mixed
		 * @access protected
		 */
		protected function _getTransport() {
			if ($this->__isValidTransportObject($this->_transport)) {
				return $this->_transport;
			}
			throw new RuntimeException(
				'Postman::$_transport is not an object or valid `\Postman\Library\Transport` class'
			);
		}

		/**
		 * Checks that the given object is a valid `Transport` object.
		 *
		 * @param mixed $object
		 * @return boolean
		 * @access private
		 */
		private function __isValidTransportObject($object) {
			if (is_object($object)) {
				return in_array(
					'Postman\Interfaces\Transport',
					class_implements($object)
				);
			}
			return false;
		}

		/**
		 * Checks that the given object is a valid `Email` object.
		 *
		 * @param mixed $object
		 * @return boolean
		 * @access private
		 */
		private function __isValidEmailObject($object) {
			if (is_object($object)) {
				return is_a(
					$object,
					'Postman\Library\Email'
				);
			}
			return false;
		}

	}
