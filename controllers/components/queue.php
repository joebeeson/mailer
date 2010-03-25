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
		 * Creates a Message record. Returns the ID of the new record.
		 * 
		 * @param string $to
		 * @param string $from
		 * @param string $subject
		 * @param string $template
		 * @param string $layout
		 * @return string
		 */
		public function createMessage($from, $subject, $template, $layout = 'default') {
			$this->Message->create();
			$this->Message->save(compact(
				'to', 'from', 'subject', 'template', 'layout');
			));
			return $this->Message->id;
		}
		
		/**
		 * Adds a recipient to a message. Returns the ID of the new recipient.
		 * 
		 * @param string $message_id
		 * @param string $recipient
		 * @param integer $priority
		 * @return string
		 */
		public function addRecipient($message_id, $recipient, $priority = 0) {
			$this->MessageRecipient->create();
			$this->MessageRecipient->save(compact(
				'message_id', 'recipient', 'priority'
			));
			return $this->MessageRecipient->id;
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
			return $this->MessageRecipient->save(compact(
				'message_recipient_id', 'priority'
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
			$this->MessageRecipientVariable->create();
			return $this->MessageRecipientVariable->save(compact(
				'message_recipient_id', 'key', 'value'
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
			$this->MessageRecipientAttachment->create();
			return $this->MessageRecipientAttachment->save(compact(
				'message_recipient_id', 'file', 'type', 'name'
			));
		}
		
	}