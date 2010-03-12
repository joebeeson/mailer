<?php

	// Bring in our AppShell library...
	App::import('Lib', 'Mailer.app_shell');

	/**
	 * QueueShell
	 * Performs the actual mailing of the queued messages.
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class QueueShell extends AppShell {
		
		/**
		 * Models
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
			
			/**
			 * For some reason ClassRegistry is giving us AppModel in place of
			 * the actual MessageRecipient model and I have no idea why yet. So
			 * this gets around that and reloads our models.
			 */
			ClassRegistry::removeObject('message_recipient');
			require(realpath(dirname(__FILE__).'/../../models/message_recipient.php'));
			$this->_loadModels();
		}
		
		/**
		 * Retrieves messages from the queue and mails them out.
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
				$message = $this->_constructMessageObject($message);
				
				if (!$test) {
					$success = $transport->sendMessage($message);
					var_dump($success);
				} else {
					$this->debug('Testing mode, bypassing sendMessage()');
				}
			}
		}
		
		/**
		 * Convenience method for constructing a new Mailer_Message
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