<?php

namespace App\Http\Controllers\Indicator;

use App\Http\Controllers\AbstractController;
use App\Services\Indicator\IndicatorService;
use Exception;
use Illuminate\Http\Response;

class IndicatorController extends AbstractController
{
    public function __construct(IndicatorService $service)
    {
        $this->service = $service;
    }
}