<?php

namespace App\Repositories\Eloquent;

use App\Repositories\EloquentRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements EloquentRepositoryInterface
{
    public const DEFAULT_PER_PAGE = 10;
    public const MAX_PER_PAGE = 30;

    protected $model;

    /**
     * @param Model $model
     *
     * @return void
     */
    public function setModel(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function all(array $columns = ['*'], array $relationships = [])
    {
        return $this->getModel()->with($relationships)->get($columns);
    }

    public function getById($id, array $columns = ['*'], array $relationships = [])
    {
        return $this->getModel()->select($columns)->with($relationships)->findorFail($id);
    }

    public function firstByWhere(array $wheres = [], array $columns = ['*'], array $relationships = [])
    {
        return $this->getModel()->select($columns)->where($wheres)->with($relationships)->first();
    }

    public function store(array $payload)
    {
        return $this->getModel()->create($payload);
    }

    public function update(Model $model, $data)
    {
        return $model->update($data);
    }

    public function destroy($model)
    {
        return $model->delete();
    }

    public function paginate($wheres, array $paginate = ['page' => 1], array $columns = [], array $withs = [])
    {
        if (!$columns) {
            $columns = ['*'];
        }
        return $this->getModel()
            ->select($columns)
            ->where($wheres)
            ->with($withs)
            ->paginate(min($paginate['per_page'] ?? self::DEFAULT_PER_PAGE, self::MAX_PER_PAGE));
    }

    public function paginate_v2($wheres, $whereIn, $orderBy, array $paginate = ['page' => 1], array $columns = ['*'], array $withs = [])
    {
        return $this->getModel()
            ->select($columns)
            ->where($wheres)
            ->whereIn($whereIn["field"], $whereIn["value"])
            ->with($withs)
            ->orderBy($orderBy["field"], $orderBy["value"])
            ->paginate(min($paginate['per_page'] ?? self::DEFAULT_PER_PAGE, self::MAX_PER_PAGE));
    }

    /**
     * @param int $id
     * @param array $columns
     * @param array $withs
     *
     * @return mixed
     */
    public function first(int $id, array $columns = ['*'], array $withs = [])
    {
        return $this->getModel()->select($columns)->where(['id' => $id])->with($withs)->first();
    }

    /**
     * @param array $condition
     *
     * @return mixed
     */
    public function findBy(array $condition)
    {
        return $this->getModel()->where($condition)->get();
    }

    /**
     * @param array $data
     *
     * @return mixed
     */
    public function storeMany(array $data)
    {
        return $this->getModel()->insert($data);
    }

    /**
     * @param array $params
     * @param array $data
     *
     * @return mixed
     */
    public function updateOrCreate(array $params, array $data)
    {
        return $this->getModel()->updateOrCreate($params, $data);
    }
}
