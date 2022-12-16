<?php

namespace App;

use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class Mail
{
    protected $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);
        $this->mailer->SMTPDebug = SMTP::DEBUG_OFF;
        $this->mailer->isSMTP();
        $this->mailer->Host       = $_ENV['MAIL_HOST'];
        $this->mailer->SMTPAuth   = $_ENV['MAIL_AUTH'];
        $this->mailer->Port       = $_ENV['MAIL_PORT'];
        $this->mailer->setFrom($_ENV['MAIL_FROM']);
    }

    public function sendMail(
        string $to,
        string $subject,
        string $body
    ) {
        try {
            $this->mailer->isHTML(true);
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $body;
    
            $this->mailer->send();
            Session::sessionMessage('Mail sent', 'success');

        } catch (Exception $e) {
            echo $this->mailer->ErrorInfo;
        }
    }
}
