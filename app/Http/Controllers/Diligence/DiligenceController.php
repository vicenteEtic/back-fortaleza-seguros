<?php

namespace App\Http\Controllers\Diligence;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\Diligence\DiligenceRequest;
use App\Services\Diligence\DiligenceService;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class DiligenceController extends AbstractController
{
    public function __construct(DiligenceService $service)
    {
        $this->service = $service;
    }

    public function store(DiligenceRequest $request)
    {
        try {
            $this->logRequest();
            $diligence = $this->service->store($request->validated());
            return response()->json($diligence, Response::HTTP_CREATED);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiligenceRequest $request, $id)
    {
        try {
            $this->logRequest();
            $diligence = $this->service->update($request->validated(), $id);
            return response()->json($diligence, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
