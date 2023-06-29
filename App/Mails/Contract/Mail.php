<?php

namespace App\Mails\contract;
// search for outlook config
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

abstract class Mail
{
    protected const MAIL_FROM = 'ahmedessamata777@outlook.com';
    private const MAIL_PASSWORD = 'Ahmed1152000';
    private const MAIL_HOST = 'smtp-mail.outlook.com';
    private const MAIL_PORT = 587;
    protected PHPMailer $mail;
    public function __construct()
    {
        $this->mail = new PHPMailer(true);
        $this->mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = self::MAIL_HOST;                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $this->mail->Username   = self::MAIL_FROM;                     //SMTP username
        $this->mail->Password   = self::MAIL_PASSWORD;                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $this->mail->Port       = self::MAIL_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
    }
    public abstract function send(string $mailTo, string $subject, string $body): bool;
}
