<?php
	
	/**
	 * EmailMessage
	 * 
	 * @package mailer
	 * @subpackage mailer.models
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class EmailMessage extends MailerAppModel {

		/**
		 * Associated models
		 * 
		 * @var array
		 * @access public
		 */
		public $hasMany = array(
			'EmailMessageRecipient' => array(
				'dependent' => true
			)
		);

	}