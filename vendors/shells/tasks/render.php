<?php

	/**
	 * RenderTask
	 * Handles the rendering of emails.
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class RenderTask extends Shell {
		
		/**
		 * Message
		 * @var array
		 * @access protected
		 */
		protected $message;
		
		/**
		 * Path
		 * @var array
		 * @access protected
		 */
		protected $path = 'email';
		
		/**
		 * Initialization method
		 * @return null
		 * @access public
		 */
		public function initialize() {
			if (!App::import('Core', array('View'))) {
				throw new RuntimeException('RenderTask::initialize() could not load the View object');
			}
			if (!App::import('Core', array('Controller'))) {
				throw new RuntimeException('RenderTask::initialize() could not load the Controller object');
			}
		}
		
		/**
		 * Sets our $message member variable.
		 * @param array $array
		 * @return null
		 * @access public
		 */
		public function setMessage($array = array()) {
			$this->message = $array;
		}
		
		/**
		 * Sets our $path member variable.
		 * @param string $path
		 * @return null
		 * @access public
		 */
		public function setPath($path = '') {
			$this->path = $path;
		}
		
		/**
		 * Renders an email message.
		 * @param array $message
		 * @return string
		 * @access public
		 */
		public function message($message = array()) {
			if (!empty($message)) {
				$this->setMessage($message);
			}
			if (empty($this->message)) {
				throw new RuntimeException('RenderTask::render() requires $message to be non-empty');
			} else {
				extract($this->message['Message']);
				$view = $this->_constructView();
				return $view->render($template, $layout);
			}
		}
		
		/**
		 * Constructs a new View object, applies any variables, sets the locations
		 * for its rendering files and returns the object.
		 * @param array $message
		 * @return View
		 * @access private
		 */
		private function _constructView() {
			// Create our View object and setup our paths
			$object = new View(new Controller());
			$object->layoutPath = '..' . DS . $this->path . DS . 'layouts';
			$object->viewPath = $this->path;
			// Attach any variables to the View
			$object->set($this->_extractVariables());
			return $object;
		}
		
		/**
		 * Extracts and unserialize()s any MessageRecipientVariable records from
		 * the $array we're given.
		 * @param array $array
		 * @return array
		 * @access private
		 */
		private function _extractVariables($array = array()) {
			$array = (!empty($array) ? $array : $this->message);
			$variables = array();
			if (is_array($array) and !empty($array)) {
				$variables = Set::combine($array,
					'/MessageRecipientVariable/key',
					'/MessageRecipientVariable/value'
				);
				foreach ($variables as &$variable) {
					$variable = unserialize($variable);
				}
			}
			return $variables;
		}
		
	}