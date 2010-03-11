<?php

	/**
	 * Mailer_Transports_Debug
	 * Default transport used for debugging purposes.
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Mailer_Transports_Debug extends Mailer_Transport {
		
		/**
		 * Sends the message.
		 * @return boolean
		 * @access protected
		 */
		protected function _send() {
			if ($this->_inCli()) {
				echo 'From   : ' . $this->message['Message']['from'] . PHP_EOL;
				echo 'To     : ' . $this->message['MessageRecipient']['recipient'] . PHP_EOL;
				echo 'Subject: ' . $this->message['Message']['subject'] . PHP_EOL;
				echo '----------------------------------------------------' . PHP_EOL;
				echo $this->payload;
				echo PHP_EOL . PHP_EOL;
			}
			return true;
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