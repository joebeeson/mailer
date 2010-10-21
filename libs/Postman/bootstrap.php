<?php

	/**
	 * Setup our autoloading class to handle the automatic inclusion of requested
	 * classes.
	 */
	App::import('Lib', 'Mailer.loader');
	$classLoader = new SplClassLoader(
		'Postman',
		dirname(dirname(__FILE__))
	);
	$classLoader->register();
