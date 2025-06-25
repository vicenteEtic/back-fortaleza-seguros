<?php

namespace App\Repositories\Entities;

use App\Enum\TypeEntity;
use App\Models\Entities\Entities;
use App\Repositories\AbstractRepository;

class EntitiesRepository extends AbstractRepository
{
    public function __construct(Entities $model)
    {
        parent::__construct($model);
    }

    public function getTotalEntities(): int
    {
        return $this->model->count();
    }

    public function getEntitiesByType(TypeEntity $type): int
    {
        return $this->model->where('entity_type', $type)->count();
    }
}
