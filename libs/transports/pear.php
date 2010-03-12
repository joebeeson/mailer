<?php

	/**
	 * Mailer_Transports_Pear
	 * Sends email using PEAR::Mail and PEAR::Mail_mime.
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class Mailer_Transports_Pear extends Mailer_Transport {

		/**
		 * PEAR::Mail object
		 * @var Mail
		 * @access protected
		 */
		protected $object;

		/**
		 * Settings
		 * @var array
		 * @access protected
		 */
		protected $settings = array(
			'path' 		=> '',
			'backend'	=> 'mail',
			'mail'		=> array(),
			'sendmail'  => array(
				'sendmail_path'  => '/usr/bin/sendmail',
				'sendmail_args'  => '-i'
			),
			'smtp'		=> array(
				'host' 		=> 'localhost',
				'post'  	=> 25,
				'auth'		=> false,
				'username'	=> '',
				'password'	=> '',
				'localhost'	=> 'localhost',
				'timeout' 	=> null,
				'verp'		=> false,
				'debug'		=> false,
				'persist' 	=> true
			)
		);
		
		/**
		 * Sends the message
		 * @return boolean
		 * @access public
		 */
		public function send() {
			
			// Build up our required Mime stuff and headers
			$Mime    = $this->_setupMimeObject();
			$body    = $Mime->get();
			$headers = $Mime->headers($this->_buildHeaders());
			
			// PEAR::Mail returns a PEAR_Error on failure.
			return ((
				$this->_getMailObject()->send(
					$this->message->recipient,
					$headers,
					$body
				)
			) === true);
		}
		
		/**
		 * Initialization method
		 * @return null
		 * @access protected
		 */
		protected function _initialize() {
			if (!$this->_loadLibraries()) {
				throw new RuntimeException('Mailer_Transports_Pear could not load PEAR::Mail');
			}
		}
		
		/**
		 * Convenience method for building and returning an array of headers that
		 * represents our current Mailer_Message object.
		 * @return array
		 * @access private
		 */
		private function _buildHeaders() {
			return array(
				'From' 		=> $this->message->sender,
				'Subject'	=> $this->message->subject
			);
		}
		
		/**
		 * Convenience method for returning our initialized Mail object
		 * @return Mail
		 * @access private
		 */
		private function _getMailObject() {
			if (empty($this->object)) {
				$this->object = $this->_createMailObject();
			}
			return $this->object;
		}
		
		/**
		 * Returns a Mail_mime object that has been setup
		 * @return Mail_mime
		 * @access private
		 */
		private function _setupMimeObject() {
			$Mime = $this->_createMimeObject();
			
			// Set our body content from the Mailer_Message object
			$Mime->setTXTBody($this->message->getRenderedText());
			$Mime->setHTMLBody($this->message->getRenderedHtml());
			return $Mime;
		}
		
		/**
		 * Handles the construction of our PEAR::Mail_mime object
		 * @return Mail_mime
		 * @access private
		 */
		private function _createMimeObject() {
			return new Mail_mime(PHP_EOL);
		}
		
		/**
		 * Handles the construction of our PEAR::Mail object
		 * @return Mail
		 * @access private
		 */
		private function _createMailObject() {
			return Mail::factory(
				$this->_getSetting('backend'),
				$this->_getSetting(
					$this->_getSetting('backend')
				)
			);
		}
		
		/**
		 * Convenience method for loading our libraries. Returns true on success
		 * @return boolean
		 * @access private
		 */
		private function _loadLibraries() {
			if (!class_exists('Mail')) {
				require(
					$this->_getSetting('path') . 'Mail.php'
				);
			}
			if (!class_exists('Mail_Mime')) {
				require(
					$this->_getSetting('path') . 'Mail/mime.php'
				);
			}
			return (
				class_exists('Mail')
				and
				class_exists('Mail_Mime')
			);
		}
		
	}