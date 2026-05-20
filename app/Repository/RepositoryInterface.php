<?php

namespace App\Repository;


interface RepositoryInterface
{
    public function getAll(int $perPage = 0);
    public function getById(int $id);
    public function create(array $attributes);
    public function delete(int $id);
    public function update(int $id, array $content);
    public function getByField(string $field, $description);
}