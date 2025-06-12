<?php

namespace App\Http\Controllers\User;

use Exception;
use Illuminate\Http\Response;
use App\Services\User\UserService;
use App\Http\Controllers\AbstractController;
use App\Http\Requests\User\UserRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends AbstractController
{
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function store(UserRequest $request)
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
    public function update(UserRequest $request, $id)
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
