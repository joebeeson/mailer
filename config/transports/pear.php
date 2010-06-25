<?php

	/**
	 * Mailer_Transports_Pear configuration
	 */

	return array(
		/**
		 * Path to the directoy of the PEAR libraries. Leave blank if include_path
		 * already has everything taken care of. (Usually your best bet)
		 */
		'path' 		=> '',
		
		/**
		 * Type of PEAR::Mail backend to use. Your choices are mail, smtp, or sendmail.
		 * The respective configuration options can be better explained at the PEAR 
		 * website: http://pear.php.net/manual/en/package.mail.mail.factory.php
		 */
		'backend'	=> 'mail',
		
		// Sendmail configuration
		'sendmail'  => array(
		
			// Path to the sendmail binary
			'sendmail_path'  => '/usr/bin/sendmail',
			
			// Arguments to pass to sendmail
			'sendmail_args'  => '-i'
		),
		
		// SMTP configuration
		'smtp'		=> array(
		
			// Server to use
			'host' 		=> 'localhost',
			
			// Port to connect
			'post'  	=> 25,
			
			// Use authentication?
			'auth'		=> false,
			
			// Username to authenticate with
			'username'	=> '',
			
			// Password to authenticate with
			'password'	=> '',
			
			// What to send during an EHLO/HELO
			'localhost'	=> 'localhost',
			
			// SMTP timeout in seconds (null for no timeout)
			'timeout' 	=> null,
			
			// To use VERP
			'verp'		=> false,
			
			// Turn on debugging 
			'debug'		=> false,
			
			// Reuse connections?
			'persist' 	=> true
		)
	);
