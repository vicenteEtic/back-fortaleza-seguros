<?php
namespace App\Repositories\Entities;

use App\Models\Entities\Entities;
use App\Repositories\AbstractRepository;

class EntitiesRepository extends AbstractRepository
{
    public function __construct(Entities $model)
    {
        parent::__construct($model);
    }
}