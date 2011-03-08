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
			App::import(
				'Libs',
				'Postman.Postman',
				array(
					'file' => 'Postman.php'
				)
			);
			$this->_settings = $settings;
			if (count($this->_settings) > 0) {
				$transport = array_shift(array_keys($this->_settings));
				if (is_array($this->_settings[$transport])) {
					$settings = $this->_settings[$transport];
				} else {
					$settings = array();
				}
				$this->setTransport($transport, $settings);
			}
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
		 * @return boolean
		 * @access public
		 */
		public function send(\Postman\Library\Email $email) {
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
		public function setTransport($transport, $settings = array()) {
			$this->_getPostman()->setTransport($transport, $settings);
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
