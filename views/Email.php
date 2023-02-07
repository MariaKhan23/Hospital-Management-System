<?php

namespace Pro;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class Emailing
{
    public function SendEmail($to, $subject, $description)
    {
        try {
            $mail = new PHPMailer(true);

            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'probilal643@gmail.com';
            $mail->Password = 'mejqjkbehwzbiuuc';
            $mail->isHTML(true);
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;

            $mail->setFrom('probilal643@gmail.com');
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $description;

            if ($mail->send()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}
