<?php
	
	/**
	 * Mailer_Transport
	 * Acts as a base class for all Transports
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @abstract
	 */
	abstract class Mailer_Transport {
		
		/**
		 * Message
		 * @var Mailer_Message
		 * @access protected
		 */
		protected $message;
		
		/**
		 * Sets our $message member variable. This can be overridden in child
		 * classes to perform needed operations.
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
		 * @return boolean
		 * @access public
		 */
		abstract public function send();
		
	}