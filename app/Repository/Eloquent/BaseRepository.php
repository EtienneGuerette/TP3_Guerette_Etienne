<?php

namespace App\Repository\Eloquent;

use App\Repository\RepositoryInterface;
use Illuminate\Database\Eloquent\Model;


class BaseRepository implements RepositoryInterface
{
    protected $model;

    public function __construct($model)
    {
        $this->model = new $model;
    }

    public function getAll(int $perPage = 0)
    {
        if ($perPage > 0) {
            return $this->model->paginate($perPage);
        }

        return $this->model->all();
    }

    public function getById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function delete(int $id)
    {
        $item = $this->model->findOrFail($id);
        $item->delete();
    }

    public function update(int $id, array $content)
    {
        $item = $this->model->findOrFail($id);
        $item->update($content);
        return $item;
    }

    public function getByField(string $field, $description)
    {
        return $this->model->where($field, $description);
    }
}
