<?php

namespace App\Repositories;

use App\Helpers\FilterHandler;
use App\Helpers\FilterHandlerV2;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

abstract class AbstractRepository
{
    protected Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(?int $paginate, ?array $filterParams, ?array $orderByParams, $relationships = [])
    {
        return $this->buildQuery($paginate, $filterParams, $orderByParams, $relationships, null);
    }

    protected function buildQuery($paginate = null, $filterParams = null, $orderByParams = null, $relationships = [], $count = null, $withTrashed = false)
    {
        $query = $this->model->query();

        if (in_array(SoftDeletes::class, class_uses($this->model))) {
            if ($withTrashed == true) {
                $query = $query->withTrashed();
            }
        }

        if (!empty($relationships)) {
            $query = $query->with($relationships);
        }

        $query = $this->applyFilter($query, $filterParams);
        $query = $this->applyOrder($query, $orderByParams);

        return $this->paginateQuery($query, $paginate, $filterParams, $count);
    }

    protected function applyFilter($query, $filterParams)
    {
        if (isset($filterParams)) {
            $filterHandler = new FilterHandler;
            $filterHandlerV2 = new FilterHandlerV2;

            $version = $this->getVersionFilter($filterParams);
            if ($version === 1) {
                return $filterHandler->applyFilter($query, $filterParams);
            }

            return $filterHandlerV2->applyFilter($query, $filterParams);
        }

        return $query;
    }

    protected function applyOrder($query, $orderByParams)
    {
        if (isset($orderByParams)) {
            $filterHandler = new FilterHandler;
            return $filterHandler->applyOrder($query, $orderByParams);
        }

        return $query;
    }

    protected function paginateQuery($query, $paginate = null, $filterParams = null, $count = null)
    {
        if (!isset($paginate)) {
            return $query->take(100)->get();
        }

        $pagedData = $query->paginate($paginate);
        $data = collect();

        $this->addCountToData($data, $count);
        $data = $this->addFixedConditionToData($data, $filterParams);

        return $data->isNotEmpty() ? $data->merge($pagedData) : $pagedData;
    }

    protected function addCountToData($data, $count)
    {
        if (isset($count)) {
            $data->put('count', $count);
        }
    }

    protected function addFixedConditionToData($data, $filterParams)
    {
        $fixedCondition = $this->getFixedCondition($filterParams);

        if ($fixedCondition) {
            $key = $this->model::firstWhere($fixedCondition)?->getKey();
            $fixedData = collect(['fixed' => $key ? $this->show($key) : null]);
            return $data->merge($fixedData);
        }
        return $data;
    }

    public function getVersionFilter(?array $filterParams)
    {
        $firstKey = array_key_first($filterParams);
        return is_int($firstKey) ? 2 : 1;
    }

    /**
     * Get condition to find fixed register
     */
    protected function getFixedCondition(?array $filters): ?array
    {
        if (empty($filters)) return null;

        foreach ($filters as $key => $filter) {
            if (isset($filter['filterType']) && $filter['filterType'] === 'FIXED') {
                return [mb_strtolower($key) => $filter['filterValue']];
            }
        }

        return null;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    /**
     * Store a new resource or update an existing one.
     *
     * @param array $attributes Attributes to find the record.
     * @param array $values Values to update or create.
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function storeOrUpdate(array $attributes, array $values = [])
    {
        return $this->model->updateOrCreate($attributes, $values);
    }

    /**
     * Display the specified resource.
     */
    public function show(int|string $id, array $relationships = [])
    {
        $query = $this->model->query();

        if (!empty($relationships)) {
            $query = $query->with($relationships);
        }

        return $query->findOrFail($id);
    }

    /**
     * Display the first resource.
     */
    public function first()
    {
        return $this->model->first();
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(array $data, int $id)
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);

        return $model;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $model = $this->model->findOrFail($id);
        $model->delete();
    }

    /**
     * Restore the specified resource from storage.
     */
    public function restore(int $id)
    {
        $model = $this->model->withTrashed()->findOrFail($id);
        $model->restore();

        return $model;
    }

    /**
     * Find a resource by the specified criteria.
     */
    public function findOneBy(array $criteria)
    {
        $model = $this->model->query()
            ->where($criteria)
            ->first();

        return $model;
    }
}
