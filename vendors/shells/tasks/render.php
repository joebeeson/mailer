<?php

	/**
	 * RenderTask
	 * 
	 * Handles functionality regarding rendering emails.
	 * 
	 * @package mailer
	 * @subpackage mailer.vendors.shells.tasks
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class RenderTask extends Shell {
		
		/**
		 * Message
		 * 
		 * Holds our current Mailer_Message object
		 * 
		 * @var Mailer_Message
		 * @access protected
		 */
		protected $message;
		
		/**
		 * Helpers
		 * 
		 * Helpers to load. You can add more helpers by passing -helpers upon
		 * execution which is a comma separated list of helpers.
		 * Example: -helpers Form,Javascript
		 * 
		 * @var array
		 * @access protected
		 */
		protected $helpers = array(
			'Html'
		);
		
		/**
		 * Path
		 * 
		 * The directory to look for our templates and layouts in.
		 * 
		 * @var string
		 * @access protected
		 */
		protected $path = 'email';
		
		/**
		 * Initialization method
		 * 
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
			$this->_inspectParameters();
		}
		
		/**
		 * Inspects the execution parameters
		 * 
		 * @return null
		 * @access private
		 */
		private function _inspectParameters() {
			if (array_key_exists('helpers', $this->params)) {
				$this->helpers = array_unique(array_merge(
					explode(',', $this->params['helpers']),
					$this->helpers
				));
			}
		}
		
		/**
		 * Sets our $message member variable.
		 * 
		 * @param array $array
		 * @return null
		 * @access public
		 */
		public function setMessage($array = array()) {
			$this->message = $array;
		}
		
		/**
		 * Sets our $path member variable.
		 * 
		 * @param string $path
		 * @return null
		 * @access public
		 */
		public function setPath($path = '') {
			$this->path = $path;
		}
		
		/**
		 * Returns the rendered text string for the $message
		 * 
		 * @param Mailer_Message $message
		 * @return string
		 * @access public
		 */
		public function html(Mailer_Message $message) {
			return $this->_render(
				$message,
				'html'
			);
		}
		
		/**
		 * Returns the rendered text string for the $message
		 * 
		 * @param Mailer_Message $message
		 * @return string
		 * @access public
		 */
		public function text(Mailer_Message $message) {
			return $this->_render(
				$message,
				'text'
			);
		}
		
		/**
		 * Returns the rendered $type for the passed $message
		 * 
		 * @param Mailer_Message $message
		 * @param string $type
		 * @return string
		 * @access private
		 */
		private function _render(Mailer_Message $message, $type = 'text') {
			// Construct our view and set our message variables to it
			$view = $this->_constructView($message);
			$view->set($message->variables);
			
			// Return our rendered our specific type
			return $view->render(
				$type . DS . $message->template, 
				$type . DS . $message->layout
			);
		}
		
		/**
		 * Constructs a new View object, sets the locations for its rendering 
		 * files and returns the object.
		 * 
		 * @return View
		 * @access private
		 */
		private function _constructView() {
			$object 			= new View(new Controller());
			$object->helpers	= $this->helpers;
			$object->layoutPath = '..' . DS . $this->path . DS . 'layouts';
			$object->viewPath 	= $this->path;
			return $object;
		}
		
	}