<?php
namespace App\Services\Diligence;

use App\Repositories\Diligence\DiligenceRepository;
use App\Services\AbstractService;

class DiligenceService extends AbstractService
{
    public function __construct(DiligenceRepository $repository)
    {
        parent::__construct($repository);
    }
}