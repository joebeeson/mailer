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
			
		}
		
		/**
		 * Checks if the requested $transport exists
		 * @param string $transport
		 * @return boolean
		 * @access private
		 */
		private function _transportExists($transport = '') {
			
		}
		
		/**
		 * Loads the requested $transport
		 * @param string $transport
		 * @return boolean
		 * @access private
		 */
		private function _loadTransport($transport = '') {
			
		}
		
	}