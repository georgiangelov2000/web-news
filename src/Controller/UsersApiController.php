<?php

namespace App\Controller;

use App\Model\User;
use App\View\ViewRenderer;

class UsersApiController
{
    public function show($id)
    {
        $user = User::find($id);
        if (!$user) {
            http_response_code(404);
            echo "User not found";
            return;
        }
        header('Content-Type: application/json');
        echo json_encode($user);
    }
}