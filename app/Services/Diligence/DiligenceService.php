<?php
namespace App\Services\Diligence;

use App\Services\AbstractService;
use App\Repositories\Diligence\DiligenceRepository;

class DiligenceService extends AbstractService
{
    public function __construct(DiligenceRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getDilligenceAssessment($riskValue)
    {
        return $this->repository->getDilligenceAssessment($riskValue);
    }
}