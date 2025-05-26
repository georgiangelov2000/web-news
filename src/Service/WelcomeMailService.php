<?php

namespace App\Service;
use App\Service\MailService;
/**
 * WelcomeMailService
 *
 * Handles sending welcome emails to newly registered users.
 */
class WelcomeMailService
{
    protected MailService $mailService;

    public function __construct(MailService $mailService = null)
    {
        $this->mailService = $mailService ?: new MailService();
    }

    /**
     * Send a welcome email to a newly registered user.
     *
     * @param string $to Recipient email
     * @param string $username Username (for greeting)
     * @param array $custom Optional: ['subject' => ..., 'html' => ..., 'text' => ...]
     * @return bool
     */
    public function sendWelcome(string $to, string $username, array $custom = []): bool
    {
        $subject = $custom['subject'] ?? "Welcome to My App, $username!";
        $htmlBody = $custom['html'] ?? $this->defaultHtml($username);
        $textBody = $custom['text'] ?? $this->defaultText($username);

        return $this->mailService->send($to, $subject, $htmlBody, $textBody);
    }

    protected function defaultHtml(string $username): string
    {
        return "
            <div style='font-family:sans-serif;max-width:500px;margin:auto;background:#fff8dc;border-radius:12px;padding:32px 28px 22px 28px;border:1px solid #ffe484;box-shadow:0 2px 10px #ffe48433;'>
                <h2 style='color:#213460'>Welcome, $username!</h2>
                <p style='font-size:1.07rem;color:#213460'>
                    Thank you for registering at <b>My App</b>.<br><br>
                    We're delighted to have you join our community.<br>
                    <a href='https://your-app-url/login' style='background:#ffd814;color:#213460;font-weight:600;padding:8px 16px;border-radius:24px;text-decoration:none;display:inline-block;margin-top:18px;'>Log in now</a>
                </p>
                <hr style='margin:24px 0 12px 0;border-top:1.5px solid #ffd814;'>
                <p style='font-size:13px;color:#a9a9a9;margin:0'>If you did not register, please ignore this email.</p>
            </div>
        ";
    }

    protected function defaultText(string $username): string
    {
        return
            "Welcome, $username!\n\n"
            . "Thank you for registering at My App.\n"
            . "We're delighted to have you join our community.\n"
            . "Log in at: https://your-app-url/login\n\n"
            . "If you did not register, please ignore this email.";
    }
}