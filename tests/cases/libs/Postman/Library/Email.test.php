<?php

	/**
	 * EmailTest
	 *
	 * Test case for the `Email` class of the `Mailer` library.
	 *
	 * @author Joe Beeson <jbeeson@gmail.com>
	 */
	class EmailTest extends CakeTestCase {

		/**
		 * Email object.
		 *
		 * @var Email
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
			$this->_object = new \Postman\Library\Email;
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
		 * Tests the `addRecipient` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testAddRecipient() {
			$this->assertIdentical($this->_object->getRecipients(), array());
			$email1 = new \Postman\Library\Email\Address\Recipient('test@test1.com', 'to');
			$email2 = new \Postman\Library\Email\Address\Recipient('test@test2.com', 'bcc');

			/**
			 * The object takes care of converting strings into their appropriate objects
			 * so we should expect the *exact* same object back after this.
			 */
			$this->assertIdentical(
				$this->_object->addRecipient('test@test1.com'),
				$email1
			);

			// It should also be able to accept a `Recipient` object.
			$this->assertIdentical(
				$this->_object->addRecipient($email2),
				$email2
			);

			// This should fail since it's not a valid `Recipient` object.
			$this->expectException();
			$this->_object->addRecipient(new Object);
		}

		/**
		 * Tests the `addAttachment` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testAddAttachment() {
			$this->assertIdentical($this->_object->getAttachments(), array());
			$attachment1 = new \Postman\Library\Email\Attachment\File(APP . 'config/core.php');
			$attachment2 = new \Postman\Library\Email\Attachment\String('string');

			/**
			 * The object takes care of converting strings into their appropriate objects
			 * so we should expect the *exact* same object back after this.
			 */
			$this->assertIdentical(
				$this->_object->addAttachment(APP . 'config/core.php'),
				$attachment1
			);

			// Similar as above but instead a `String` object.
			$this->assertIdentical(
				$this->_object->addAttachment('string'),
				$attachment2
			);

			// It should also be able to accept an `Attachment` object.
			$this->assertIdentical(
				$this->_object->addAttachment($attachment2),
				$attachment2
			);

			// This should fail since it's not a valid `Attachment` object.
			$this->expectException();
			$this->_object->addAttachment(new Object);
		}

		/**
		 * Tests the `setReplyTo` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testSetReplyTo() {
			$this->assertNull($this->_object->getReplyTo());
			$email1 = new \Postman\Library\Email\Address('test@test1.com');
			$email2 = new \Postman\Library\Email\Address('test@test2.com');

			/**
			 * The object takes care of converting strings into their appropriate objects
			 * so we should expect the *exact* same object back after this.
			 */
			$this->assertIdentical(
				$this->_object->setReplyTo('test@test1.com'),
				$email1
			);

			// It should also be able to accept an `Address` object.
			$this->assertIdentical(
				$this->_object->setReplyTo($email2),
				$email2
			);

			// This should fail since it's not a valid `Address` object.
			$this->expectException();
			$this->_object->setReplyTo(new Object);
		}

		/**
		 * Tests the `setFrom` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testFrom() {
			$this->assertNull($this->_object->getFrom());
			$email1 = new \Postman\Library\Email\Address('test@test1.com');
			$email2 = new \Postman\Library\Email\Address('test@test2.com');

			/**
			 * The object takes care of converting strings into their appropriate objects
			 * so we should expect the *exact* same object back after this.
			 */
			$this->assertIdentical(
				$this->_object->setFrom('test@test1.com'),
				$email1
			);

			// It should also be able to accept an `Address` object.
			$this->assertIdentical(
				$this->_object->setFrom($email2),
				$email2
			);

			// This should fail since it's not a valid `Address` object.
			$this->expectException();
			$this->_object->setFrom(new Object);
		}

		/**
		 * Tests the `setHtmlBody` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testSetHtmlBody() {
			$this->assertIdentical($this->_object->getHtmlBody(), '');

			// Make sure the setting was successful.
			$this->_object->setHtmlBody('Test');
			$this->assertIdentical(
				$this->_object->getHtmlBody(),
				'Test'
			);

			// We only allow strings to be passed in.
			$this->expectException();
			$this->_object->setHtmlBody(new Object);
		}

		/**
		 * Tests the `setTextBody` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testSetTextBody() {
			$this->assertIdentical($this->_object->getTextBody(), '');

			// Make sure the setting was successful.
			$this->_object->setTextBody('Test');
			$this->assertIdentical(
				$this->_object->getTextBody(),
				'Test'
			);

			// We only allow strings to be passed in.
			$this->expectException();
			$this->_object->setTextBody(new Object);
		}

		/**
		 * Tests the `setSubject` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testSetSubject() {
			$this->assertIdentical($this->_object->getSubject(), '');

			// Make sure the setting was successful.
			$this->_object->setSubject('Test');
			$this->assertIdentical(
				$this->_object->getSubject(),
				'Test'
			);

			// We only allow strings to be passed in.
			$this->expectException();
			$this->_object->setSubject(new Object);
		}

		/**
		 * Tests the `clearRecipients` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testClearRecipients() {
			$this->assertIdentical($this->_object->getRecipients(), array());

			// Add a recipient and confirm we have one added.
			$this->_object->addRecipient('test@test.com');
			$this->assertIdentical(count($this->_object->getRecipients()), 1);

			// Clear the recipients and confirm it's gone.
			$this->_object->clearRecipients();
			$this->assertIdentical(count($this->_object->getRecipients()), 0);
		}

		/**
		 * Tests the `clearAttachments` method.
		 *
		 * @return void
		 * @access public
		 */
		public function testClearAttachments() {
			$this->assertIdentical($this->_object->getAttachments(), array());

			// Add an attachment and confirm we have one added.
			$this->_object->addAttachment('string');
			$this->assertIdentical(count($this->_object->getAttachments()), 1);

			// Clear the attachments and confirm it's gone.
			$this->_object->clearAttachments();
			$this->assertIdentical(count($this->_object->getAttachments()), 0);
		}

	}