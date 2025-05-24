<?php

namespace App\Service;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class MailService
{
    protected PHPMailer $mailer;

    public function __construct()
    {
        $this->mailer = new PHPMailer(true);

        $this->mailer->isSMTP();
        $this->mailer->Host       = $_ENV['SMTP_HOST'] ?? 'smtp.gmail.com';
        $this->mailer->SMTPAuth   = true;
        $this->mailer->Username   = $_ENV['SMTP_USER'] ?? '';
        $this->mailer->Password   = $_ENV['SMTP_PASS'] ?? '';
        $this->mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $this->mailer->Port       = $_ENV['SMTP_PORT'] ?? 587;

        $this->mailer->CharSet = 'UTF-8';
        $this->mailer->isHTML(true);
        $this->mailer->setFrom($_ENV['MAIL_FROM'] ?? 'noreply@example.com', $_ENV['MAIL_FROM_NAME'] ?? 'My App');
    }

    public function send(string $to, string $subject, string $htmlBody, string $textBody = ''): bool
    {
        try {
            $this->mailer->clearAddresses();
            $this->mailer->addAddress($to);
            $this->mailer->Subject = $subject;
            $this->mailer->Body    = $htmlBody;
            $this->mailer->AltBody = $textBody ?: strip_tags($htmlBody);
            return $this->mailer->send();
        } catch (Exception $e) {
            error_log('MailService Error: ' . $e->getMessage());
            return false;
        }
    }
}
