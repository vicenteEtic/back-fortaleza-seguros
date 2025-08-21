<?php

namespace App\Http\Controllers\Entities;

use App\Http\Controllers\AbstractController;
use App\Services\Entities\RiskAssessmentControlService;


class RiskAssessmentControlController extends AbstractController
{
    protected ?string $logType = 'entity';
    protected ?string $nameEntity = "Controle de Avaliação de Risco";
    protected ?string $fieldName = "risk_assessment?->entity?->social_denomination";

    public function __construct(RiskAssessmentControlService $service)
    {
        $this->service = $service;
    }
}
