<?php

namespace App\Repository;

class BaseRepository
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;

    }

    public function find($idetifier)
    {
        if (is_numeric($idetifier)) {
            return $this->model::findByIdOrAlias($idetifier);
        }
        if (is_string($idetifier)) {
            return $this->model::findByIdOrAlias($idetifier);
        }
    }
    public function paginate(int $page = 1, int $perPage = 10, array $filters = []): array
    {
        return $this->model::paginate($page, $perPage, $filters);
    }
    public function create(array $data) 
    {
        return $this->model::create($data);
    }
    public function update($id, array $data): bool
    {
        return $this->model::update($id, $data);
    }
    public function delete($id): bool
    {
        return $this->model::delete($id);
    }
}