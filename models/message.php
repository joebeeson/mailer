<?php

	class Message extends MailerAppModel {

		/**
		 * Associated models
		 * @var array
		 */
		public $hasMany = array(
			'MessageRecipient' => array(
				'dependent' => true
			)
		);

	}