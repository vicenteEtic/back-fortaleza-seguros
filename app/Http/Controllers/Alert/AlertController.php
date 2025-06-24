<?php

namespace App\Http\Controllers\Alert;

use App\Services\Alert\AlertService;
use App\Http\Controllers\AbstractController;

class AlertController extends AbstractController
{
    public function __construct(AlertService $service)
    {
        $this->service = $service;
    }
}
