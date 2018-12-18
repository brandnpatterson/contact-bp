<?php
$root = $_SERVER['DOCUMENT_ROOT'];

require $root . '/vendor/autoload.php';
require $root . '/conf/conf.php';

use \SendGrid\Mail\Mail as Mail;

class Mailer
{
    public $name = '';
    public $email = '';
    public $message = '';
    public $serverName = 'Brandon Patterson';
    public $serverEmail = 'brandnpatterson@gmail.com';

    public function init()
    {
        if (filter_has_var(INPUT_POST, 'email')) {
            $this->cleanInputs();

            if (!empty($this->name) && !empty($this->email) && !empty($this->message)) {
                if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
                    $this->emailInvalid();
                } else {
                    $this->sendEmail();
                    $this->returnEmail();
                }
            } else {
                $this->invalidForm();
            }
        }
    }

    public function cleanInputs()
    {
        $this->name = $this->cleanPost('name');
        $this->email = $this->cleanPost('email');
        $this->message = $this->cleanPost('message');
    }

    public function sendEmail()
    {
        $email = new Mail();
        $email->setFrom($this->email, $this->name);
        $email->setSubject("Hello from $this->name");
        $email->addTo($this->serverEmail, "Brandon Patterson");
        $email->addContent(
            "text/html", "<p>$this->message</p>"
        );

        $sendgrid = new \SendGrid(API_KEY);

        try {
            $sendgrid->send($email);
            $this->emailSuccess();
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            $this->emailFail();
        }
    }

    public function returnEmail()
    {
        $email = new Mail();
        $email->setFrom($this->serverEmail, $this->serverName);
        $email->setSubject("Thank you from $this->serverName");
        $email->addTo($this->email, "Brandon Patterson");
        $email->addContent(
            "text/html", '<p>' . $this->returnMessage() . '</p>'
        );

        $sendgrid = new \SendGrid(API_KEY);

        try {
            $sendgrid->send($email);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    public function returnMessage()
    {
        return "Hey $this->name! Thank you for emailing me. I'll be in touch with you shortly.";
    }

    public function cleanPost($arg)
    {
        return htmlspecialchars($_POST[$arg]);
    }

    public function invalidForm()
    {
        $msg = 'Please fill out all fields';
        $this->jsonResponse($msg);
    }

    public function emailInvalid()
    {
        $msg = 'Please use a valid email';
        $this->jsonResponse($msg);
    }

    public function emailFail()
    {
        $msg = 'Your email was not sent. Please try again';
        $this->jsonResponse($msg);
    }

    public function emailSuccess()
    {
        $msg = 'Your Email was sent successfully!';
        $this->jsonResponse($msg);
    }

    public function jsonResponse($message)
    {
        header("Content-Type: application/json");

        $array = array('message' =>  $message);

        echo json_encode($array);
    }
}
$mailer = new Mailer;
$mailer->init();
