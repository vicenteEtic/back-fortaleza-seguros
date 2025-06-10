<?php
namespace App\Repositories\Indicator;

use App\Models\Indicator\Indicator;
use App\Repositories\AbstractRepository;

class IndicatorRepository extends AbstractRepository
{
    public function __construct(Indicator $model)
    {
        parent::__construct($model);
    }
}