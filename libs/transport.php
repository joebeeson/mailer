<?php
	
	/**
	 * Mailer_Transport
	 * Acts as a base class for all Transports
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	interface Mailer_Transport {
		
		/**
		 * Method to create and send a message. Should return boolean to indicate
		 * success of the sending.
		 * @param array $message
		 * @return boolean
		 */
		public function sendMessage($message, $payload);
		
	}