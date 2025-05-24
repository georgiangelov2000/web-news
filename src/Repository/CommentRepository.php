<?php

namespace App\Repository;
use \App\Database\Models\Comment;

class CommentRepository
{
    public function getCommentsByUserId($userId)
    {
        // Assuming you have a Comment model that interacts with the database
        return Comment::getCommentsByUserId($userId);
    }
}