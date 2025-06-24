<?php
namespace App\Services\Alerta;

use App\Repositories\Alerta\AlertaRepository;
use App\Services\AbstractService;

class AlertaService extends AbstractService
{
    public function __construct(AlertaRepository $repository)
    {
        parent::__construct($repository);
    }
}