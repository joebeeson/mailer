<?php
	
	/**
	 * Mailer_Transport
	 * 
	 * Acts as a base class for all Transports
	 * 
	 * @package mailer
	 * @subpackage mailer.libs
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @abstract
	 */
	abstract class Mailer_Transport {
		
		/**
		 * Message
		 * 
		 * @var Mailer_Message
		 * @access protected
		 */
		protected $message;
		
		/**
		 * Settings
		 * 
		 * @var array
		 * @access protected
		 */
		protected $settings = array();
		
		/**
		 * Sets our $message member variable. This can be overridden in child
		 * classes to perform needed operations.
		 * 
		 * @param Mailer_Message $message
		 * @return boolean
		 * @access public
		 */
		public function setMessage(Mailer_Message $message) {
			$this->message = $message;
			return true;
		}
		
		/**
		 * Convenience method for performing setMessage() and send()
		 * 
		 * @param Mailer_Message $message
		 * @return boolean
		 * @access public
		 */
		public function sendMessage(Mailer_Message $message) {
			if ($this->setMessage($message)) {
				return $this->send();
			}
			return false;
		}
		
		/**
		 * Performs the message sending. Returns boolean for success
		 * 
		 * @return boolean
		 * @access public
		 */
		abstract public function send();
		
		/**
		 * Construction method
		 * 
		 * @return null
		 * @access public
		 */
		public function __construct() {
			if ($this->_configExists()) {
				// We have a configuration file, load it up.
				$settings = $this->_loadConfig($this->_loadConfig());
				if (!is_array($settings)) {
					// We did't get an array back
					throw new RuntimeException('Mailer_Transport expects configuration file to return an array()');
				} else {
					// Merge in our settings
					$this->settings = array_merge(
						$this->settings,
						$settings
					);
				}
			}
			// Start any required initialization
			$this->_initialize();
		}
		
		/**
		 * Initialization methods
		 * 
		 * @return null
		 * @access protected
		 */
		protected function _initialize() {
			/**
			 * Initialization operations. 
			 */
		}
		
		/**
		 * Convenience method for retrieving a configuration setting. Uses the
		 * CakePHP Set::classicExtract() dot notation for traversing an array.
		 * 
		 * @param string $path
		 * @return mixed
		 * @access protected
		 */
		protected function _getSetting($path = '') {
			return Set::classicExtract(
				$this->settings, $path
			);
		}
		
		/**
		 * Loads up our configuration file
		 * 
		 * @return null
		 * @access protected
		 */
		protected function _loadConfig() {
			return include(
				$this->_configDirectory() . $this->_configFile()
			);
		}
		
		/**
		 * Checks if we have a configuration file.
		 * 
		 * @return boolean
		 * @access protected
		 */
		protected function _configExists() {
			return file_exists(
				$this->_configDirectory() . $this->_configFile()
			);
		}
		
		/**
		 * Convenience method for returning the configuration directory
		 * 
		 * @return string
		 * @access protected
		 */
		protected function _configDirectory() {
			return realpath(
				dirname(__FILE__) . DS . '..' . DS . 'config' . DS . 'transports'
			) . DS;
		}
		
		/**
		 * Convenience method for returning the expected configuration filename
		 * 
		 * @return string
		 * @access protected
		 */
		protected function _configFile() {
			$class = substr(get_class($this), 18);
			return Inflector::underscore($class) . '.php';
		}
		
		/**
		 * Allow read only access to our non-public member variables
		 * 
		 * @param string $variable
		 * @return mixed
		 * @access public
		 */
		public function __get($variable) {
			if (isset($this->$variable)) {
				return $this->$variable;
			}
		}
		
	}