<?php

if (!$_POST['email']) {
    die("Erro: E-mail não informado.");
}

require './phpmailer/PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 2;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "smtp.sendgrid.net";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 587;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "wowlifemail";
//Password to use for SMTP authentication
$mail->Password = "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";
//Set who the message is to be sent from
$mail->setFrom('noreply@wowlife.com.br', 'wowlife');
//Set an alternative reply-to address
$mail->addReplyTo('noreply@wowlife.com.br', 'wowlife');
//Set who the message is to be sent to
$mail->addAddress('bcgonca@gmail.com');
//Set the subject line
$mail->Subject = 'PHPMailer SMTP test';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML('This is a plain-text message body');
//Replace the plain text body with one created manually
$mail->AltBody = 'This is a plain-text message body';
//Attach an image file
// $mail->addAttachment('images/phpmailer_mini.png');

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}
