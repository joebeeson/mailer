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
		 * @var array
		 * @access protected
		 */
		protected $message;
		
		/**
		 * Payload
		 * @var string
		 * @access protected
		 */
		protected $payload;
		
		/**
		 * Sets our $message member variable. This can be overridden in child
		 * classes to perform needed operations.
		 * @param array $message
		 * @return boolean
		 * @access public
		 */
		public function setMessage($message = array()) {
			$this->message = $message;
			return true;
		}
		
		/**
		 * Sets our $payload member variable. This can be overridden in child
		 * classes to perform needed operations.
		 * @param string $payload
		 * @return boolean
		 * @access public
		 */
		public function setPayload($payload = '') {
			$this->payload = $payload;
			return true;
		}
		
		/**
		 * Sends the requested message. If no parameters are passed it will assume
		 * you mean the currently available member variables.
		 * @param string $payload
		 * @param array $message
		 * @return boolean
		 * @access public
		 */
		final public function sendMessage($payload = '', $message = array()) {
			if (!empty($message)) {
				$this->setMessage($message);
			}
			if (!empty($payload)) {
				$this->setPayload($payload);
			}
			return $this->_send();
		}
		
	}