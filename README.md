# Mailer

A CakePHP 1.3+ plugin for simplifying sending emails.

## Requirements

* CakePHP 1.3
* PHP 5.3+

## Installation

* Clone the plugin repository

        $ cd /path/to/your/app/plugins && git clone git://github.com/joebeeson/mailer.git

* Add the `Postman` component and configure your transports

        public $components = array(
            'Mailer.Postman' => array(
                'Debug',
                'Postmark' => array(
                    'api-key' => 'super-dooper-secret'
                )
            )
        );

## Usage

To begin we have to create an `Email` object. This object will hold all the various information, recipients, content and attachments that are pertinent to the email being sent.

	$email = $this->Postman->create('from-address@example.com', 'Email subject');

Now we can begin attaching various pieces of information to the email object.

	// Lets add some recipients...
	$email->addRecipient('foo@example.com');
	$email->addRecipient('bar@example.com', 'cc');
	$email->addRecipient('baz@example.com', 'bcc');

	// Now maybe some files
	$email->addAttachment('/tmp/report.xls', 'BigReport.xls');
	$email->addAttachment('/tmp/summary.doc', 'Summary.doc');

	// Finally, our email's body
	$email->setTextBody('Hey there guys, check out this report!');
	$email->setHtmlBody('<strong>HI!</strong>. Reports inside.');

At this point our `Email` object should be all set and we should hand the object off for sending. We will receive a boolean response to indicate success.

	if ($this->Postman->send($email)) {
		echo 'Success!';
	} else {
		echo 'Ruh-roh.';
	}

## Transports

The plugin provides a way to define multiple mechanisms, or "transports", which handle the specifics of sending a message; the creation and interface for sending an email is always the same while the code that handles the actual communication varies depending on the application's configuration.

In our `Installation` section we're configuring two transports: `Debug` and `Postmark`. Any settings that should be passed along to the transport should be provided in an associative array keyed off the transport name. You can see that the `Postmark` transport requires an `api-key` setting. Required or optional settings will vary by the transport.

By default the plugin will use the last defined transport for sending emails unless you tell it otherwise. If we wanted switch and use our `Debug` transport, we would do the following

	$this->Postman->setTransport('Debug');

If you need to dynamically add transports during runtime you can do so with `addTransport` which will also set the supplied transport as the current, primary method for mailing.

	$this->Postman->addTransport('Postmark', array('api-key' => 'secret!'));

### Debug

The `Debug` transport is really meant to, well, debug your emails. It will write a file containing the `Email` object to a folder of your choosing (_defaults to your `tmp` folder_) so that you may review it.

#### Configuration

* **folder** _optional_ string

### Postmark

The `Postmark` transport communicates with [Postmark](http://postmarkapp.com/), an online service that facilitates the handling of email.

#### Configuration

* **api-key** string
* **testing** _optional_ boolean

## Advanced

Many of the commands that you can perform against an `Email` object will actually end up returning new objects which help to define their role in the email. You can keep these objects around if you plan to reuse them in later emails; this will help to limit the number of objects you're instantiating.

All transport objects must implement the `\Postman\Interfaces\Transport` interface. If you intend on creating your own custom transport be sure to glance at the interface to figure what methods you'll need to provide. Alternatively you can simply extend from `\Postman\Library\Transport` which will bring in a variety of methods to get your class off the ground.
