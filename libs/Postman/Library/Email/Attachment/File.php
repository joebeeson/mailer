<?php

	// Define our namespace.
	namespace Postman\Library\Email\Attachment;

	/**
	 * File
	 *
	 * Represents an attachment that has its data stored on the local filesystem
	 * or a location otherwise reachable via a stream.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class File extends \Postman\Library\Email\Attachment {

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

	}