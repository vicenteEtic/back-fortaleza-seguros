<?php

namespace App\Http\Controllers\Dashboard;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\DashboardRequest;
use App\Services\Dashboard\DashboardService;

class DashboardController extends Controller
{
    public function __construct(private DashboardService $service) {}

    public function dashboard(Request $request)
    {
        try {
            $this->logRequest();
            $data = $this->service->totalGeralData();
            return response()->json($data, Response::HTTP_OK);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
