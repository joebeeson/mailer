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
		protected $_replyTo ;

		/**
		 * Called when attempting to access a non-visible member variable or
		 * a member variable that doesn't exist.
		 *
		 * @param string $variable
		 * @return mixed
		 * @access public
		 */
		public function __get($variable) {
			if (isset($this->$variable)) {
				return $this->$variable;
			}
		}

		/**
		 * Creates a new `\Postman\Library\Email\Address` object and sets its
		 * address with the given parameter then assigns the object to our
		 * `$_replyTo` member variable.
		 *
		 * @param string $address
		 * @return \Postman\Library\Email\Address
		 * @access public
		 */
		public function setReplyTo($address) {
			$address = new \Postman\Library\Email\Address($address);
			$this->_replyTo = $address;
			return $address;
		}

		/**
		 * Sets the parameter as our `$_htmlBody` member variable.
		 *
		 * @param string $string
		 * @return null
		 * @access public
		 */
		public function setHtmlBody($string = '') {
			$this->_htmlBody = $string;
		}

		/**
		 * Sets the parameter as our `$_textBody` member variable.
		 *
		 * @param string $string
		 * @return null
		 * @access public
		 */
		public function setTextBody($string = '') {
			$this->_textBody = $string;
		}

		/**
		 * Sets the parameter as our `$_subject` member variable.
		 *
		 * @param string $subject
		 * @return null
		 * @access public
		 */
		public function setSubject($subject = '') {
			$this->_subject = $subject;
		}

		/**
		 * Creates a new `\Postman\Library\Email\Address` object and sets its
		 * address with the given parameter then assigns the object to our
		 * `$_from` member variable.
		 *
		 * Returns the newly created `Address` object.
		 *
		 * @param string $from
		 * @return \Postman\Library\Email\Address
		 * @access public
		 */
		public function setFrom($from) {
			$from = new \Postman\Library\Email\Address($from);
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
			$recipient = new \Postman\Library\Email\Address\Recipient(
				$recipient,
				$type
			);
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
			$attachment = new \Postman\Library\Email\Attachment(
				$file,
				$name
			);
			$this->_attachments[] = $attachment;
			return $attachment;
		}

	}
