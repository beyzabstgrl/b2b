<?php

namespace App\Service;

use App\Repository\BaseRepository;

class BaseService
{
    protected $repository;

    public function __construct(BaseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function all($relations = [])
    {
        return $this->repository->all($relations);
    }

    public function find($id, $relations = [])
    {
        return $this->repository->find($id, $relations);
    }

    public function findBy($field, $value = null)
    {
        if (is_array($field)) {
            return $this->repository->findBy($field);
        } else {
            return $this->repository->findBy($field, $value);
        }
    }

    public function findByIds(array $Ids)
    {
        return $this->repository->findByIds($Ids);
    }

    public function findByRelation($relation, $field, $value)
    {
        return $this->repository->findByRelation($relation, $field, $value);
    }

    public function paginate($count)
    {
        return $this->repository->paginate($count);
    }

    public function store(array $data)
    {

        return $this->repository->store($data);
    }

    public function update($id, array $data)
    {
        return $this->repository->update($id, $data);
    }

    public function delete($id)
    {
        return $this->repository->delete($id);
    }
}
