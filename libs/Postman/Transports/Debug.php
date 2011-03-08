<?php

	namespace Postman\Transports;

	/**
	 * Debug
	 *
	 * A mail transport for debugging messages. Any message sent to us will be
	 * written away to the application's logs or wherever our `folder` setting
	 * tells us to.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Debug extends \Postman\Library\Transport {

		/**
		 * Default settings. Any configuration passed to `setSettings` will
		 * be merged into this member variable.
		 *
		 * @var array
		 * @access protected
		 */
		protected $_settings = array(
			'folder' => TMP
		);

		/**
		 * Sends the given `\Postman\Library\Email` object. Returns boolean to
		 * indicate success of the operation.
		 *
		 * @param \Postman\Library\Email $email
		 * @return boolean
		 * @access public
		 */
		public function send(\Postman\Library\Email $email) {
			return file_put_contents(
				tempnam($this->_getSetting('folder'), 'email-'),
				print_r($email, true)
			) !== false;
		}

		/**
		 * Initialization method, called after construction.
		 *
		 * @return null
		 * @access protected
		 */
		protected function _initialize() {

			// Ensure that the folder to write to exists
			if (!file_exists($this->_getSetting('folder'))) {
				throw new \InvalidArgumentException(
					'Debug::$_settings[\'folder\'] must be a valid, existing folder'
				);
			}

			// Ensure that the folder to write to is writable
			if (!is_writable($this->_getSetting('folder'))) {
				throw new \InvalidArgumentException(
					'Debug::$_settings[\'folder\'] must be writable'
				);
			}

		}

	}
