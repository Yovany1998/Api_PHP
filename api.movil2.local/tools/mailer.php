<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    use PHPMailer\PHPMailer\SMTP;
    
    require '../../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require '../../vendor/phpmailer/phpmailer/src/Exception.php';
    require '../../vendor/phpmailer/phpmailer/src/SMTP.php';

    function send_email($from, $fromName, $to, $subject, $body){
        global $config;
        $mail = new PHPMailer(true);

        try{
            $mail->CharSet    = 'UTF-8';
            $mail->isSMTP();
            $mail->Host       = $config->smtp->host;
            $mail->SMTPAuth   = true;
            $mail->Username    = $config->smtp->user;
            $mail->Password   = $config->smtp->pass;
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port       = 587;
 
            $mail->setFrom($from, $fromName);
            $mail->addAddress($to);
            $mail->isHTML(true);
            $mail->Body       = $body;
            $mail->send();
            return true;
        }catch(Exception $e){
            print_r($e);
            die();
        }

    }
?>