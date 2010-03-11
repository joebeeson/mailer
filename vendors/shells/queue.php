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
			'Mailer.MessageRecipient',
			'Mailer.MessageRecipientVariable'
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
			
			// Bind our models
			$this->_bindModels();
			
			// Load up our required libraries
			if (!App::import('Lib', 'Mailer.transport')) {
				throw new RuntimeException('Could not load Mailer_Transport interface');
			}
			
			// Alert to any testing mode
			if ($this->settings['test']) {
				$this->info('Entering testing mode...');
			}
		}
		
		/**
		 * Retrieves messages from the queue and mails them out.
		 * @return null
		 * @access public
		 */
		public function process() {
			$transport = $this->_constructTransport();
			$messages  = $this->_getEligibleMessages();
			$this->info('Found '.count($messages).' messages for processing...');
			foreach ($messages as $message) {
				$this->Debug->message($message);
				echo $this->Render->message($message);
				die;
			}
		}
		
		/**
		 * Forcibly setup the associations for our models.
		 * @return null
		 * @access private
		 */
		private function _bindModels() {
			$this->MessageRecipient->bindModel(array(
				'hasMany' => array(
					'MessageRecipientVariable',
					'MessageRecipientAttachment'
				),
				'belongsTo' => array(
					'Message'
				)
			));
			$this->Message->bindModel(array(
				'hasMany' => array(
					'MessageRecipient'
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
				'limit' => $limit
			));
		}
		
	}