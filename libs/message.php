<?php
	
	/**
	 * Mailer_Message
	 * Represents a message.
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Mailer_Message {
		
		/**
		 * Recipient
		 * @var string
		 * @access protected
		 */
		protected $recipient = '';
		
		/**
		 * Subject
		 * @var string
		 * @access protected
		 */
		protected $subject = '';
		
		/**
		 * Sender
		 * @var string
		 * @access protected
		 */
		protected $sender = '';
		
		/**
		 * Template 
		 * @var string
		 * @access protected
		 */
		protected $template = 'default';
		
		/**
		 * Layout
		 * @var string
		 * @access protected
		 */
		protected $layout = 'default';
		
		/**
		 * Variables
		 * @var array
		 * @access protected
		 */
		protected $variables = array();
		
		/**
		 * Construction method
		 * @param array $message
		 * @return null
		 * @access public
		 */
		public function __construct($message = array()) {
			// Set our MessageRecipient variables
			if (isset($message['MessageRecipient'])) {
				extract($message['MessageRecipient']);
				if (isset($recipient)) {
					$this->setRecipient($recipient);
				}
			}
			// Set our MessageRecipientvariable variables
			if (isset($message['MessageRecipientVariable'])) {
				$this->setVariables($this->_extractVariables(
					$message['MessageRecipientVariable']
				));
			}
			// Set our Message variables
			if (isset($message['Message'])) {
				extract($message['Message']);
				if (isset($subject)) {
					$this->setSubject($subject);
				}
				if (isset($from)) {
					$this->setSender($from);
				}
				if (isset($template)) {
					$this->setTemplate($template);
				}
				if (isset($layout)) {
					$this->setLayout($layout);
				}
			}
		}
		
		/**
		 * Sets our $recipient member variable
		 * @param string $recipient
		 * @return null
		 * @access public
		 */
		public function setRecipient($recipient = '') {
			$this->recipient = $recipient;
		}
		
		/**
		 * Sets our $subject member variable
		 * @param string $subject
		 * @return null
		 * @access public
		 */
		public function setSubject($subject = '') {
			$this->subject = $subject;
		}
		/**
		 * Sets our $sender member variable
		 * @param string $sender
		 * @return null
		 * @access public
		 */
		public function setSender($sender = '') {
			$this->sender = $sender;
		}
		
		/**
		 * Sets our $template member variable
		 * @param string $template
		 * @return null
		 * @access public
		 */
		public function setTemplate($template = '') {
			$this->template = $template;
		}
		
		/**
		 * Sets our $layout member variable
		 * @param string $layout
		 * @return null
		 * @access public
		 */
		public function setLayout($layout = '') {
			$this->layout = $layout;
		}
		
		/**
		 * Sets our $variables member variable
		 * @param string $variables
		 * @return null
		 * @access public
		 */
		public function setVariables($variables = array()) {
			$this->variables = $variables;
		}
		
		/**
		 * Returns the rendered HTML string
		 * @return string
		 * @access public
		 */
		public function getRenderedHtml() {
			return ClassRegistry::getObject('Shell')->Render->html($this);
		}
		
		/**
		 * Returns the rendered text string
		 * @return string
		 * @access public
		 */
		public function getRenderedText() {
			return ClassRegistry::getObject('Shell')->Render->text($this);
		}
		
		/**
		 * Allow read access to our variables.
		 * @param string $variable
		 * @return mixed
		 * @access public
		 */
		public function __get($variable) {
			if (isset($this->$variable)) {
				return $this->$variable;
			}
		}
		
		/**
		 * Extracts and unserialize()s any MessageRecipientVariable records from
		 * the $array we're given.
		 * @param array $array
		 * @return array
		 * @access private
		 */
		private function _extractVariables($array = array()) {
			$variables = array();
			if (is_array($array) and !empty($array)) {
				$variables = Set::combine($array,
					'/key',
					'/value'
				);
				foreach ($variables as &$variable) {
					$variable = unserialize($variable);
				}
			}
			return $variables;
		}
		
	}