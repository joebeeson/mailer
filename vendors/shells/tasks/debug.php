<?php

	/**
	 * DebugTask
	 * 
	 * Handles common functionality regarding debugging
	 * 
	 * @package mailer
	 * @subpackage mailer.vendors.shells.tasks
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class DebugTask extends AppShell {

		/**
		 * Displays a handful of useful debugging messages
		 * 
		 * @param Mailer_Message $message
		 * @return null
		 * @access public
		 */
		public function message(Mailer_Message $message) {
			if ($this->debug) {
				$this->out("\r\nMessage");
				$this->hr();
				$this->debug('   From: '.$message->sender);
				$this->debug('     To: '.$message->recipient);
				$this->debug('Subject: '.$message->subject);
			}
		}
		
		/**
		 * Displays a handful of useful debugging messages
		 * 
		 * @param Mailer_Transport $transport
		 * @return null
		 * @access public
		 */
		public function transport(Mailer_Transport $transport) {
			if ($this->debug) {
				$this->out("\r\nTransport");
				$this->hr();
				$this->debug('Class: '.get_class($transport));
				$this->out("\r\nSettings");
				$this->hr();
				foreach (Set::flatten($transport->settings) as $key=>$value) {
					$this->debug($key.': '.$value);
				}
				$this->out('');
				$this->in('Press enter to continue...');
			}
		}
		
	}