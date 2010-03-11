<?php

	/**
	 * Performs the actual mailing of the queued messages.
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class QueueShell extends Shell {
		
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
		 * Initialization method
		 * @return null
		 * @access public
		 */
		public function initialize() {
			
			// Merge our parameters with our settings
			$this->settings = am(
				$this->settings,
				$this->params
			);
			
			// Setup our models for later
			foreach ($this->uses as $model) {
				$model = ClassRegistry::init($model);
				$this->{$model->alias} = $model;
			}
			
			// Bind our models
			$this->_bindModels();
			
			// Get our required libraries
			if (!App::import('Core', array('View', 'Controller'))) {
				throw new RuntimeException('Could not load View or Controller');
			}
			if (!App::import('Lib', 'Mailer.transport')) {
				throw new RuntimeException('Could not load Mailer_Transport interface');
			}
			
		}
		
		/**
		 * Retrieves messages from the queue and mails them out.
		 * @return null
		 * @access public
		 */
		public function process() {
			$transport = $this->_constructTransport();
			foreach ($this->_getEligibleMessages() as $message) {
				$transport->sendMessage(
					$message,
					$this->_renderMessage($message)
				);
			}
			
		}
		
		/**
		 * Returns a rendered message for mailing.
		 * @param array $message
		 * @return string
		 * @access private
		 */
		private function _renderMessage($message) {
			
			extract($message['Message']);
			$view = $this->_constructView($message);
			return $view->render($template, $layout);
			
		}
		
		/**
		 * Constructs a new View object and readies it for mailing.
		 * @param array $message
		 * @return View
		 * @access private
		 */
		private function _constructView($message) {
			
			extract($this->settings);
			$object = new View(new Controller());
			$object->set($this->_extractVariables($message));
			$object->layoutPath = '..' . DS . $views . DS . 'layouts';
			$object->viewPath = $views;
			return $object;
			
		}
		
		/**
		 * Constructs our Transport object
		 * @return Mailer_Transport
		 * @access private
		 */
		private function _constructTransport() {
			
			extract($this->settings);
			if (!App::import('Lib', 'Mailer.transports/'.$transport)) {
				throw new RuntimeException('Could not load the "'.$transport.'" transport');
			}
			$class = 'Mailer_Transports_' . Inflector::camelize($transport);
			return new $class;
			
		}
		
		/**
		 * Extracts and unserialize()s any MessageRecipientVariable records from
		 * the $array we're given.
		 * @param array $array
		 * @return array
		 * @access private
		 */
		private function _extractVariables($array = array()) {
			
			$variables = Set::combine($array,
				'/MessageRecipientVariable/key',
				'/MessageRecipientVariable/value'
			);
			foreach ($variables as &$variable) {
				$variable = unserialize($variable);
			}
			return $variables;
			
		}
		
		/**
		 * Bind up our models
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
		 * Returns an array of messages that are eligible for mailing.
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