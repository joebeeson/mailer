<?php

	namespace Postman\Library;

	/**
	 * Transport
	 *
	 * Base abstract class for all `Transport` objects. These classes handle the
	 * actual communication with the mechanism that handles the sending of an
	 * email.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @implements \Postman\Interfaces\Transport
	 * @abstract
	 */
	abstract class Transport implements \Postman\Interfaces\Transport {

		/**
		 * Settings
		 *
		 * @var array
		 * @access protected
		 */
		protected $_settings = array();

		/**
		 * Sets the provided `$settings` parameter to our `$_settings` member
		 * variable.
		 *
		 * If the parameter isn't an array we will raise an E_USER_NOTICE to
		 * alert the user to the issue.
		 *
		 * @param array $settings
		 * @return null
		 * @access public
		 * @final
		 */
		final public function setSettings($settings) {
			if (!is_array($settings)) {
				trigger_error(
					get_class($this) . '::setSettings() expects an array'
				);
			} else {
				$this->_settings = array_merge(
					$this->_settings,
					$settings
				);
			}
		}

	}
