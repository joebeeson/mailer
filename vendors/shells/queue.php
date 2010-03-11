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
			'limit' => 50,
			
			// If we're in testing mode or not
			'test'  => false,
			
			// Number of times we'll try to mail a message
			'tries' => 3,
			
			// Directory to look for our views to use
			'views' => 'email',
			
			// The transport to use for mailing
			'transport' => 'debug'
		);
		
		/**
		 * Startup method
		 * @return null
		 * @access public
		 */
		public function startup() {
			// Setup our RenderTask path...
			$this->Render->setPath($this->settings['views']);
			
			// Load up our required libraries
			if (!App::import('Lib', 'Mailer.transport')) {
				throw new RuntimeException('Could not load Mailer_Transport interface');
			}
			
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
				// Performm some debugging then set our message and payload
				$this->Debug->message($message);
				$transport->setMessage($message);
				$transport->setPayload($this->Render->message($message));
				
				if (!$test) {
					// Only actually send the message if we're not testing
					$success = $transport->sendMessage();
					$method  = ($success ? '_markSuccessful' : '_markUnsuccessful');
					$this->debug('Message was '.($success ? 'successfully' : 'not').' sent...');
					$this->$method($message);
				} else {
					// We're just testing, let the person know if in debug
					$this->debug('Skipping message transmission, in testing mode...');
				}
				
			}
		}
		
		/**
		 * Marks the $message as processed
		 * @param array $message
		 * @return null
		 * @access private
		 */
		private function _markSuccessful($message = array()) {
			$message['MessageRecipient']['processed'] = 1;
			$this->MessageRecipient->save($message['MessageRecipient']);
		}
		
		/**
		 * Increments the $message's tries counter
		 * @param array $message
		 * @return null
		 * @access private
		 */
		private function _markUnsuccessful($message = array()) {
			$message['MessageRecipient']['tries']++;
			$this->MessageRecipient->save($message['MessageRecipient']);
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