<?php

namespace App\Http\Controllers\Indicator;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\AbstractController;
use App\Services\Indicator\IndicatorService;
use App\Http\Requests\Indicator\IndicatorRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class IndicatorController extends AbstractController
{
    public function __construct(IndicatorService $service)
    {
        $this->service = $service;
    }
    public function getIndicatorsByFk(Request $request)
    {
        try {
            $indicators = $this->service->getIndicatorsByFk();
            return response()->json($indicators);
        } catch (\Throwable $th) {
            $this->logRequest($th);
            return response()->json(['error' => 'Erro ao buscar os dados.'], 500);
        }
    }


    public function store(IndicatorRequest $request)
    {
        try {
            $this->logRequest();
            $entities = $this->service->store($request->validated());
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
