<?php

	/**
	 * DebugTask
	 * Handles displaying the debugging messages.
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class DebugTask extends AppShell {

		/**
		 * Displays a handful of useful debugging messages
		 * @param Mailer_Message $message
		 * @return null
		 * @access private
		 */
		public function message(Mailer_Message $message) {
			if ($this->debug) {
				$this->hr();
				$this->debug('   From: '.$message->sender);
				$this->debug('     To: '.$message->recipient);
				$this->debug('Subject: '.$message->subject);
				$this->hr();
			}
		}
		
	}