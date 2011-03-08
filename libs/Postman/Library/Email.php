<?php

	namespace Postman\Library;

	/**
	 * Email
	 *
	 * Represents an email and related information that goes with an email. As a
	 * class we end up being passed to the transports for consumption.
	 *
	 * The reason we utilize a class to abstract out the email is so that the
	 * transports have a common agreement on what constitutes an email, us.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @final
	 */
	final class Email {

		/**
		 * From
		 *
		 * @var \Postman\Library\Email\Address
		 * @access protected
		 */
		protected $_from;

		/**
		 * Recipients
		 *
		 * @var array
		 * @access protected
		 */
		protected $_recipients = array();

		/**
		 * Attachments
		 *
		 * @var array
		 * @access protected
		 */
		protected $_attachments = array();

		/**
		 * Subject
		 *
		 * @var string
		 * @access protected
		 */
		protected $_subject = '';

		/**
		 * The HTML version of the email body.
		 *
		 * @var string
		 * @access protected
		 */
		protected $_htmlBody = '';

		/**
		 * The text version of the email body.
		 *
		 * @var string
		 * @access protected
		 */
		protected $_textBody = '';

		/**
		 * The reply-to
		 *
		 * @var \Postman\Library\Email\Address
		 * @access protected
		 */
		protected $_replyTo;

		/**
		 * Catches any requests for non-existant or non-visible methods.
		 *
		 * @param string $method
		 * @param array $arguments
		 * @return mixed
		 * @access public
		 * @see http://php.net/manual/en/language.oop5.magic.php
		 */
		public function __call($method, $arguments) {
			if (substr($method, 0, 3) == 'get') {
				$variable = '_' . lcfirst(substr($method, 3));
				if (isset($this->$variable)) {
					return $this->$variable;
				}
			}
		}

		/**
		 * Sets our `_replyTo` address. Accepts a string or an `Address`
		 * object.
		 *
		 * @param mixed $address
		 * @return \Postman\Library\Email\Address
		 * @access public
		 */
		public function setReplyTo($address) {
			if (is_string($address)) {
				$address = new \Postman\Library\Email\Address($address);
			} elseif (!is_a($address, '\Postman\Library\Email\Address')) {
				throw new \InvalidArgumentException(
					'Email::setReplyTo expects a string or valid Address object.'	
				);
			}

			// Set the `_replyTo` and return the object.
			$this->_replyTo = $address;
			return $address;
		}

		/**
		 * Sets the parameter as our `$_htmlBody` member variable. Returns our
		 * object for chaining.
		 *
		 * @param string $string
		 * @return \Postman\Library\Email
		 * @access public
		 */
		public function setHtmlBody($string = '') {
			$this->_htmlBody = $string;
			return $this;
		}

		/**
		 * Sets the parameter as our `$_textBody` member variable. Returns our
		 * object for chaining.
		 *
		 * @param string $string
		 * @return \Postman\Library\Email
		 * @access public
		 */
		public function setTextBody($string = '') {
			$this->_textBody = $string;
			return $this;
		}

		/**
		 * Sets the parameter as our `$_subject` member variable. Returns our
		 * object for chaining.
		 *
		 * @param string $subject
		 * @return \Postman\Library\Email
		 * @access public
		 */
		public function setSubject($subject = '') {
			$this->_subject = $subject;
			return $this;
		}

		/**
		 * Sets our `_from` address. Accepts a string or an `Address`
		 * object.
		 *
		 * @param mixed $from
		 * @return \Postman\Library\Email\Address
		 * @access public
		 */
		public function setFrom($from) {
			if (is_string($from)) {
				$from = new \Postman\Library\Email\Address($from);
			} elseif (!is_a($from, '\Postman\Library\Email\Address')) {
				throw new \InvalidArgumentException(
					'Email::setFrom expects a string or valid Address object.'
				);
			}

			// Set the `_from_ and return the object.
			$this->_from = $from;
			return $from;
		}

		/**
		 * Creates a new `Recipient` object and attaches it to our `$_recipients`
		 * member variable. Returns the created object.
		 *
		 * @param string $recipient
		 * @param string $type
		 * @return \Postman\Library\Email\Recipient
		 * @access public
		 */
		public function addRecipient($recipient, $type = 'to') {
			if (is_string($recipient)) {
				$recipient = new \Postman\Library\Email\Address\Recipient($recipient, $type);
			} elseif (!is_a($recipient, '\Postman\Library\Email\Address\Recipient')) {
				throw new \InvalidArgumentException(
					'Email::addRecipient expects a string or valid Address object.'
				);
			}

			// Add the recipient and return the object.
			$this->_recipients[] = $recipient;
			return $recipient;
		}

		/**
		 * Creates a new `Attachment` object and attaches it to our `$_attachments`
		 * member variable. Returns the created object.
		 *
		 * @param string $file
		 * @param string $name
		 * @return \Postman\Library\Email\Attachment
		 * @access public
		 */
		public function addAttachment($file, $name = '') {
			if (is_string($file)) {
				$attachment = new \Postman\Library\Email\Attachment(
					$file,
					$name
				);
			} elseif (!is_a($file, '\Postman\Library\Email\Attachment')) {
				throw new \InvalidArgumentException(
					'Email::addAttachment expects a string or valid Attachment object.'
				);
			}

			// Add the attachment and return the object.
			$this->_attachments[] = $attachment;
			return $attachment;
		}

	}
