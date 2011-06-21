<?php

	// Define our namespace.
	namespace Postman\Library\Email\Attachment;

	/**
	 * String
	 *
	 * Represents an attachment whose data is given to us via a string.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class String extends \Postman\Library\Email\Attachment {

		/**
		 * Sets the parameter as our `$_file` member variable.
		 *
		 * @param string
		 * @return null
		 * @access public
		 */
		public function setFile($file) {
			$this->_file = $file;
		}

	}