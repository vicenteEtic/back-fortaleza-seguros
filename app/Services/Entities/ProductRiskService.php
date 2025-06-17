<?php
namespace App\Services\Entities;

use App\Repositories\Entities\ProductRiskRepository;
use App\Services\AbstractService;

class ProductRiskService extends AbstractService
{
    public function __construct(ProductRiskRepository $repository)
    {
        parent::__construct($repository);
    }
}