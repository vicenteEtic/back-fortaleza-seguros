<?php

namespace App\Http\Controllers\Indicator;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Indicator\IndicatorRequest;
use App\Services\Indicator\IndicatorService;
use App\Services\Log\LogService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class IndicatorController extends AbstractController
{
    public function __construct(IndicatorService $service, LogService $logService)
    {
        parent::__construct($service, $logService);
    }

   

    /**
     * Store a newly created resource in storage.
     */
    public function store(IndicatorRequest $request)
    {
        try {
            $this->logRequest();
            $entities = $this->service->store($request->validated());
            $this->storeLogUser('info',"cadastrou um indicador",'user','');
            return response()->json($entities, Response::HTTP_CREATED);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(IndicatorRequest $request, $id)
    {
        try {
            $this->logRequest();
            $entities = $this->service->update($request->validated(), $id);
            return response()->json($entities, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}