<?php
namespace App\Services\Indicator;

use App\Repositories\Indicator\IndicatorRepository;
use App\Services\AbstractService;

class IndicatorService extends AbstractService
{
    public function __construct(IndicatorRepository $repository)
    {
        parent::__construct($repository);
    }
}