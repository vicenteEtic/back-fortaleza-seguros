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
}