<?php

use \SendGrid\Mail\Mail as Mail;

class Mailer
{
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
        return "Hey $this->name! Thank you for emailing me. I'll be in touch with you shortly.";
    }

    public function cleanPost($arg)
    {
        return htmlspecialchars($_POST[$arg]);
    }

    public function emptyForms()
    {
       $json = array('data' => 'Please fill out all fields');
        echo json_encode($arr);
    }

    public function emailInvalid()
    {
       $json = array('data' => 'Please use a valid email');
        echo json_encode($json);
    }

    public function emailFail()
    {
       $json = array('data' => 'Your email was not sent');
        echo json_encode($json);
    }

    public function emailSuccess()
    {
       $json = array('data' => "Your email has been sent to $this->toEmail");
        echo json_encode($json);
    }
}

$mailer = new Mailer;
$mailer->init();
