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
