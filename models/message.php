<?php
	
	/**
	 * Message
	 * 
	 * @package mailer
	 * @subpackage mailer.models
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Message extends MailerAppModel {

		/**
		 * Associated models
		 * 
		 * @var array
		 * @access public
		 */
		public $hasMany = array(
			'MessageRecipient' => array(
				'dependent' => true
			)
		);

	}