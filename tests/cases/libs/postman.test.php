<?php

	/**
	 * PostmanTest
	 *
	 * Test case for the `Postman` object.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class PostmanTest extends CakeTestCase {

		/**
		 * Holds our `Postman` object.
		 *
		 * @var Postman
		 * @access protected
		 */
		protected $_object;

		/**
		 * Triggered at the start of the case.
		 *
		 * @return void
		 * @access public
		 */
		public function startCase() {
			if (!class_exists('Postman')) {
				require(App::pluginPath('Mailer') . 'libs' . DS . 'Postman.php');
			}
		}

		/**
		 * Triggered at the start of each test.
		 *
		 * @return void
		 * @access public
		 */
		public function startTest() {
			$this->_object = new Postman;
		}

		/**
		 * Triggered at the end of each test.
		 *
		 * @return void
		 * @access public
		 */
		public function endTest() {
			unset($this->_object);
		}

		/**
		 * Test for the `send` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testSend() {

			// Postman will throw exceptions if we send it the wrong arg.
			$this->expectException();
			$this->_object->send(false);
		}

		/**
		 * Test for the `getTransport` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testGetTransport() {

			// Sanity check.
			$this->assertNull($this->_object->getTransport());
		}

		/**
		 * Test for the `setTransport` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testSetTransport() {
			$this->assertFalse($this->_object->setTransport(false));
			$this->expectException();
			$this->_object->setTransport(new stdClass);
		}

	}