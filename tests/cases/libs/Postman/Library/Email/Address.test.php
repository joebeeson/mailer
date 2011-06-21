<?php

	/**
	 * AddressTest
	 *
	 * Test case for the `Address` class of the `Mailer` library.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class AddressTest extends CakeTestCase {

		/**
		 * Address object
		 *
		 * @var Address
		 * @access protected
		 */
		protected $_object;

		/**
		 * Triggered at the start of the testing.
		 *
		 * @return void
		 * @access public
		 */
		public function startCase() {
			App::import(
				'Libs',
				'Mailer.Postman/bootstrap',
				array(
					'file' => 'bootstrap.php'
				)
			);
		}

		/**
		 * Triggered at the start of each test.
		 *
		 * @return void
		 * @access public
		 */
		public function startTest() {
			$this->_object = new \Postman\Library\Email\Address;
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
		 * Tests the `setAddress` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testSetAddress() {
			$this->_object->setAddress('test@test.com');
			$this->assertIdentical(
				$this->_object->getAddress(),
				'test@test.com'
			);
		}

		/**
		 * Tests the `__construct` method.
		 *
		 * @return void
		 * @access public
		 */
		public function test__construct() {
			$this->_object = new \Postman\Library\Email\Address('test@test.com');
			$this->assertIdentical(
				$this->_object->getAddress(),
				'test@test.com'
			);
		}

	}