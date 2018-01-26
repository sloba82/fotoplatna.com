<?php


require 'PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;

//Tell PHPMailer to use SMTP
$mail->isSMTP();

$mail->Host = 'smtp.gmail.com';
// use
$mail->Port = 465;

$mail->Username = "dizajnistampa@gmail.com";

//Password to use for SMTP authentication
$mail->Password = "82slobadragana";

//Set who the message is to be sent from
$mail->setFrom('dizajnistampa@gmail.com' );

//Set an alternative reply-to address
$mail->addReplyTo('dizajnistampa@gmail.com') ;

//Set who the message is to be sent to
$mail->addAddress('dizajnistampa@gmail.com' );

//Set the subject line
$mail->Subject = 'test';



$mail->Messagebody = "neto";



$mail->send();

if($mail->send()) {

	echo "is not send";
}

 