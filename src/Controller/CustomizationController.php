<?php

namespace App\Controller;

use App\Database\Models\Comment;
use App\Service\PostService;
use App\Repository\PostRepository;
use App\Session\Session;
use App\Security\SessionGuard;

class CustomizationController extends ApiController {

    public function __construct() {
        parent::__construct();
    }

    public function getPricingPage() {
        // Render the pricing page template
        return $this->view->render('pricing', []);
    }
}