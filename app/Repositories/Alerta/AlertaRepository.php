<?php
namespace App\Repositories\Alerta;

use App\Models\Alerta\Alerta;
use App\Repositories\AbstractRepository;

class AlertaRepository extends AbstractRepository
{
    public function __construct(Alerta $model)
    {
        parent::__construct($model);
    }
}