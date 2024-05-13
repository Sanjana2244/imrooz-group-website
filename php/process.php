<?php
// Configure your Subject Prefix and Recipient here
$subjectPrefix = '[Contact via website]';
$emailTo       = '<noreply.imrooz@gmail.com>';

$errors = array(); // array to hold validation errors
$data   = array(); // array to pass back data

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = "arsalan" ;//stripslashes(trim($_POST['con_name']));
    // $name    = stripslashes(trim($_POST['con_name']));
    
    $email   = 'arsalan252@gmail.com'; //stripslashes(trim($_POST['email']));
    $subject = 'Hello world';//stripslashes(trim($_POST['subject']));
    $message = 'checking'; //stripslashes(trim($_POST['message']));




    // if there are any errors in our errors array, return a success boolean or false
    if (!empty($errors)) {
        $data['success'] = false;
        $data['errors']  = $errors;
    } else {
        $subject = "$subjectPrefix $subject";
        $body    = '
            <strong>Name: </strong>'.$name.'<br />
            <strong>Email: </strong>'.$email.'<br />
            <strong>Message: </strong>'.nl2br($message).'<br />
        ';

        $headers  = "MIME-Version: 1.1" . PHP_EOL;
        $headers .= "Content-type: text/html; charset=utf-8" . PHP_EOL;
        $headers .= "Content-Transfer-Encoding: 8bit" . PHP_EOL;
        $headers .= "Date: " . date('r', $_SERVER['REQUEST_TIME']) . PHP_EOL;
        $headers .= "Message-ID: <" . $_SERVER['REQUEST_TIME'] . md5($_SERVER['REQUEST_TIME']) . '@' . $_SERVER['SERVER_NAME'] . '>' . PHP_EOL;
        $headers .= "From: " . "=?UTF-8?B?".base64_encode($name)."?=" . "<$email>" . PHP_EOL;
        $headers .= "Return-Path: $emailTo" . PHP_EOL;
        $headers .= "Reply-To: $email" . PHP_EOL;
        $headers .= "X-Mailer: PHP/". phpversion() . PHP_EOL;
        $headers .= "X-Originating-IP: " . $_SERVER['SERVER_ADDR'] . PHP_EOL;

        mail($emailTo, "=?utf-8?B?" . base64_encode($subject) . "?=", $body, $headers);

        $data['success'] = true;
        $data['message'] = 'Thank You. Your message has been sent successfully';
    }

    // return all our data to an AJAX call
    echo json_encode($data);
}


require 'phpmailer/PHPMailerAutoload.php';



//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug =0;
//Ask for HTML-friendly debug output
$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = "smtp.gmail.com";
//Set the SMTP port number - likely to be 25, 465 or 587
$mail->Port = 25;
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication
$mail->Username = "noreply.imrooz@gmail.com";
//Password to use for SMTP authentication
$mail->Password = "imrooz@123";
//Set who the message is to be sent from
$mail->setFrom('noreply.imrooz@gmail.com', 'First Imrooz Modaraba');
//Set an alternative reply-to address
$mail->addReplyTo('noreply.imrooz@gmail.com', 'First Imrooz Modaraba');
//Set who the message is to be sent to
$mail->addAddress('noreply.imrooz@gmail.com', 'First Imrooz Modaraba');
$mail->addCC('inquiries@imrooz.com');
$mail->addBCC('khizer@imrooz.com', 'shabbir.jamsa@imrooz.com','kashif.fazlani@imrooz.com');
//Set the subject line
$mail->Subject = 'First Imrooz Modaraba';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
$mail->msgHTML($body);
//Replace the plain text body with one created manually
$mail->AltBody = strip_tags($body);
$mail->send();

