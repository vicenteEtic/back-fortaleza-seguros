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

    private  $EndicatorKey = [
        'capacity_identification'     => 1,
        'form_legal'                  => 3,
        'type_activity'               => 5,
        'risk_products'               => 7,
        'countries'                   => 9,
        'type_activity_collective'    => 10,
        'channels'                    => 11,
        'cae'                         => 12,
    ];
    public function getIndicatorsByFk()
    {
        return $this->indicatorTypeRepository->getIndicatorsByFk($this->EndicatorKey);
    }
}
