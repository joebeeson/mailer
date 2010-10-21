<?php

	/**
	 * PostmanTask
	 *
	 * Task for accessing the `Postman` object through a shell.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @see http://book.cakephp.org/view/112/Tasks
	 */
	class PostmanTask extends Shell {

		/**
		 * Initialization
		 *
		 * @return null
		 * @access public
		 */
		public function initialize() {
			App::import(
				'Libs',
				'Postman.Postman',
				array(
					'file' => 'Postman.php'
				)
			);
		}

	}
