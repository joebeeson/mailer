<?php

	// Bring in our base class.
	if (!class_exists('Postman')) {
		require(App::pluginPath('Mailer') . 'libs' . DS . 'Postman.php');
	}

	/**
	 * PostmanComponent
	 *
	 * Component for accessing the `Postman` object through a controller.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @see http://book.cakephp.org/view/62/Components
	 * @see http://book.cakephp.org/view/497/Components-Helpers-and-Behaviors
	 */
	class PostmanComponent extends Postman {

		/**
		 * Triggered before the controller's `beforeFilter` method but after the
		 * models have been constructed.
		 *
		 * @param Controller $controller
		 * @param array $settings
		 * @return null
		 * @access public
		 * @see http://book.cakephp.org/view/1617/Component-callbacks
		 */
		public function initialize(Controller $controller, $settings = array()) {
			parent::_initialize($settings);
		}

	}
