<?php

	/**
	 * PostmanComponent
	 *
	 * Component for accessing the `Postman` object through a controller.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @see http://book.cakephp.org/view/62/Components
	 * @see http://book.cakephp.org/view/497/Components-Helpers-and-Behaviors
	 */
	class PostmanComponent extends Object {

		/**
		 * Holds our `Postman` object we use for sending emails.
		 *
		 * @var Postman
		 * @access protected
		 */
		protected $_postman;

		/**
		 * Holds the controller instance we were initialized from.
		 *
		 * @var Controller
		 * @access protected
		 */
		protected $_controller;

		/**
		 * Holds the settings we were initialized with.
		 *
		 * @var array
		 * @access protected
		 */
		protected $_settings = array();

		/**
		 * Holds any initialized transports keyed off their
		 * name for easier reuse.
		 *
		 * @var array
		 * @access protected
		 */
		protected $_transports = array();

		/**
		 * Triggered before the controller's `beforeFilter` method but after the
		 * models have been constructed.
		 *
		 * @param Controller $controller
		 * @param array $settings
		 * @return null
		 * @access public
		 * @see http://book.cakephp.org/view/1617/Component-callbacks
		 */
		public function initialize(Controller $controller, $settings = array()) {

			// Go get our Postman object.
			App::import(
				'Libs',
				'Postman.Postman',
				array(
					'file' => 'Postman.php'
				)
			);

			// Setup some default settings.
			$this->_getPostman();
			$this->_settings = $settings;
			$transport = null;

			// Loop over and create our transports.
			foreach ($this->_settings as $transport=>$settings) {
				if (is_numeric($transport) and is_string($settings)) {
					$transport = $settings;
					$settings  = array();
				}
				$this->addTransport($transport, $settings);
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
			if (!empty($from)) 		{ $email->setFrom($from); }
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
		public function send(\Postman\Library\Email $email, $transport = null) {
			if (!is_null($transport)) {
				$this->setTransport($transport);
			}

			// Tell the object to send it off.
			return $this->_getPostman()->send($email);
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
			$this->addTransport($transport);
			$this->_getPostman()->setTransport(
				$this->getTransport($transport)
			);
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
		public function getTransport($transport) {
			if (!array_key_exists($transport, $this->_transports)) {
				$transport = '\Postman\Transports\\' . $transport;
			}
			if (array_key_exists($transport, $this->_transports)) {
				return $this->_transports[$transport];
			}
			return null;
		}

		/**
		 * Convenience method for retrieving the `Postman` object.
		 *
		 * @return Postman
		 * @access protected
		 */
		protected function _getPostman() {
			if (!is_object($this->_postman)) {
				$this->_postman = new Postman;
			}
			return $this->_postman;
		}

	}
