<?php

namespace App\Repository;

use Illuminate\Database\Eloquent\Collection;

class BaseRepository
{
    protected $modelName;

    public function getNewInstance()
    {
        $model = $this->modelName;

        return new $model;
    }

    public function all($relations = [])
    {
        $instance = $this->getNewInstance();

        return $instance->with($relations)->get();
    }

    public function find($id, $relations = [])
    {
        $instance = $this->getNewInstance();

        return $instance->with($relations)->find($id);
    }

    public function paginate($count)
    {
        $instance = $this->getNewInstance();

        return $instance->paginate($count);
    }

    public function store($data)
    {

        $instance = $this->getNewInstance();
        $instance->fill($data);

        $instance->save();

        return $instance;
    }

    public function update($id, $data)
    {
        $instance = $this->find($id);
        $instance->fill($data);
        $instance->save();

        return $instance;
    }

    public function findBy($fields, $value = null)
    {
        $instance = $this->getNewInstance();

        if (is_array($fields)) {
            foreach ($fields as $field => $value) {
                $instance = $instance->where($field, $value);
            }
        } else {
            $instance = $instance->where($fields, $value);
        }

        return $instance->get();
    }

    public function findByIds(array $ids)
    {
        $instance = $this->getNewInstance();

        return $instance->whereIn('id', $ids)->get();
    }

    public function findByRelation($relation, $field, $value)
    {
        $instance = $this->getNewInstance();

        return $instance->whereHas($relation, function ($query) use ($field, $value) {
            $query->where($field, $value);
        })->get();
    }

    public function onlyFields(Collection $collection, $fields = [])
    {
        return $collection->transform(function ($item, $key) use ($fields) {
            return $item->only($fields);
        });
    }

    public function delete($id): bool
    {

        $instance = $this->getNewInstance()
            ->withTrashed()
            ->find($id);

        if (! $instance) {
            return false;
        }

        if ($instance->trashed()) {
            return true;
        }

        $instance->delete();

        return true;
    }
}
