<?php

	/**
	 * Mailer_Transports_Debug
	 * 
	 * Default transport used for debugging purposes.
	 * 
	 * @package mailer
	 * @subpackage mailer.libs.transports
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Mailer_Transports_Debug extends Mailer_Transport {
		
		/**
		 * Settings
		 * 
		 * @var array
		 * @access protected
		 */
		protected $settings = array(
			'payload' => array(
			
				// Should we show a payload?
				'show' => false,
				
				// What type should we show?
				'type' => 'text'
			)
		);
		
		/**
		 * Sends the current message.
		 * 
		 * @return boolean
		 * @access public
		 */
		public function send() {
			if ($this->_inCli()) {
				echo 'From   : ' . $this->message->sender    . PHP_EOL;
				echo 'To     : ' . $this->message->recipient . PHP_EOL;
				echo 'Subject: ' . $this->message->subject   . PHP_EOL;
				
				// Check if we should be rendering the payload
				if ($this->_getSetting('payload.show')) {
					echo '----------------------------------------------------' . PHP_EOL;
					$method = 'getRendered' . ucwords($this->_getSetting('payload.type'));
					echo $this->message->$method();
				}
				
				// Place a buffer after us
				echo PHP_EOL . PHP_EOL;
			}
			return true;
		}
		
		/**
		 * Convenience method to check if we're in a CLI environment
		 * 
		 * @return boolean
		 * @access private
		 */
		private function _inCli() {
			return (boolean) stristr(PHP_SAPI, 'cli');
		}
		
	}