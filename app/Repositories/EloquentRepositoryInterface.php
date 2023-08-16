<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

interface EloquentRepositoryInterface
{
    public function setModel(Model $model);

    public function getModel();

    public function all(array $columns = ['*'], array $relationships = []);

    public function getById(int $id, array $columns = ['*'], array $relationships = []);

    public function firstByWhere(array $wheres = ['*'], array $columns = [], array $relationships = []);

    public function store(array $payload);

    public function update(Model $model, $data);

    public function destroy(Model $model);

    //new function

    public function paginate($wheres, array $paginate = [], array $columns = [], array $withs = []);

    public function paginate_v2($wheres, $whereIn, $orderBy, array $paginate = ['page' => 1], array $columns = ['*'], array $withs = []);

    public function first(int $id, array $columns = ['*'], array $withs = []);

    public function findBy(array $condition);

    public function storeMany(array $data);

    public function updateOrCreate(array $params, array $data);

}
