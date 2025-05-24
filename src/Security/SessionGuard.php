<?php
namespace App\Security;

use App\Session\Session;

class SessionGuard
{
    protected $session;
    protected $regenInterval = 10;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    public function enforce()
    {
        // Prevent session hijacking by checking user agent and IP
        if (!$this->session->get('user_agent')) {
            $this->session->set('user_agent', $_SERVER['HTTP_USER_AGENT'] ?? '');
            $this->session->set('ip', $_SERVER['REMOTE_ADDR'] ?? '');
        } else {
            if (
                $this->session->get('user_agent') !== ($_SERVER['HTTP_USER_AGENT'] ?? '') ||
                $this->session->get('ip') !== ($_SERVER['REMOTE_ADDR'] ?? '')
            ) {
                $this->session->destroy();
                header('Location: /login');
                exit;
            }
        }

        // Regenerate session ID periodically
        $counter = $this->session->get('counter', 0) + 1;
        $this->session->set('counter', $counter);
        if ($counter % $this->regenInterval === 0) {
            $this->session->regenerate();
        }
    }
}