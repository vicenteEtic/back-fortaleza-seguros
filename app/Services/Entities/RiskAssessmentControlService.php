<?php

namespace App\Services\Entities;

use App\Services\AbstractService;
use App\Repositories\Entities\RiskAssessmentControlRepository;

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
