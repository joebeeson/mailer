<?php

	/**
	 * MessageRecipientAttachment
	 * 
	 * @package mailer
	 * @subpackage mailer.models
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class MessageRecipientAttachment extends MailerAppModel {

		/**
		 * Associated models
		 * 
		 * @var array
		 * @access public
		 */
		public $belongsTo = array(
			'MessageRecipient'
		);

	}