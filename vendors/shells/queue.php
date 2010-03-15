<?php

	// Bring in our AppShell library...
	App::import('Lib', 'Mailer.app_shell');

	/**
	 * QueueShell
	 * 
	 * Performs the actual mailing of the queued messages.
	 * 
	 * @package mailer
	 * @subpackage mailer.vendors.shells
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class QueueShell extends AppShell {
		
		/**
		 * Models
		 * 
		 * @var array
		 * @access public
		 */
		public $uses = array(
			'Mailer.Message',
			'Mailer.MessageRecipientVariable',
			'Mailer.MessageRecipient',
		);
		
		/**
		 * Tasks
		 * 
		 * @var array
		 * @access public
		 */
		public $tasks = array(
			'Render',
			'Transport',
			'Debug'
		);
		
		/**
		 * Settings
		 * 
		 * These can be overridden by passing parameters to the shell.
		 * Example: queue process -limit 10 -tries 3 -test -transport pear
		 * 
		 * @var array
		 * @access public
		 */
		public $settings = array(
		
			// The number of messages to mail at once
			'limit' 	=> 50,
			
			// If we're in testing mode or not
			'test'  	=> false,
			
			// Number of times we'll try to mail a message
			'tries' 	=> 3,
			
			// Directory to look for our views to use
			'views' 	=> 'email',
			
			// The transport to use for mailing
			'transport' => 'debug'
		);
		
		/**
		 * Startup method
		 * 
		 * @return null
		 * @access public
		 */
		public function startup() {
			// This could take awhile...
			set_time_limit(0);
			
			// Load up our required libraries
			$libraries = realpath(dirname(__FILE__) .DS. '..' .DS. '..' .DS. 'libs');
			require($libraries . DS . 'transport.php');
			require($libraries . DS . 'message.php');
			
			// Setup our RenderTask path...
			$this->Render->setPath($this->settings['views']);
			
			// Alert to any testing mode
			if ($this->settings['test']) {
				$this->info('Entering testing mode...');
			}
		}
		
		/**
		 * Retrieves messages from the queue and mails them out.
		 * 
		 * @return null
		 * @access public
		 */
		public function process() {
			extract($this->settings);
			
			// Build our Transport and retrieve eligible messages
			$transport = $this->Transport->construct($transport);
			$messages  = $this->_getEligibleMessages();
			$this->info('Found '.count($messages).' messages for processing...');
			
			// Loop through our messages and send them out
			foreach ($messages as $message) {
				
				// Construct the Mailer_Message, and send it out
				$object = $this->_constructMessageObject($message);
				
				if (!$test) {
					
					// We're not in testing mode, send the message
					if ($transport->sendMessage($object)) {
						
						// The mailing was successful. Set processed.
						$message['MessageRecipient']['processed'] = 1;
						
					} else {
						
						// The mailing was unsuccessful. Increment tries.
						$message['MessageRecipient']['tries']++;
						
					}
					
					// Save the changes back to the MessageRecipient model
					$this->MessageRecipient->save($message['MessageRecipient']);
					
				} else {
					
					// We're in testing mode, don't actually send the message.
					$this->debug('Testing mode, bypassing sendMessage()');
					
				}
			}
		}
		
		/**
		 * Cleans up processed messages
		 * 
		 * @return null
		 * @access public
		 */
		public function cleanup() {
			extract($this->settings);
			$messages = $this->_getProcessedMessages();
			$this->info('Found '.count($messages).' messages for cleanup...');
			$deleted  = 0;
			foreach ($messages as $message) {
				if (!$test) {
					$this->debug('Deleting MessageRecipient '.$message['MessageRecipient']['id']);
					if ($this->MessageRecipient->delete($message['MessageRecipient']['id'])) {
						$deleted++;
					}
				} else {
					$this->debug('Testing mode, bypassing deletion');
				}
			}
			echo $this->info('Successfully cleaned up '.$deleted.' messages');
		}
		
		/**
		 * Convenience method for constructing a new Mailer_Message
		 * 
		 * @param array $message
		 * @return Mailer_Message
		 * @access private
		 */
		private function _constructMessageObject($message = array()) {
			$message = new Mailer_Message($message);
			$this->Debug->message($message);
			return $message;
		}
		
		/**
		 * Returns an array of messages that have been sent.
		 * 
		 * @return array
		 * @access private
		 */
		private function _getProcessedMessages() {
			return $this->MessageRecipient->find('all', array(
				'conditions' => array(

					// Only get MessageRecipient that have been sent
					'`MessageRecipient`.`processed`' => 1
				)
			));
		}
		
		/**
		 * Returns an array of messages that are eligible for mailing. Takes into
		 * account the shell's configuration settings.
		 * @return array
		 * @access private
		 */
		private function _getEligibleMessages() {
			extract($this->settings);
			return $this->MessageRecipient->find('all', array(
				'conditions' => array(
				
					// Only get messages that don't exceed our tries amount
					'`MessageRecipient`.`tries` <= ' . $tries,
					
					// Only get messages that haven't yet been processed
					'`MessageRecipient`.`processed`' => 0
				),
				'contain' => array(
					'Message'
				),
				'limit' => $limit
			));
		}
		
	}