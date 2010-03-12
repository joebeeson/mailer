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
		 * Returns the rendered text string for the $message
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
			return $object;
		}
		
	}