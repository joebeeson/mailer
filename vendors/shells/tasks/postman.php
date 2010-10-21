<?php

	/**
	 * PostmanTask
	 *
	 * Task for accessing the `Postman` object through a shell.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @see http://book.cakephp.org/view/112/Tasks
	 */
	class PostmanTask extends Shell {

		/**
		 * Holds our `Postman` object we use for sending emails.
		 *
		 * @var Postman
		 * @access protected
		 */
		protected $_postman;

		/**
		 * Initialization
		 *
		 * @return null
		 * @access public
		 */
		public function initialize() {
			App::import(
				'Libs',
				'Postman.Postman',
				array(
					'file' => 'Postman.php'
				)
			);
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
			$this->_getPostman()->send($email);
		}

		/**
		 * Takes the request for setting the transport and passes it along to
		 * out current `Postman` object.
		 *
		 * @param string $transport
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
