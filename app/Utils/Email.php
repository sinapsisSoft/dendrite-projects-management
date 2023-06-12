<?php

namespace App\Utils;

use App\Models\EmailModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Email
{

    private $emailModel;
    private $mail;

    public function __construct()
    {
        $this->emailModel = new EmailModel();
        $this->mail = new PHPMailer(true);
    }

    public function sendEmail($data, $email)
    {
        $emailSetting = $this->emailModel->findAll()[0];
        try {
            $this->mail->SMTPDebug = 0;                                                     // Enable verbose debug output
            $this->mail->isSMTP();
            $this->mail->Host  = $emailSetting["Email_host"];
            $this->mail->SMTPAuth   = true;                                                 // Enable SMTP authentication
            $this->mail->Username   = $emailSetting["Email_user"];         // SMTP username
            $this->mail->Password   = $emailSetting["Email_pass"];
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;                        // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
            $this->mail->Port       = $emailSetting["Email_puerto"];
            $this->mail->setFrom($emailSetting["Email_user"], 'Market Support');
            $this->mail->addAddress($email);
            $this->mail->Subject = $data["subject"];
            $this->mail->Body = $data["message"];
            $this->mail->CharSet = 'utf-8';
            $this->mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$this->mail->ErrorInfo}";
        }
    }
}
