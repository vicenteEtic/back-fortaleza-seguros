<?php

namespace App\Services\Indicator;

use App\Models\Indicator\IndicatorType;
use App\Repositories\Indicator\IndicatorRepository;
use App\Repositories\Indicator\IndicatorTypeRepository;
use App\Services\AbstractService;

class IndicatorService extends AbstractService
{
    protected IndicatorTypeRepository $indicatorTypeRepository;

    public function __construct(
        IndicatorRepository $repository,
        IndicatorTypeRepository $indicatorTypeRepository
    ) {
        parent::__construct($repository);
        $this->indicatorTypeRepository = $indicatorTypeRepository;
    }


    public function getIndicatorsByFk(array $indicators)
    {
        return $this->indicatorTypeRepository->getIndicatorsByFk($indicators);
    }
}
