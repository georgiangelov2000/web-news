<?php

namespace App\Repository;

use App\Database\Models\Post;

class PostRepository
{
    public function paginate($page = 1, $perPage = 10, $filters = [])
    {
        return Post::paginate($page, $perPage, $filters);
    }

    public function find($alias)
    {
        return Post::findByIdOrAlias($alias);
    }

    public function findById(int $id)
    {
        return Post::findByIdOrAlias($id);
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

}