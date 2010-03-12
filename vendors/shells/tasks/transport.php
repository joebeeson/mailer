<?php

	/**
	 * TransportTask
	 * 
	 * Handles functionality regarding the construction and use of Mailer_Transport
	 * objects.
	 * 
	 * @package mailer
	 * @subpackage mailer.vendors.shells.tasks
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class TransportTask extends AppShell {
		
		/**
		 * Returns an initialized transport
		 * 
		 * @param string $transport
		 * @return Mailer_Transport
		 * @access public
		 */
		public function construct($transport = '') {
			if (!$this->_transportExists($transport)) {
				throw new RuntimeException('No such transport, "'.$transport.'" exists');
			} else {
				$this->_loadTransport($transport);
				$className = $this->_transportClass($transport);
				return new $className();
			}
		}
		
		/**
		 * Checks if the requested $transport exists
		 * 
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
		 * 
		 * @param string $transport
		 * @return string
		 * @access private
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
		 * 
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
		 * 
		 * @param string $transport
		 * @return null
		 * @access private
		 */
		private function _loadTransport($transport = '') {
			require(
				$this->_transportDirectory() . $this->_transportFile($transport)
			);
		}
		
	}