<?php
namespace App\Services\Entities;

use App\Repositories\Entities\PepRepository;
use App\Services\AbstractService;

class PepService extends AbstractService
{
    public function __construct(PepRepository $repository)
    {
        parent::__construct($repository);
    }
}