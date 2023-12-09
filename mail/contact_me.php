<?php
session_start();

// check captcha before
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_captcha = $_POST['captcha'];

    if ($user_captcha == $_SESSION["captcha"]) {
        // Check for empty fields
        if (empty($_POST['name']) ||
            empty($_POST['email']) ||
            empty($_POST['ville']) ||
            empty($_POST['phone']) ||
            empty($_POST['message']) ||
            !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            echo "No arguments Provided!";
            return false;
        }

        $name = $_POST['name'];
        $email_address = $_POST['email'];
        $phone = $_POST['phone'];
        $message = $_POST['message'];
        $ville = $_POST['ville'];

// Create the email and send the message
        $to = 'webmaster@luziparc.fr'; // Add your email address inbetween the '' replacing yourname@yourdomain.com - This is where the form will send a message to.
        $email_subject = "Information Luziparc Contact Form:  $name";
        $email_body = "You have received a new message from your website contact form.\n\n" . "Here are the details:\n\nName: $name\n\nEmail: $email_address\n\nPhone: $phone\n\nVille: $ville\n\nMessage:\n$message";
        $headers = "From: contact@luziparc.fr" . "\r\n"; // This is the email address the generated message will be from. We recommend using something like noreply@yourdomain.com.
        $headers .= "Reply-To: $email_address" . "\r\n";
        $headers .= "To: $to" . "\r\n";
        echo $headers;
        ini_set('sendmail_from', 'contact@luziparc.fr');
        mail($to, $email_subject, $email_body, $headers);
        header('Location: ../thankyou.html');
        return true;
    } else {
        header('Location: ../captcha_error.html');
        return false;
    }
}
