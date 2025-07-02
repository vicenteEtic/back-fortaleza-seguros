<?php
    
    namespace App\Http\Controllers\Entities;
    
    use App\Http\Controllers\AbstractController;
    use App\Services\Entities\RiskAssessmentControlService;

    
    class RiskAssessmentControlController extends AbstractController
    {
        public function __construct(RiskAssessmentControlService $service)
        {
            $this->service = $service;
        }
    }