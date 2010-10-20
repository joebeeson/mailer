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
		 * Construction method.
		 *
		 * @param string $address
		 * @return null
		 * @access public
		 */
		public function __construct($file = '', $name = '') {
			if (!empty($file)) {
				$this->setFile($file);
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
