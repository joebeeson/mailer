<?php

	/**
	 * QueueComponent
	 * 
	 * Functionality for easily creating messages from controllers for the Mailer
	 * to process. 
	 * 
	 * @package mailer
	 * @subpackage mailer.controllers.components
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class QueueComponent extends Object {
		
		/**
		 * Initializes the component and loads the required models
		 */
		public function initialize() {
			$this->EmailMessage = ClassRegistry::init('Mailer.EmailMessage');
			$this->EmailMessageRecipient = ClassRegistry::init('Mailer.EmailMessageRecipient');
			$this->EmailMessageRecipientAttachment = ClassRegistry::init('Mailer.EmailMessageRecipientAttachment');
			$this->EmailMessageRecipientVariable = ClassRegistry::init('Mailer.EmailMessageRecipientVariable');
		}
		
		/**
		 * Creates an EmailMessage record. Returns the ID of the new record.
		 * 
		 * @param string $to
		 * @param string $from
		 * @param string $subject
		 * @param string $template
		 * @param string $layout
		 * @return string
		 */
		public function createMessage($from, $subject, $template, $layout = 'default') {
			$this->EmailMessage->create();
			$this->EmailMessage->save(compact(
				'to', 'from', 'subject', 'template', 'layout'
			));
			return $this->EmailMessage->id;
		}
		
		/**
		 * Adds a recipient to a message. Returns the ID of the new recipient.
		 * 
		 * @param string $message_id
		 * @param string $recipient
		 * @param integer $priority
		 * @return string
		 */
		public function addRecipient($email_message_id, $recipient, $priority = 0) {
			$this->EmailMessageRecipient->create();
			$this->EmailMessageRecipient->save(compact(
				'email_message_id', 'recipient', 'priority'
			));
			return $this->EmailMessageRecipient->id;
		}
		
		/**
		 * Sets the priority for a specific message recipient record. Returns 
		 * boolean for succeess.
		 * 
		 * @param string $message_recipient_id
		 * @param integer $priority
		 * @return boolean
		 */
		public function setPriority($message_recipient_id, $priority = 0) {
			return $this->EmailMessageRecipient->save(compact(
				'email_message_recipient_id', 'priority'
			));
		}
		
		/**
		 * Adds a variable to the message recipient.
		 * 
		 * @param string $message_recipient_id
		 * @param string $key
		 * @param mixed $value
		 * @return boolean
		 */
		public function addVariable($message_recipient_id, $key, $value) {
			$value = serialize($value);
			$this->EmailMessageRecipientVariable->create();
			return $this->EmailMessageRecipientVariable->save(compact(
				'email_message_recipient_id', 'key', 'value'
			));
		}
		
		/**
		 * Adds an attachment to the message recipient.
		 * 
		 * @param string $message_recipient_id
		 * @param string $file
		 * @param string $type
		 * @param string $name
		 * @return boolean
		 */
		public function addAttachment($message_recipient_id, $file, $type, $name) {
			$this->EmailMessageRecipientAttachment->create();
			return $this->EmailMessageRecipientAttachment->save(compact(
				'email_message_recipient_id', 'file', 'type', 'name'
			));
		}
		
	}