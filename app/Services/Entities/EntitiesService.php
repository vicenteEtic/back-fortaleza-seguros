<?php
namespace App\Services\Entities;

use App\Repositories\Entities\EntitiesRepository;
use App\Services\AbstractService;

class EntitiesService extends AbstractService
{
    public function __construct(EntitiesRepository $repository)
    {
        parent::__construct($repository);
    }
}