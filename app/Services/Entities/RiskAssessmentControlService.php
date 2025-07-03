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

    public function index(?int $paginate, ?array $filterParams, ?array $orderByParams, $relationships = [])
    {
        $relationships = [
            'user'
        ];
        $orderByParams = $orderByParams ?? ['created_at' => 'desc'];
        return $this->repository->index($paginate, $filterParams, $orderByParams, $relationships);
    }
}
