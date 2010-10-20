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
		 * Default settings. Any configuration passed to `setSettings` will
		 * be merged into this member variable.
		 *
		 * @var array
		 * @access protected
		 */
		protected $_settings = array(
			'api-key' => ''
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
			$socket = new \HttpSocket();
			$response = json_decode($socket->post(
				'http://api.postmarkapp.com/email',
				$this->_buildJson($email),
				array(
					'header' => array(
						'X-Postmark-Server-Token' => $this->_getSetting('api-key'),
						'Content-Type' => 'text/json'
					)
				)
			));
			return ($response->Message == 'OK');
		}

		/**
		 * Given the `$email` object we will build and return a JSON string for
		 * the API that represents the email.
		 *
		 * @param \Postman\Library\Email $email
		 * @return string
		 * @access protected
		 */
		protected function _buildJson(\Postman\Library\Email $email) {
			$array = array();

			/**
			 * Attaches the recipients to their correct part of the array after
			 * pulling their address out of the object.
			 */
			foreach ($email->_recipients as $recipient) {
				if (!isset($array[ucwords($recipient->_type)])) {
					$array[ucwords($recipient->_type)] = array();
				}
				$array[ucwords($recipient->_type)][] = $recipient->_address;
			}

			/**
			 * Postmark expects the 'To', 'Cc' and 'Bcc' fields to be a comma
			 * separated string, not an array. This collapses them into one.
			 */
			foreach (array('To', 'Cc', 'Bcc') as $type) {
				if (isset($array[$type])) {
					$array[$type] = implode(', ', $array[$type]);
				}
			}

			/**
			 * Add the rest of the trimmings to the `$array`
			 */
			$array['Subject'] = $email->_subject;
			$array['From'] = $email->_from->_address;
			$array['HtmlBody'] = $email->_htmlBody;
			$array['TextBody'] = $email->_textBody;
			$array['ReplyTo'] = $email->_replyTo;

			// Return the completed string
			return json_encode($array);
		}

		/**
		 * Initialization method, called after construction.
		 *
		 * @return null
		 * @access protected
		 */
		protected function _initialize() {

			// Make sure we have their API key
			if (strlen($this->_getSetting('api-key')) == 0) {
				throw new \InvalidArgumentException(
					'An "api-key" setting is required'
				);
			}

			// We need the `HttpSocket` class to function
			\App::import('HttpSocket');
		}

	}
