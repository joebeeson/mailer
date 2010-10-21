<?php

	namespace Postman\Library\Email;

	/**
	 * Attachment
	 *
	 * Represents an email attachment.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Attachment {

		/**
		 * The file we represent.
		 *
		 * @var string
		 * @access protected
		 */
		protected $_file;

		/**
		 * The name of the file.
		 *
		 * @var string
		 * @access protected
		 */
		protected $_name;

		/**
		 * The content type of the file
		 *
		 * @var string
		 * @access protected
		 */
		protected $_contentType;

		/**
		 * Catches any requests for non-existant or non-visible methods.
		 *
		 * @param string $method
		 * @param array $arguments
		 * @return mixed
		 * @access public
		 * @see http://php.net/manual/en/language.oop5.magic.php
		 */
		public function __call($method, $arguments) {
			if (substr($method, 0, 3) == 'get') {
				$variable = '_' . lcfirst(substr($method, 3));
				if (isset($this->$variable)) {
					return $this->$variable;
				}
			}
		}

		/**
		 * Construction method.
		 *
		 * @param string $address
		 * @return null
		 * @access public
		 */
		public function __construct($file = '', $name = '', $type = 'text/plain') {
			if (!empty($file)) {
				$this->setFile($file);
				$this->setContentType($type);
				if (!empty($name)) {
					$this->setName($name);
				} else {
					$this->setName(basename($file));
				}
			}
		}

		/**
		 * Sets the parameter as our `$_file` member variable.
		 *
		 * @param string
		 * @return null
		 * @access public
		 */
		public function setFile($file) {
			if (!file_exists($file)) {
				throw new \InvalidArgumentException(
					"'$file' does not exist"
				);
			} else {
				$this->_file = $file;
			}
		}

		/**
		 * Sets the parameter as our `$_contentType` member variable.
		 *
		 * @param string
		 * @return null
		 * @access public
		 */
		public function setContentType($type) {
			$this->_contentType = $type;
		}

		/**
		 * Sets the parameter as our `$_name` member variable.
		 *
		 * @param string
		 * @return null
		 * @access public
		 */
		public function setName($name) {
			$this->_name = $name;
		}

	}
