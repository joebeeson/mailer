<?php
	
	/**
	 * Mailer_Transport
	 * Acts as a base class for all Transports
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @abstract
	 */
	abstract class Mailer_Transport {
		
		/**
		 * Method to send a message. Should return boolean to indicate success 
		 * of the mailing, if possible.
		 * @param array $message
		 * @param string $payload
		 * @return boolean
		 * @access
		 * @abstract
		 */
		abstract public function sendMessage($message, $payload);
		
	}