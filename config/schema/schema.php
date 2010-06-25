<?php 
class schemaSchema extends CakeSchema {
	var $name = 'schema';

	function before($event = array()) {
		return true;
	}

	function after($event = array()) {
	}

	var $email_message_recipient_attachments = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'email_message_recipient_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'file' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
		'type' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'name' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 100),
		'indexes' => array(),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $email_message_recipient_variables = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'email_message_recipient_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'key' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
		'value' => array('type' => 'text', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $email_message_recipients = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'email_message_id' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 36),
		'recipient' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
		'tries' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'processed' => array('type' => 'boolean', 'null' => true, 'default' => '0'),
		'priority' => array('type' => 'string', 'null' => true, 'default' => '0', 'lenghth' => 3),
		'modified' => array('type' => 'timestamp', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'timestamp', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
	var $email_messages = array(
		'id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'primary'),
		'layout' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
		'template' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
		'from' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
		'subject' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 150),
		'created' => array('type' => 'timestamp', 'null' => false, 'default' => 'CURRENT_TIMESTAMP'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_unicode_ci', 'engine' => 'MyISAM')
	);
}