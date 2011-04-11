<?php

	/**
	 * Postman
	 *
	 * Primary object for interacting with the `Postman` library. Handles
	 * the instantiation of `Transport` objects and sending mail.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Postman {

		/**
		 * Holds any initialized transports keyed off their
		 * class name for easier reuse.
		 *
		 * @var array
		 * @access protected
		 */
		protected $_transports = array();

		/**
		 * Holds our current `Transport` object
		 *
		 * @var \Postman\Library\Transport
		 * @access protected
		 */
		protected $_transport;

		/**
		 * Triggered by our extended children.
		 *
		 * @param array $settings
		 * @return void
		 * @access public
		 */
		protected function _initialize($settings = array()) {
			
			// Bring in our autoloader.
			$transport = null;
			App::import(
				'Libs',
				'Mailer.Postman/bootstrap',
				array(
					'file' => 'bootstrap.php'
				)
			);

			// Loop over and create our transports.
			foreach ($settings as $transport=>$setting) {
				if (is_numeric($transport) and is_string($setting)) {
					$transport = $setting;
					$setting  = array();
				}
				$this->addTransport($transport, $setting);
			}

			// Be sure to attempt and set a transport.
			$this->setTransport($transport);
		}

		/**
		 * Convenience method for creating a new `Email` object.
		 *
		 * If the optional third parameter is passed we will use that class
		 * instead of our default `Email` object.
		 *
		 * @param string $from
		 * @param string $subject
		 * @param string $object
		 * @return mixed
		 * @access public
		 */
		public function create($from = '', $subject = '', $object = '\Postman\Library\Email') {
			$email = new $object;

			// Set the `$from` and `$subject` if available.
			if (!empty($from)) 	{ $email->setFrom($from); }
			if (!empty($subject)) 	{ $email->setSubject($subject); }

			// Return the object
			return $email;
		}

		/**
		 * Takes the request to send the `$email` and passes it off to the
		 * `Postman` object. Returns boolean to indicate success.
		 *
		 * @param \Postman\Library\Email $email
		 * @param mixed $transport
		 * @return boolean
		 * @access public
		 */
		public function send($email, $transport = null) {
			if (!is_null($transport)) {
				$this->setTransport($transport);
			}
			if ($this->_isValidEmailObject($email)) {
				return $this->_transport->send($email);
			} else {
				throw new InvalidArgumentException(
					'Postman::send() expects a valid `\Postman\Library\Email` object'
				);
			}
		}

		/**
		 * Sets the passed `$transport` as our current, primary transport.
		 *
		 * @param mixed $transport
		 * @param array $settings
		 * @return boolean
		 * @access public
		 */
		public function setTransport($transport) {
			if (is_object($transport)) {
				if (!$this->hasTransport($transport)) {
					$this->addTransport($transport);
				}
				$this->_transport = $transport;
				return true;
			} elseif (is_string($transport)) {
				if ($this->hasTransport($transport)) {
					$this->_transport = $this->getTransport($transport);
					return true;
				}
			}
			return false;
		}

		/**
		 * Checks if `$transport` is in our `$_transports` variable.
		 *
		 * @param mixed $transport
		 * @return boolean
		 * @access public
		 */
		public function hasTransport($transport) {
			if (is_string($transport)) {
				if (!array_key_exists($transport, $this->_transports)) {
					$transport = '\Postman\Transports\\' . $transport;
				}
				return array_key_exists($transport, $this->_transports);
			} elseif (is_object($transport)) {
				return in_array($transport, $this->_transports);
			}
		}

		/**
		 * Adds the given transport to our `$_transports` member variable. We
		 * can accept a `Transport` object or a string that names an object
		 * to instantiate.
		 *
		 * @param mixed $transport
		 * @param array $settings
		 * @return void
		 * @access public
		 */
		public function addTransport($transport, $settings = array()) {
			if (is_object($transport)) {
				if ($this->_isValidTransportObject($transport)) {
					$key = get_class($transport);
					$value = $transport;
				} else {
					throw new \InvalidArgumentException(
						'Postman::addTransport expects a valid `\Postman\Interfaces\Transport` object.'
					);
				}
			} elseif (is_string($transport)) {
				if (!class_exists($transport)) {
					$key = '\Postman\Transports\\' . $transport;
				} else {
					$key = $transport;
				}
				$value = new $key($settings);
			}
			$this->_transports[$key] = $value;
			return $value;
		}

		/**
		 * Returns the requested transport, by string.
		 *
		 * @param string $transport
		 * @return mixed
		 * @access public
		 */
		public function getTransport($transport = null) {

			// Stop if it's null.
			if (is_null($transport)) {
				return $this->_transport;
			}

			// Sanity checks
			if (!is_string($transport)) {
				throw new \InvalidArgumentException(
					'Postman::getTransport expects a string'
				);
			}

			// Try to automatically append the full path name.
			if (!array_key_exists($transport, $this->_transports)) {
				$transport = '\Postman\Transports\\' . $transport;
			}

			// Check if it exists. If so, return it.
			if (array_key_exists($transport, $this->_transports)) {
				return $this->_transports[$transport];
			}
			return null;
		}

		/**
		 * Checks if the passed `$object` is a valid `Transport`
		 * object and returns boolean to indicate.
		 *
		 * @param mixed $object
		 * @return bool
		 * @access protected
		 */
		protected function _isValidTransportObject($object) {
			if (is_object($object)) {
				return in_array(
					'\Postman\Interfaces\Transport',
					class_implements($object)
				);
			}
			return false;
		}

		/**
		 * Checks if the passed `$object` is a valid `Email`Transport
		 * object and returns boolean to indicate.
		 *
		 * @param mixed $object
		 * @return bool
		 * @access protected
		 */
		protected function _isValidEmailObject($object) {
			if (is_object($object)) {
				return is_a(
					$object,
					'Postman\Library\Email'
				);
			}
			return false;
		}

	}