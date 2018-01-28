<?php

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 * The IMAP section shows how to save this message to the 'Sent Mail' folder using IMAP commands.
 */

//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');

require '../PHPMailer/PHPMailerAutoload.php';

$urlprezent = $_POST['urlprezent'];

$message = "Ime: ". $_POST['name'] . "<br>";
$message .= "Adresa: ". $_POST['addres'] . "<br>";
$message .= "Grad : ". $_POST['city'] . "<br>";
$message .= "Email : ". $_POST['email'] . "<br>";
$message .= "Phone : ". $_POST['phone'] . "<br>";
$message .= "Dimenzije : ". $_POST['size'] . "<br>";
$message .= "Dimenzije po zahtevu : ". $_POST['sizeOddemond'] . "<br>";
$message .= "Cenu javi sms-om : ". $_POST['priceSms'] . "<br>";
$message .= "Cenu javi Email : ". $_POST['priceMail'] . "<br>";
$message .= "Komentar : ". $_POST['napomena'] . "<br>";

$img = $_FILES['fileToUpload']['name'];

    // name for image
    $name = trim($_POST['name']);
    $name = str_replace(' ', '_', $name);
    $name .= time();




if (isset($_FILES['fileToUpload']['name'])){
    $imgname = imgupload($img, $name, $urlprezent );
    sendMail($message, $urlprezent, $imgname);

} else {
    die();
}





function imgupload ($img, $name, $urlprezent ){
    $info = pathinfo($img);
    $ext = $info['extension']; // get the extension of the file
    $newname = $name .".". $ext;

    $target = '../upload/' . $newname;
    move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);

    if ($ext == 'jpg' || $ext == 'png' || $ext == 'jpeg' || $ext == 'pdf'  ) {
        return $newname;
    }else {
        header('Location: '.$urlprezent);
    }

}





function sendMail($message, $urlprezent, $imgname )
{

    $mail = new PHPMailer;
    $mail->isSMTP();

    $mail->SMTPDebug = 2; //Enable SMTP debugging, 0 = off (for production use), 1 = client messages, 2 = client and server messages
    $mail->Debugoutput = 'html';

    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->SMTPOptions = array(
        'ssl' => array(
            'verify_peer' => false,
            'verify_peer_name' => false,
            'allow_self_signed' => true
        )
    );

    $mail->Username = "dizajnistampa@gmail.com";
    $mail->Password = "82slobadragana";
    $mail->setFrom('dizajnistampa@gmail.com', 'web');

//Set who the message is to be sent to
    $mail->addAddress('dizajnistampa@gmail.com', 'print');

//Set the subject line
    $mail->Subject = 'Fotoplatna poruka';

//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
    $mail->msgHTML($message);


    $mail->Body = $message;

//Attach an image file

    $atacment = '../upload/'. $imgname;

    $mail->addAttachment($atacment);

//send the message, check for errors




    if (!$mail->send()) {
        echo "Message not sent";
    } else {
        echo "Message sent!";

    }

   header('Location: '.$urlprezent);


}

