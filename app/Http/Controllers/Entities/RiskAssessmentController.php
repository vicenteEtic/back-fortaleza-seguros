<?php

namespace App\Http\Controllers\Entities;

use App\Http\Controllers\AbstractController;
use App\Services\Entities\RiskAssessmentService;
use App\Http\Requests\Entities\RiskAssessmentRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class RiskAssessmentController extends AbstractController
{
    public function __construct(RiskAssessmentService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RiskAssessmentRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->logRequest();
            $entity = $this->service->store($request->validated());
            DB::commit();
            return response()->json($entity, Response::HTTP_CREATED);
        } catch (Exception $e) {
            DB::rollBack();
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RiskAssessmentRequest $request, $id)
    {
        try {
            $this->logRequest();
            $entity = $this->service->update($request->validated(), $id);
            return response()->json($entity, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
