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
		 * name for easier reuse.
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
		 * @param string $from
		 * @param string $subject
		 * @return \Postman\Library\Email
		 * @access public
		 */
		public function create($from = '', $subject = '') {
			$email = new \Postman\Library\Email();

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
			if (is_object($email) and is_a($email, 'Postman\Library\Email')) {
				return $this->_transport->send($email);
			} else {
				throw new InvalidArgumentException(
					'Postman::send() expects a valid `\Postman\Library\Email` object'
				);
			}
		}

		/**
		 * Takes the request for setting the transport and passes it along to
		 * out current `Postman` object.
		 *
		 * @param mixed $transport
		 * @param array $settings
		 * @return null
		 * @access public
		 */
		public function setTransport($transport) {
			$this->_transport = $this->getTransport($transport);
		}

		/**
		 * Adds the given transport to our `$_transports` member variable.
		 *
		 * @param mixed $transport
		 * @param array $settings
		 * @return void
		 * @access public
		 */
		public function addTransport($transport, $settings = array()) {
			if (is_object($transport)) {
				$this->_transports[get_class($transport)] = $transport;
			} else {
				$class = '\Postman\Transports\\' . $transport;
				if (!isset($this->_transports[$class]) or !empty($settings)) {
					$this->_transports[$class] = new $class($settings);
				}
			}

			// Assume they want this as the primary
			$this->setTransport($transport);
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

	}