<?php

namespace App\Http\Controllers\Entities;

use Exception;
use Illuminate\Http\Response;
use App\Services\Entities\EntitiesService;
use App\Http\Controllers\AbstractController;
use App\Http\Requests\Entities\EntitiesRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EntitiesController extends AbstractController
{
    public function __construct(EntitiesService $service)
    {
        $this->service = $service;
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(EntitiesRequest $request)
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
    public function update(EntitiesRequest $request, $id)
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
