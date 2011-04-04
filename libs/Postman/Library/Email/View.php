<?php

	// Define our namespace.
	namespace Postman\Library\Email;

	/**
	 * View
	 *
	 * Mimics CakePHP's `EmailComponent` by utilizing a `View` object
	 * for rendering the email contents.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class View extends \Postman\Library\Email {

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
		 * The `View` object to use for rendering.
		 *
		 * @var string
		 * @access protected
		 */
		protected $_view = 'View';

		/**
		 * Holds our view variables.
		 *
		 * @var array
		 * @access protected
		 */
		protected $_variables = array();

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
		 * Sets our `$_view` member variable to the passed parameter.
		 *
		 * @param string $view
		 * @return void
		 * @access public
		 */
		public function setView($view = 'View') {
			$this->_view = $view;
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
				$this->_variables[$key] = $value;
			}
		}

		/**
		 * Renders the HTML version of the email.
		 *
		 * @return string
		 * @access public
		 */
		public function getHtmlBody() {
			$object = $this->_getViewObject($this->_view, 'html');
			return $object->render($this->_template);
		}

		/**
		 * Renders the text version of the email.
		 *
		 * @return string
		 * @access public
		 */
		public function getTextBody() {
			$object = $this->_getViewObject($this->_view, 'text');
			return $object->render($this->_template);
		}

		/**
		 * Returns an instantiated `View` object.
		 *
		 * @param string $class
		 * @return mixed
		 * @access protected
		 */
		protected function _getViewObject($class, $type) {
			\App::import('Core', 'Controller');
			if ($class != 'View') {
				list($plugin, $class) = pluginSplit($class);
				\App::import('View', $plugin . '.' . $class);
				$class = $class . 'View';
			} else {
				\App::import('Core', 'View');
			}

			// Instantiate and configure the object.
			$object = new $class(new \Controller);
			$object->layout 	= $this->_layout;
			$object->action 	= $this->_template;
			$object->viewVars 	= $this->_variables;
			$object->viewPath 	= 'email' . DS . $type;
			$object->layoutPath = 'email' . DS . $type;

			// Return the final object.
			return $object;
		}

	}