<?php
namespace App\Repositories\Entities;

use App\Models\Entities\Pep;
use App\Repositories\AbstractRepository;

class PepRepository extends AbstractRepository
{
    public function __construct(Pep $model)
    {
        parent::__construct($model);
    }
}