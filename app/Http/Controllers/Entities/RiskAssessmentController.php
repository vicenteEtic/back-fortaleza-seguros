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

    public function getTotalRiskLevelByCategory()
    {
        try {
            $this->logRequest();
            $result = $this->service->getTotalRiskLevelByCategory();
            return response()->json($result, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTotalRiskLevelByProfession()
    {
        try {
            $this->logRequest();
            $result = $this->service->getTotalRiskLevelByProfession();
            return response()->json($result, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTotalRiskLevelByChannel()
    {
        try {
            $this->logRequest();
            $result = $this->service->getTotalRiskLevelByChannel();
            return response()->json($result, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTotalRiskLevelByPep()
    {
        try {
            $this->logRequest();
            $result = $this->service->getTotalRiskLevelByPep();
            return response()->json($result, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTotalRiskLevelByCountryResidence()
    {
        try {
            $this->logRequest();
            $result = $this->service->getTotalRiskLevelByCountryResidence();
            return response()->json($result, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getTotalRiskLevelByNationality()
    {
        try {
            $this->logRequest();
            $result = $this->service->getTotalRiskLevelByNationality();
            return response()->json($result, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
