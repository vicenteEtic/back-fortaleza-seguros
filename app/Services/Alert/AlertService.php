<?php
namespace App\Services\Alert;

use App\Repositories\Alert\AlertRepository;
use App\Services\AbstractService;

class AlertService extends AbstractService
{
    public function __construct(AlertRepository $repository)
    {
        parent::__construct($repository);
    }
}