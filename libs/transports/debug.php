<?php

	/**
	 * Mailer_Transports_Debug
	 * Default transport used for debugging purposes.
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Mailer_Transports_Debug extends Mailer_Transport {
		
		/**
		 * Sends the $payload
		 */
		public function sendMessage($message, $payload) {
			if ($this->_inCli()) {
				extract($message['Message']);
				echo 'From   : ' . $message['Message']['from'] . PHP_EOL;
				echo 'To     : ' . $message['MessageRecipient']['recipient'] . PHP_EOL;
				echo 'Subject: ' . $message['Message']['subject'] . PHP_EOL;
				echo '----------------------------------------------------' . PHP_EOL;
				echo $payload;
				echo PHP_EOL . PHP_EOL;
			}
		}
		
		/**
		 * Convenience method to check if we're in a CLI environment
		 * @return boolean
		 * @access private
		 */
		private function _inCli() {
			return (boolean) stristr(PHP_SAPI, 'cli');
		}
		
	}