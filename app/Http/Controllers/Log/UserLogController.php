<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\AbstractController;
use App\Services\Log\UserLogService;
use Exception;
use Illuminate\Http\Response;

class UserLogController extends AbstractController
{
    public function __construct(UserLogService $service)
    {
        $this->service = $service;
    }
}