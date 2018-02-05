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
$urlprezent = strtok($urlprezent, '?');

if (  $_POST['name'] != '' ){

    getPostAndSendMail();
    header('Location: '.$urlprezent.'?message=susses');

}else {
    header('Location: '.$urlprezent.'?message=no_susses');
    die();
}
 
    function getPostAndSendMail(){   

        $message;
        foreach($_POST as $key => $value) {
            if ($value == '') {
                $value = "NODATA";
            }
            $message .= $key.": "." ".$value."<br>";
        }
         $img = $_FILES['fileToUpload']['name'];

            // name for image
            $name = trim($_POST['name']);
            $name = str_replace(' ', '_', $name);
            $name .= time();
         
            $imgname = imgupload($img, $name);
            if (sendMail($message, $imgname)) {
                deletefile($imgname);
            }
    }        

    function imgupload($img, $name){
        $info = pathinfo($img);
        $ext = $info['extension']; // get the extension of the file
        $newname = $name .".". $ext;

        $target = '../upload/' . $newname;
        move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $target);

        return $newname;
      
    }

    function deletefile($imgname){
         
        sleep(2);

        $path = '../upload/'.$imgname;
        if(file_exists($path) && is_readable($path)) {
            unlink($path);
        }
 
    }

    function sendMail($message, $imgname ){

        $mail = new PHPMailer;
         $mail->isSMTP();

        $mail->SMTPDebug = 0; //Enable SMTP debugging, 0 = off (for production use), 1 = client messages, 2 = client and server messages
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
        $mail->addAddress('dizajnistampa@gmail.com', 'print');
        $mail->Subject = 'Fotoplatna poruka';
        $mail->msgHTML($message);
        $mail->Body = $message;
        $atacment = '../upload/'. $imgname;
        $mail->addAttachment($atacment);

        if (!$mail->send()) {
            return 9;
        } else {
            return 1;

        }

    }




      
