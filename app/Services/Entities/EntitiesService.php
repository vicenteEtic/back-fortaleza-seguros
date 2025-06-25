<?php

namespace App\Services\Entities;

use App\Enum\TypeEntity;
use App\Repositories\Entities\EntitiesRepository;
use App\Services\AbstractService;

class EntitiesService extends AbstractService
{
    public function __construct(EntitiesRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getTotalEntites()
    {
        return $this->repository->getTotalEntities();
    }

    public function getEntitiesByType(TypeEntity $type)
    {
        return $this->repository->getEntitiesByType($type);
    }
    
}
