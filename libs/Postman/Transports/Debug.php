<?php

	namespace Postman\Transports;

	/**
	 * Debug
	 *
	 * A mail transport for debugging messages. Any message sent to us will be
	 * written away to the application's logs or wherever our `folder` setting
	 * tells us to.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Debug extends \Postman\Library\Transport {

		/**
		 * Sends the given `\Postman\Library\Email` object. Returns boolean to
		 * indicate success of the operation.
		 *
		 * @param \Postman\Library\Email $email
		 * @return boolean
		 * @access public
		 */
		public function send(\Postman\Library\Email $email) {
			pr($email);
		}

	}
