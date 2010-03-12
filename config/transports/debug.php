<?php

	/**
	 * Debug configuration
	 * 
	 * All configuration files should return an array. This array will be merged
	 * into the specific Mailer_Transport's $settings member variable.
	 */
	return array(
	
		// Payload related settings
		'payload' => array(
		
			// Should we show the message payload?
			'show' => true,
			
			// What type should we show?
			'type' => 'html'
		)
	);