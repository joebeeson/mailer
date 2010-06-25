# Mailer Plugin for CakePHP 1.3+

Mailer plugin simplifies sending emails from a CakePHP application.


## Features
 * Uses CakePHP's View engine and helpers
 * Automatic throttling
 * Easy attachment support
 * Prioritize emails
 * Automatic retry on mailing failure
 * Interchangable transport libraries
   * PEAR::Mailer
   * <strike>Swiftmailer</strike> (<em>coming soon</em>)
   * Debug

## Usage
        $message_id = $this->Queue->createMessage('Welcome to Website.com!', 'noreply@website.com', 'welcome');
        $this->Queue->addRecipient($message_id, 'you@email.com');

## Installation

* Download the plugin

        $ cd /path/to/your/app/plugins && git clone git://github.com/joebeeson/mailer.git

* Create the tables

        $ cake schema create Mailer.schema

* Add the component

        public $components = array('Mailer.Queue');

* Configure your preferred transport

        TODO

