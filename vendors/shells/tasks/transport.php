<?php

	/**
	 * TransportTask
	 * Handles the construction and usage of Transports
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class TransportTask extends AppShell {
		
		/**
		 * Returns an initialized transport
		 * @param string $transport
		 * @return Mailer_Transport
		 * @access public
		 */
		public function construct($transport = '') {
			if (!$this->_transportExists($transport)) {
				throw new RuntimeException('No such transport, "'.$transport.'" exists');
			} else {
				if (!$this->_loadTransport($transport)) {
					throw new RuntimeException('Could not load transport, "'.$transport.'"');
				} else {
					$className = $this->_transportClass($transport);
					return new $className();
				}
			}
		}
		
		/**
		 * Checks if the requested $transport exists
		 * @param string $transport
		 * @return boolean
		 * @access private
		 */
		private function _transportExists($transport = '') {
			return file_exists(
				$this->_transportDirectory() . $this->_transportFile($transport)
			);
		}
		
		/**
		 * Convenience method for returning the expected name of the $transport
		 * @param string $transport
		 * @return string
		 * @access private
		 * 
		 */
		private function _transportClass($transport = '') {
			return 'Mailer_Transports_' . Inflector::camelize($transport);
		}
		
		/**
		 * Returns the full path for the requested $transport
		 * @param string $transport
		 * @return string
		 * @access private
		 */
		private function _transportFile($transport = '') {
			return Inflector::slug($transport) . '.php';
		}
		
		/**
		 * Convenience method for returning the directory path for our transports
		 * @return string
		 * @access private
		 */
		private function _transportDirectory() {
			return realpath(
				dirname(__FILE__) . str_repeat(DS.'..'.DS, 3)
			) . DS . 'libs' . DS . 'transports' . DS;
		}
		
		/**
		 * Loads the requested $transport
		 * @param string $transport
		 * @return boolean
		 * @access private
		 */
		private function _loadTransport($transport = '') {
			return App::import(
				'Lib', 'Mailer.transports/'.$transport,
				array(
					'file' => $this->_transportFile($transport)
				)
			);
		}
		
	}