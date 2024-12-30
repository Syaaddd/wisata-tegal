<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


if (!function_exists('sendMail')) {
    function sendMail($mailconfig){
        require 'path/to/PHPMailer/src/Exception.php';
        require 'path/to/PHPMailer/src/PHPMailer.php';
        require 'path/to/PHPMailer/src/SMTP.php';

        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->SMTPDebug = 0;
        $mail->Host = env('EMAIL_HOST');
        $mail->SMTPAuth = true;
        $mail->Username = env('EMAIL_USERNAME');
        $mail->Password = env('EMAIL_PASSWORD');
        $mail->SMTPSecure = env('EMAIL_ENCRYPTION');
        $mail->Port = env('EMAIL_PORT');
        $mail->setFrom($emailconfig['mail_from_email'], $emailconfig['mail_from_name']);
        $mail->addAddress($emailconfig['mail_receiver_email'], $emailconfig['mail_receiver_name']);
        $mail->isHTML(true);
        $mail->Subject = $emailconfig['mail_subject'];
        $mail->Body = $emailconfig['mail_body'];
        if ($mail->send()) {
            return true;
        } else {
            return false;
        }
    }
}