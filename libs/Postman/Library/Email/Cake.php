<?php

	// Define our namespace.
	namespace Postman\Library\Email;

	/**
	 * Cake
	 *
	 * Mimics CakePHP's `EmailComponent` by utilizing a `View`
	 * object for rendering the email contents.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Cake extends \Postman\Library\Email {

		/**
		 * Defines which template to use.
		 *
		 * @var string
		 * @access protected
		 */
		protected $_template = 'default';

		/**
		 * Defines which layout to use.
		 *
		 * @var string
		 * @access protected
		 */
		protected $_layout = 'default';

		/**
		 * Holds our view variables.
		 *
		 * @var array
		 * @access protected
		 */
		protected $_viewVars = array();

		/**
		 * Sets our `$_template` member variable to the passed parameter.
		 *
		 * @param string $template
		 * @return void
		 * @access public
		 */
		public function setTemplate($template = 'default') {
			$this->_template = $template;
		}

		/**
		 * Sets our `$_layout` member variable to the passed parameter.
		 *
		 * @param string $layout
		 * @return void
		 * @access public
		 */
		public function setLayout($layout = 'default') {
			$this->_layout = $layout;
		}

		/**
		 * Similiar to the controller's `set` method.
		 *
		 * @param mixed $key
		 * @param string $value
		 * @return void
		 * @access public
		 */
		public function set($key, $value = '') {
			if (is_array($key)) {
				foreach ($key as $key=>$value) {
					$this->set($key, $value);
				}
			} else {
				$this->_viewVars[$key] = $value;
			}
		}

		/**
		 * Renders the HTML version of the email.
		 *
		 * @return string
		 * @access public
		 */
		public function getHtmlBody() {
			/**
			 * TODO
			 *
			 * Write code to render the HTML version.
			 */
		}

		/**
		 * Renders the text version of the email.
		 *
		 * @return string
		 * @access public
		 */
		public function getTextBody() {
			/**
			 * TODO
			 *
			 * Write code to render the text version.
			 */
		}

	}