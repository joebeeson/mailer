<?php

	/**
	 * EmailMessageRecipient
	 * 
	 * @package mailer
	 * @subpackage mailer.models
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class EmailMessageRecipient extends MailerAppModel {

		/**
		 * Associated models
		 * 
		 * @var array
		 * @access public
		 */
		public $belongsTo = array(
			'EmailMessage'
		);

		/**
		 * Associated models
		 * 
		 * @var array
		 * @access public
		 */
		public $hasMany = array(
			'EmailMessageRecipientVariable' => array(
				'dependent' => true
			),
			'EmailMessageRecipientAttachment' => array(
				'dependent' => true
			)
		);
		
		/**
		 * Default ordering
		 * 
		 * @var array
		 * @access public
		 */
		public $order = array(
			'`EmailMessageRecipient`.`priority` DESC'
		);

	}