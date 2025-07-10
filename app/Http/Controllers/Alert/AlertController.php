<?php

namespace App\Http\Controllers\Alert;

use App\Services\Alert\AlertService;
use App\Http\Controllers\AbstractController;

class AlertController extends AbstractController
{
    protected ?string $logType = 'alert';
    protected ?string $nameEntity = "Alerta";
    protected ?string $fieldName = "name";
    public function __construct(AlertService $service)
    {
        $this->service = $service;
    }
}
