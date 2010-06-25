<?php
	
	/**
	 * Mailer_Message
	 * 
	 * Represents a message.
	 * 
	 * @package mailer
	 * @subpackage mailer.libs
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Mailer_Message {
		
		/**
		 * Attachments
		 * 
		 * @var array
		 * @access protected
		 */
		protected $attachments = array();
		
		/**
		 * Recipient
		 * 
		 * @var string
		 * @access protected
		 */
		protected $recipient = '';
		
		/**
		 * Subject
		 * 
		 * @var string
		 * @access protected
		 */
		protected $subject = '';
		
		/**
		 * Sender
		 * 
		 * @var string
		 * @access protected
		 */
		protected $sender = '';
		
		/**
		 * Template 
		 * 
		 * @var string
		 * @access protected
		 */
		protected $template = 'default';
		
		/**
		 * Layout
		 * 
		 * @var string
		 * @access protected
		 */
		protected $layout = 'default';
		
		/**
		 * Variables
		 * 
		 * @var array
		 * @access protected
		 */
		protected $variables = array();
		
		/**
		 * Construction method
		 * 
		 * @param array $message
		 * @return null
		 * @access public
		 */
		public function __construct($message = array()) {
			// Set our EmailMessageRecipient variables
			if (isset($message['EmailMessageRecipient'])) {
				extract($message['EmailMessageRecipient']);
				if (isset($recipient)) {
					$this->setRecipient($recipient);
				}
			}
			// Set our EmailMessageRecipientvariable variables
			if (isset($message['EmailMessageRecipientVariable'])) {
				$this->setVariables($this->_extractVariables(
					$message['EmailMessageRecipientVariable']
				));
			}
			// Set our Message variables
			if (isset($message['EmailMessage'])) {
				extract($message['EmailMessage']);
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
			// Set our Attachment variables
			if (isset($message['EmailMessageRecipientAttachment'])) {
				$this->setAttachments($message['EmailMessageRecipientAttachment']);
			}
		}
		
		/**
		 * Sets our $attachments member variable
		 * 
		 * @param array $attachments
		 * @return null
		 * @access public
		 */
		public function setAttachments($attachments = array()) {
			$this->attachments = $attachments;
		}
		
		/**
		 * Sets our $recipient member variable
		 * 
		 * @param string $recipient
		 * @return null
		 * @access public
		 */
		public function setRecipient($recipient = '') {
			$this->recipient = $recipient;
		}
		
		/**
		 * Sets our $subject member variable
		 * 
		 * @param string $subject
		 * @return null
		 * @access public
		 */
		public function setSubject($subject = '') {
			$this->subject = $subject;
		}
		/**
		 * Sets our $sender member variable
		 * 
		 * @param string $sender
		 * @return null
		 * @access public
		 */
		public function setSender($sender = '') {
			$this->sender = $sender;
		}
		
		/**
		 * Sets our $template member variable
		 * 
		 * @param string $template
		 * @return null
		 * @access public
		 */
		public function setTemplate($template = '') {
			$this->template = $template;
		}
		
		/**
		 * Sets our $layout member variable
		 * 
		 * @param string $layout
		 * @return null
		 * @access public
		 */
		public function setLayout($layout = '') {
			$this->layout = $layout;
		}
		
		/**
		 * Sets our $variables member variable
		 * 
		 * @param string $variables
		 * @return null
		 * @access public
		 */
		public function setVariables($variables = array()) {
			$this->variables = $variables;
		}
		
		/**
		 * Returns the rendered HTML string
		 * 
		 * @return string
		 * @access public
		 */
		public function getRenderedHtml() {
			return ClassRegistry::getObject('Shell')->Render->html($this);
		}
		
		/**
		 * Returns the rendered text string
		 * 
		 * @return string
		 * @access public
		 */
		public function getRenderedText() {
			return ClassRegistry::getObject('Shell')->Render->text($this);
		}
		
		/**
		 * Allow read access to our variables.
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
		
		/**
		 * Extracts and unserialize()s any EmailMessageRecipientVariable records from
		 * the $array we're given.
		 * 
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
