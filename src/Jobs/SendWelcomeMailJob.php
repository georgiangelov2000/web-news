<?php
namespace App\Jobs;

use App\Contracts\QueueableJob;
use App\Service\WelcomeMailService;

class SendWelcomeMailJob implements QueueableJob
{
    protected string $to;
    protected string $username;
    protected array $custom;

    public function __construct(string $to, string $username, array $custom = [])
    {
        $this->to = $to;
        $this->username = $username;
        $this->custom = $custom;
    }

    public function handle()
    {
        $service = new WelcomeMailService();
        $service->sendWelcome($this->to, $this->username, $this->custom);
    }
}