<?php
namespace App\Services\Entities;

use App\Repositories\Entities\RiskAssessmentControlRepository;
use App\Services\AbstractService;

class RiskAssessmentControlService extends AbstractService
{
    public function __construct(RiskAssessmentControlRepository $repository)
    {
        parent::__construct($repository);
    }
}