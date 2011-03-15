<?php

	// Define our namespace.
	namespace Postman\Library;

	/**
	 * Transport
	 *
	 * Base abstract class for all `Transport` objects. These classes handle the
	 * actual communication with the mechanism that handles the sending of an
	 * email.
	 *
	 * While it's only necessary that transport objects implement the interface,
	 * we provide a useful starting point for most transports so its recommended
	 * to extend from this class.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @implements \Postman\Interfaces\Transport
	 * @abstract
	 */
	abstract class Transport implements \Postman\Interfaces\Transport {

		/**
		 * Default settings. Any configuration passed to `setSettings` will
		 * be merged into this member variable.
		 *
		 * @var array
		 * @access protected
		 */
		protected $_settings = array();

		/**
		 * Construction method. Allows for an optional `$settings` parameter to
		 * be passed off to `setSettings`
		 *
		 * @param array $settings
		 * @return null
		 * @access public
		 * @final
		 */
		final public function __construct($settings = array()) {
			$this->setSettings($settings);
			$this->_initialize();
		}

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
		final public function setSettings($settings = array()) {
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

		/**
		 * Initialization method called after construction to give objects a
		 * chance to run their own startup operations.
		 *
		 * @return null
		 * @access protected
		 */
		protected function _initialize() {
			/**
			 * Overridden in child classes.
			 */
		}

		/**
		 * Convenience method for retrieving a specific setting from the class'
		 * `$_settings` member variable.
		 *
		 * @param string $name
		 * @return mixed
		 * @access protected
		 * @final
		 */
		final protected function _getSetting($name = '') {
			return \Set::extract(
				$this->_settings,
				$name
			);
		}

	}
