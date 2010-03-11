<?php

	class MessageRecipientAttachment extends MailerAppModel {

		/**
		 * Associated models
		 * @var array
		 */
		public $belongsTo = array('MessageRecipient');

	}