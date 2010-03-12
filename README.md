# Mailer Plugin for CakePHP 1.3+

Mailer provides batch processing for sending emails through a variety of transports and utilizing CakePHP views and elements.

## Installation

* Checkout the code
        $ cd /application/app/plugins && git clone git://github.com/joebeeson/mailer.git
* Create the database schema
        $ cake schema create Mailer.schema
* Load the component into AppController
        public $components = array('Mailer.Queue');
* Create the view folders to hold your templates and layouts
        mkdir -p /application/app/views/email/{html,text,layouts/{html,text}}

## Usage

* Create a new message
        $message_id = $this->Queue->createMessage('automated@website.com', 'Welcome to our website!', 'welcome');
        $recipient_id = $this->Queue->addRecipient($message_id, 'you@website.com');
        $this->Queue->addVariable($recipient_id, 'User', $user);

The first command, createMessage() takes the "from" email, the "subject" and then finally the "template" to use for rendering. In this example we're using the "welcome" template and the layout will default to "default" just like Cake. Our files should be located /application/app/views/email/html/welcome.ctp and /application/app/views/email/text/welcome.ctp. This command returns the ID of the new message.

We then add a recipient, you@website.com to the ID of the newly created message. This command will return the ID of the recipient. This can be used to attach variables and files to the email.

Finally we add a variable to the recipient's email called User and with the value from $user. This will appear in the template just like Cake normally handles variables.