<?php

namespace App\Http\Controllers\Permission;

use App\Http\Controllers\AbstractController;
use App\Services\Permission\PermissionService;
use App\Http\Requests\Permission\PermissionRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class PermissionController extends AbstractController
{
    public function __construct(PermissionService $service)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PermissionRequest $request)
    {
        try {
            $this->logRequest();
            $entity = $this->service->store($request->validated());
            return response()->json($entity, Response::HTTP_CREATED);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PermissionRequest $request, $id)
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