<?php

	/**
	 * MessageRecipient
	 * 
	 * @package mailer
	 * @subpackage mailer.models
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class MessageRecipient extends MailerAppModel {

		/**
		 * Associated models
		 * 
		 * @var array
		 * @access public
		 */
		public $belongsTo = array(
			'Message'
		);

		/**
		 * Associated models
		 * 
		 * @var array
		 * @access public
		 */
		public $hasMany = array(
			'MessageRecipientVariable' => array(
				'dependent' => true
			),
			'MessageRecipientAttachment' => array(
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
			'`MessageRecipient`.`priority` DESC'
		);

	}