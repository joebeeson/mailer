<?php

	/**
	 * DebugTask
	 * Handles displaying the debugging messages.
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class DebugTask extends AppShell {

		/**
		 * Displays a handful of useful debugging messages
		 * @param array $message
		 * @return null
		 * @access private
		 */
		public function message($message = array()) {
			if ($this->debug) {
				$this->hr();
				$this->debug('     ID: '.$message['MessageRecipient']['id']);
				$this->debug('   From: '.$message['Message']['from']);
				$this->debug('     To: '.$message['MessageRecipient']['recipient']);
				$this->debug('Subject: '.$message['Message']['subject']);
				$this->hr();
			}
		}
		
	}