<?php

	//  Define our namespace.
	namespace Postman\Transports;

	/**
	 * Queue
	 *
	 * Accepts emails and stores them in a database for future
	 * mailing by serializing the `Email` object.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Queue extends \Postman\Library\Transport {

		/**
		 * Holds our model instance.
		 *
		 * @var Model
		 * @access protected
		 */
		protected $_model;

		/**
		 * Default settings. Any configuration passed to `setSettings` will
		 * be merged into this member variable.
		 *
		 * @var array
		 * @access protected
		 */
		protected $_settings = array(
			'model'  => null,
			'column' => 'email'
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
			return (boolean) $this->_getSetting('model')->save(
				array(
					$this->_getSetting('column') => serialize($email)
				)
			);
		}

		/**
		 * Initialization method, called after construction.
		 *
		 * @return void
		 * @access protected
		 */
		protected function _initialize() {
			if (is_null($this->_getSetting('model'))) {

				// They didn't set a `model` key. Fail.
				throw new \InvalidArgumentException(
					'Queue::$_settings[\'model\'] must be present and not empty.'
				);
			} else {

				// Setup our model and confirm it's legit.
				$this->_settings['model'] = \ClassRegistry::init($this->_getSetting('model'));
				if (!array_key_exists($this->_getSetting('column'), $this->_getSetting('model')->schema())) {
					throw new \RuntimeException(
						'Queue::$_settings[\'column\'] is incorrect for the model.'
					);
				}
			}
		}

	}