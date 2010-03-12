<?php

	/**
	 * AppShell
	 * 
	 * Provides common functionality to all shells
	 * 
	 * @package mailer
	 * @subpackage mailer.libs
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class AppShell extends Shell {
		
		/**
		 * Debug
		 * 
		 * If we should be displaying debugging messages. This can be set to true
		 * by simply passing -debug when starting the shell.
		 * 
		 * @var boolean
		 * @access protected
		 */
		protected $debug = false;
		
		/**
		 * Silent
		 * 
		 * Passsing -silent when starting the shell will make us hide any messages
		 * that aren't urgent (warning messages for example)
		 * 
		 * @var boolean
		 * @access protected
		 */
		protected $silent = false;
		
		/**
		 * Models
		 * 
		 * @var array
		 * @access public
		 */
		public $uses = array();
		
		/**
		 * Settings
		 * 
		 * @var array
		 * @access protected
		 */
		protected $settings = array();
		
		/**
		 * Initialize method
		 * 
		 * @return null
		 * @access public
		 */
		public function initialize() {
			// Call our parent's initialize()
			parent::initialize();
			
			// Merge any parameters into our settings
			$this->_mergeSettings($this->params);
			
			// Set our debug and silent levels
			$this->debug  = array_key_exists('debug', $this->params);
			$this->silent = array_key_exists('silent' , $this->params);
			
			// Attach ourselves to the ClassRegistry as 'Shell'
			ClassRegistry::addObject('Shell', $this);
		}
		
		/**
		 * Allow read access to our non-public member variables
		 * 
		 * @param string $variable
		 * @return mixed
		 * @access public
		 * @final
		 */
		final public function __get($variable) {
			if (isset($this->$variable)) {
				return $this->$variable;
			}
		}
		
		/**
		 * Displays a debug message if we're debugging and not silent.
		 * 
		 * @param string $message
		 * @return null
		 * @access public
		 * @final
		 */
		final public function debug($message = '') {
			if ($this->debug and !$this->silent) {
				$this->out('DEBUG: '.$message);
			}
		}
		
		/**
		 * Displays an informational message if we're not silent.
		 * 
		 * @param string $message
		 * @return null
		 * @access public
		 * @final
		 */
		final public function info($message = '') {
			if (!$this->silent) {
				$this->out('INFO : '.$message);
			}
		}
		
		/**
		 * Displays a warning message.
		 * 
		 * @param string $message
		 * @return null
		 * @access public
		 * @final
		 */
		final public function warn($message = '') {
			$this->out('WARN : '.$message);
		}
		
		/**
		 * Merges the passed $array into our member variable, $settings
		 * 
		 * @param array $array
		 * @return null
		 * @access protected
		 */
		protected function _mergeSettings($array = array()) {
			$this->settings = am(
				$this->settings,
				$array
			);
		}
		
		/**
		 * Loads the requested $model up.
		 * 
		 * @param string $model
		 * @return null
		 * @access protected
		 */
		protected function _loadModel($model = '') {
			$model = ClassRegistry::init($model);
			$this->{$model->alias} = $model;
		}
		
	}