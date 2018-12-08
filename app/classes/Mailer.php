<?php

use \SendGrid\Mail\Mail as Mail;

class Mailer
{
    public $isValidated = false;
    public $validation = '';
    public $validationClass = '';

    public $name = '';
    public $email = '';
    public $message = '';
    public $serverName = 'Brandon Patterson';
    public $serverEmail = 'brandnpatterson@gmail.com';

    private $alertDanger = 'alert-danger';
    private $alertSuccess = 'alert-success';

    public function init()
    {
        if (filter_has_var(INPUT_POST, 'email')) {
            $this->name = $this->cleanPost('name');
            $this->email = $this->cleanPost('email');
            $this->message = $this->cleanPost('message');

            if (!empty($this->name) && !empty($this->email) && !empty($this->message)) {
                if (filter_var($this->email, FILTER_VALIDATE_EMAIL) === false) {
                    $this->emailInvalid();
                } else {
                    $this->sendEmail($this->email, "Hello from $this->name", $this->serverEmail, $this->message);
                    $this->sendEmail($this->serverEmail, "Thank you from $this->serverName", $this->email, $this->returnMessage());
                }
            } else {
                $this->emptyForms();
            }
        }

    }

    public function sendEmail($fromEmail, $fromName, $toEmail, $message)
    {
        $sendEmail = new Mail();
        $sendEmail->setFrom($fromEmail, $fromName);
        $sendEmail->setSubject($fromName);
        $sendEmail->addTo($toEmail, "Brandon Patterson");
        $sendEmail->addContent(
            "text/html", "<p>$message</p>"
        );
        $sendgrid = new \SendGrid(API_KEY);

        try {
            $sendgrid->send($sendEmail);
            $this->emailSuccess();
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            $this->emailFail();
        }
    }

    public function returnMessage()
    {
        return "Hey $this->name! Thank you for emailing me. I'll be back with you shortly.";
    }

    public function cleanPost($arg)
    {
        return htmlspecialchars($_POST[$arg]);
    }

    public function validate($isValidated, $validation, $validationClass)
    {
        $this->isValidated = $isValidated;
        $this->validation = $validation;
        $this->validationClass = $validationClass;
    }

    public function emptyForms()
    {
        $this->validate(false, 'Please fill out all fields', $this->alertDanger);
    }

    public function emailInvalid()
    {
        $this->validate(false, 'Please use a valid email', $this->alertDanger);
    }

    public function emailFail()
    {
        $this->validate(false, 'Your email was not sent', $this->alertDanger);
    }

    public function emailSuccess()
    {
        $this->validate(true, "Your email has been sent to $this->toEmail", $this->alertSuccess);
    }
}

$mailer = new Mailer;
$mailer->init();
