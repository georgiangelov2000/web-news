<?php

namespace App\Service;

class BaseService
{
    protected $repository;

    public function __construct($repository)
    {
        $this->repository = $repository;
    }

    /**
     * Get paginated model with optional search filter
     */
    public function paginate($page, $perPage, $filters = [])
    {
        return $this->repository->paginate($page, $perPage, $filters);
    }

    /**
     * Get a single model by id OR alias
     */
    public function find($identifier)
    {
        return $this->repository->find($identifier);
    }

    /**
     * Create a new model instance
     */
    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    /**
     * Update an existing model instance
     */
    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }
    
    /**
     * Delete a model instance by id
     */
    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}