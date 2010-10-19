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

	}
