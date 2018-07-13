<?php
$isValidated = false;
$validation = '';
$validationClass = '';

$name = '';
$email = '';
$message = '';
$toEmail = 'brandnpatterson@gmail.com';

function cleanPost($arg)
{
    return htmlspecialchars($_POST[$arg]);
}

if (filter_has_var(INPUT_POST, 'submit')) {
    $name = cleanPost('name');
    $email = cleanPost('email');
    $message = cleanPost('message');

    if (!empty($name) && !empty($name) && !empty($message)) {
        if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $isValidated = false;
            $validation = 'Please use a valid email';
            $validationClass = 'alert-danger';
        } else {
            $sendEmail = new \SendGrid\Mail\Mail();
            $sendEmail->setFrom($email, $name);
            $sendEmail->setSubject("Hello from $name");
            $sendEmail->addTo($toEmail, "Brandon Patterson");
            $sendEmail->addContent(
                "text/html", "<p>$message</p>"
            );
            $sendgrid = new \SendGrid(API_KEY);

            try {
                $response = $sendgrid->send($sendEmail);
                $isValidated = true;
                $validation = "Your email has been sent to $toEmail";
                $validationClass = 'alert-success';
            } catch (Exception $e) {
                echo 'Caught exception: ', $e->getMessage(), "\n";

                $isValidated = false;
                $validation = 'Your email was not sent';
                $validationClass = 'alert-danger';
            }
        }
    } else {
        $isValidated = false;
        $validation = 'Please fill out all fields';
        $validationClass = 'alert-danger';
    }
}
