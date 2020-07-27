<?php

// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendEmail($email, $vendorname, $filename) {
    $ret = false;   

    // Load Composer's autoloader
    require 'vendor/autoload.php';

    $configs = include('config.php');
    $emailServer =  $configs['emailServer'];
    $emailUserid =  $configs['emailUserid'];
    $emailPassword =  $configs['emailPassword'];
    $emailPort =  $configs['emailPort'];

    $vendormsg = "";
    if (isset($_SESSION['vendormessage']))  {     
        $vendormessage = checkData($_SESSION['vendormessage']) ; 
        //explode all separate lines into an array
        $textAr = explode("\n", $vendormessage);      
        foreach($textAr as $line) {
            $vendormsg = $vendormsg . $line . "<br>";
        }     
    }

    // Instantiation and passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                   // Enable verbose debug output
        $mail->isSMTP();                                         // Send using SMTP
        $mail->Host       = $emailServer;                        // Set the SMTP server to send through
    
        $mail->SMTPAuth   = true;                                 // Enable SMTP authentication
        $mail->Username   = $emailUserid;                         // SMTP username
        $mail->Password   = $emailPassword;                       // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;       // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
        //Port: 465 (SSL required) or 587 (TLS required)
        $mail->Port       = $emailPort;                           // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above

        //Recipients
    
        $mail->setFrom($emailUserid, 'Mailer');
        //  $mail->setFrom($emailUserid);
        $mail->addAddress($email);     // Add a recipient
    
        // Attachments
        $mail->addAttachment($filename);  
    
        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Lasku: ' . $vendorname;
        $mail->Body    = 'Laskun viesti: <br>' . $vendormsg;  
        $mail->AltBody = 'Lasku: ';

        $mail->send();
        $ret = true;
        // echo 'Message has been sent';
    }
    catch (Exception $e) {
        $ret = false;
         //  echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        error_log("email.php: Error when sending pdf-invoice by email: " . $e->getMessage(), 0);
         //  error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}", 0);
    }

    // delete a file after sending email
    if (file_exists($filename)) {
        unlink($filename);
        error_log("File deleted after sending by email: " . $filename, 0);     
    }
    
    return $ret;
}

?>