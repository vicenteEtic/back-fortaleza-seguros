<?php
namespace App\Repositories\Entities;

use App\Models\Entities\RiskAssessment;
use App\Repositories\AbstractRepository;

class RiskAssessmentRepository extends AbstractRepository
{
    public function __construct(RiskAssessment $model)
    {
        parent::__construct($model);
    }
}