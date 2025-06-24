<?php
namespace App\Repositories\Alert;

use App\Models\Alert\Alert;
use App\Repositories\AbstractRepository;

class AlertRepository extends AbstractRepository
{
    public function __construct(Alert $model)
    {
        parent::__construct($model);
    }
}