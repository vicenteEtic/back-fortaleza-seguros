<?php
namespace App\Services\Entities;

use App\Repositories\Entities\BeneficialOwnerRepository;
use App\Services\AbstractService;

class BeneficialOwnerService extends AbstractService
{
    public function __construct(BeneficialOwnerRepository $repository)
    {
        parent::__construct($repository);
    }
}