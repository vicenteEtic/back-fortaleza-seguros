<?php
namespace App\Repositories\Diligence;

use App\Models\Diligence\Diligence;
use App\Repositories\AbstractRepository;

class DiligenceRepository extends AbstractRepository
{
    public function __construct(Diligence $model)
    {
        parent::__construct($model);
    }
}