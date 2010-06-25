<?php

	/**
	 * EmailMessageRecipientAttachment
	 * 
	 * @package mailer
	 * @subpackage mailer.models
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class EmailMessageRecipientAttachment extends MailerAppModel {

		/**
		 * Associated models
		 * 
		 * @var array
		 * @access public
		 */
		public $belongsTo = array(
			'EmailMessageRecipient'
		);

	}