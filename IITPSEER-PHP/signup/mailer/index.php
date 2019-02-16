<?php

include 'PHPMailer.php';
include 'SMTP.php';

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions

$mail->SMTPDebug = 0;                                 // Enable verbose debug output
$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.gmail.com';                       // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'iitpconnect@gmail.com';            // SMTP username
$mail->Password = 'anurag@iitpconnect';                  // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 587;                                    // TCP port to connect to

//Recipients
$mail->setFrom('noreply@gmail.com', 'iitpConnect');
$mail->addAddress('anuragvns1111@gmail.com', 'Anurag');                     // Add a recipient
$mail->addAddress('anurag@blogme.co');                // Name is optional

//Content
$mail->isHTML(true);                                  // Set email format to HTML
$mail->Subject = 'Subject';
$mail->Body    = 'Body';
$mail->AltBody = 'Thanks';

if($mail->send())
{
  return true;
}
