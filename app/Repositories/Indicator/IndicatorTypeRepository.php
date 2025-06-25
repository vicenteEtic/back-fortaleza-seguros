<?php

namespace App\Repositories\Indicator;

use App\Models\Indicator\IndicatorType;
use App\Repositories\AbstractRepository;

class IndicatorTypeRepository extends AbstractRepository
{
    public function __construct(IndicatorType $model)
    {
        parent::__construct($model);
    }

    public function sumWhere(string $column, array $ids): int
    {
        return $this->model->whereIn('id', $ids)->sum($column) ?? 0;
    }

    public function getByIds(array $ids)
    {
        return $this->model->whereIn('id', $ids);
    }

    public function getIndicatorsByFk(array $indicators): array
    {
        $data = [];

        foreach ($indicators as $key => $fk) {
            $data[$key] = $this->model::where('indicator_id', $fk)
                ->orderBy('description', 'asc')
                ->get()
                ->toArray();
        }

        return $data;
    }
}
