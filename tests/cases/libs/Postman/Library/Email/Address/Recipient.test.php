<?php

	/**
	 * RecipientTest
	 *
	 * Test case for the `Recipient` class of the `Mailer` library.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class RecipientTest extends CakeTestCase {

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
			$this->_object = new \Postman\Library\Email\Address\Recipient;
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
		 * Tests the `setType` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testSetType() {
			$this->assertIdentical($this->_object->getType(), 'to');

			// Confirm the type has been changed from our default.
			$this->_object->setType('cc');
			$this->assertIdentical($this->_object->getType(), 'cc');

			// This should fail since it's an invalid type.
			$this->expectException();
			$this->_object->setType('fail');
		}

		/**
		 * Tests the `__construct` method.
		 *
		 * @return void
		 * @access public
		 */
		public function test__construct() {
			$this->_object = new \Postman\Library\Email\Address\Recipient('test@test.com', 'cc');
			$this->assertIdentical(
				$this->_object->getAddress(),
				'test@test.com'
			);
			$this->assertIdentical(
				$this->_object->getType(),
				'cc'
			);

			// This should throw an exception since it's not a valid recipient type.
			$this->expectException();
			$this->_object = new \Postman\Library\Email\Address\Recipient('fail@fail.com', 'fail');
		}

	}