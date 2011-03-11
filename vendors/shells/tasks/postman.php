<?php

	// Bring in our base class.
	if (!class_exists('Postman')) {
		require(App::pluginPath('Mailer') . 'libs' . DS . 'Postman.php');
	}

	/**
	 * PostmanTask
	 *
	 * Task for accessing the `Postman` object through a shell.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @see http://book.cakephp.org/view/112/Tasks
	 */
	class PostmanTask extends Postman {

		/**
		 * Triggered upon instantiation.
		 *
		 * @return void
		 * @access public
		 */
		public function __construct() {
			parent::_initialize();
		}

	}
