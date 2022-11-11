<?php

declare(strict_types=1);

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class EloquentRepository
{
    protected Model $model;

    public function __construct()
    {
        $this->setModel();
    }

    public function all(array $select = ['*'], array $with = [])
    {
        return $this->model->select($select)->with($with)->get();
    }

    public function get(array $select = ['*'])
    {
        return $this->model->all($select);
    }

    public function find(int $id, array $select = ['*'])
    {
        return $this->model->select($select)->find($id);
    }

    public function findOrFail(int $id, array $select = ['*'])
    {
        return $this->model->select($select)->findOrFail($id);
    }

    public function create(array $data): Model
    {
        return $this->model->create($data);
    }

    public function with($relations): Builder
    {
        return $this->model->with($relations);
    }

    public function update(Model $model, array $request): Model
    {
        $model->update($request);

        return $model;
    }

    public function count()
    {
        return $this->model->count();
    }

    public function paginate(int $take = 0, array $select = ['*'])
    {
        return $this->model->select($select)->paginate($take);
    }

    public function take(int $take, array $select = ['*']): Collection
    {
        return $this->model->select($select)->take($take)->get();
    }

    public function skipAndTake(int $skip, int $take, array $select = ['*']): Collection
    {
        return $this->model
            ->select($select)
            ->skip($skip)
            ->take($take)
            ->get();
    }

    abstract protected function setModel();
}
