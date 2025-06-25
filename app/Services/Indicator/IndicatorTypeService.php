<?php
namespace App\Services\Indicator;

use App\Repositories\Indicator\IndicatorTypeRepository;
use App\Services\AbstractService;

class IndicatorTypeService extends AbstractService
{
    
   protected IndicatorTypeRepository $indicatorTypeRepository;


   public function __construct(IndicatorTypeRepository $repository)
   {
       parent::__construct($repository);
       $this->indicatorTypeRepository = $repository;
   }

}