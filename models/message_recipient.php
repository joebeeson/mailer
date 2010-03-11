<?php

	class MessageRecipient extends MailerAppModel {

		/**
		 * Associated models
		 * @var array
		 */
		public $belongsTo = array(
			'Message'
		);

		/**
		 * Associated models
		 * @var array
		 */
		public $hasMany   = array(
			'MessageRecipientVariable' => array(
				'dependent' => true
			),
			'MessageRecipientAttachment' => array(
				'dependent' => true
			)
		);

	}