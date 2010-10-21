<?php

	namespace Postman\Transports;

	/**
	 * Postmark
	 *
	 * A mail transport for the Postmark application.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 * @see http://postmarkapp.com/
	 */
	class Postmark extends \Postman\Library\Transport {

		/**
		 * Holds the `HttpSocket` class we will be using to send the emails to
		 * the Postmark servers.
		 *
		 * @var \HttpSocket
		 * @access protected
		 */
		protected $_httpSocket;

		/**
		 * Default settings. Any configuration passed to `setSettings` will
		 * be merged into this member variable.
		 *
		 * @var array
		 * @access protected
		 */
		protected $_settings = array(
			'api-key' => '',
			'testing' => false
		);

		/**
		 * Sends the given `\Postman\Library\Email` object. Returns boolean to
		 * indicate success of the operation.
		 *
		 * @param \Postman\Library\Email $email
		 * @return boolean
		 * @access public
		 */
		public function send(\Postman\Library\Email $email) {

			/**
			 * Builds the POST to the Postmark server with our JSON payload and
			 * the API key in the header. Runs a `json_decode` against the
			 * returned response.
			 */
			$response = json_decode($this->_getHttpSocket()->post(
				'http://api.postmarkapp.com/email',
				$this->_buildJsonPayload($email),
				array(
					'header' => array(
						'X-Postmark-Server-Token' 	=> $this->__getApiKey(),
						'Content-Type'				=> 'text/json'
					)
				)
			));

			/**
			 * Inspect the response. If everything didn't go as planned we will
			 * log a message away for debugging and then return false.
			 */
			if ($response->ErrorCode !== 0) {
				\Configure::log('Postmark::send() received an API error, "' . $response->Message . '"');
				return false;
			} else {
				return true;
			}
		}

		/**
		 * Initialization method, called after construction.
		 *
		 * @return null
		 * @access protected
		 */
		protected function _initialize() {
			// Make sure we have their API key, since its required
			if (strlen($this->_getSetting('api-key')) == 0) {
				throw new \InvalidArgumentException(
					'An "api-key" setting is required'
				);
			}
		}

		/**
		 * Convenience method for returning the `HttpSocket` object.
		 *
		 * @return \HttpSocket
		 * @access protected
		 */
		protected function _getHttpSocket() {
			if (!class_exists('\HttpSocket')) {
				\App::import('HttpSocket');
			}
			if (!is_object($this->_httpSocket)) {
				$this->_httpSocket = new \HttpSocket();
			}
			return $this->_httpSocket;
		}

		/**
		 * Returns a JSON string for sending to the Postmark API servers which
		 * represents the `Email` object.
		 *
		 * @param \Postman\Library\Email $email
		 * @return string
		 * @access protected
		 */
		protected function _buildJsonPayload(\Postman\Library\Email $email) {
			return json_encode(array_merge(
				$this->__buildJsonPayloadRecipients($email),
				$this->__buildJsonPayloadAttachments($email),
				array(
					'From' 		=> $email->getFrom()->getAddress(),
					'Subject'	=> $email->getSubject(),
					'HtmlBody'	=> $email->getHtmlBody(),
					'TextBody'	=> $email->getTextBody(),
					'ReplyTo'	=> $email->getReplyTo()
				)
			));
		}

		/**
		 * Returns an array which represents all of the recipients attached to
		 * the `Email` object we're given.
		 *
		 * @param \Postman\Library\Email $email
		 * @return array
		 * @access private
		 */
		private function __buildJsonPayloadRecipients(\Postman\Library\email $email) {
			$return = array('To' => array(), 'Cc' => array(), 'Bcc' => array());
			foreach ($email->getRecipients() as $recipient) {
				if (in_array($recipient->getType(), array('to', 'cc', 'bcc'))) {
					$return[ucwords($recipient->getType())][] = $recipient->getAddress();
				}
			}
			return array_map(
				function($array) { return implode(', ', $array); },
				$return
			);
		}

		/**
		 * Returns an array which represents all of the attachments attached to
		 * the `Email` object we're given.
		 *
		 * @param \Postman\Library\Email $email
		 * @return array
		 * @access private
		 */
		private function __buildJsonPayloadAttachments(\Postman\Library\Email $email) {
			$return = array('Attachments' => array());
			foreach ($email->getAttachments() as $attachment) {
				$contents = base64_encode(file_get_contents($attachment->getFile()));
				$return['Attachments'][] = array(
					'Name' 			=> $attachment->getName(),
					'Content' 		=> $contents,
					'ContentType'	=> $attachment->getContentType()
				);
			}
			return $return;
		}

		/**
		 * Returns the API key for communicating with the server. If the `testing`
		 * setting is true we will return "POSTMARK_API_TEST" so that we don't
		 * actually end up sending any emails.
		 *
		 * @return string
		 * @access private
		 */
		private function __getApiKey() {
			if ($this->_getSetting('testing')) {
				return 'POSTMARK_API_TEST';
			} else {
				return $this->_getSetting('api-key');
			}
		}

	}
