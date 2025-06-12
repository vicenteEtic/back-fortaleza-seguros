<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\AbstractController;
use App\Services\Log\LogService;
use App\Http\Requests\Log\LogRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class LogController extends AbstractController
{
    public function __construct(LogService $service)
    {
        parent::__construct($service, $service);
    }

    
}
