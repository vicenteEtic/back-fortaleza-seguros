<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\AbstractController;
use App\Http\Requests\UserRequest;
use App\Services\User\UserService;
use Exception;
use Illuminate\Http\Response as HttpResponse;

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
            $service = $this->service->store($request->validated());
            return response()->json($service, HttpResponse::HTTP_CREATED);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function update(UserRequest $request, $id)
    {

        try {
            $this->logRequest();
            $service = $this->service->update($request->validated(), $id);
            return response()->json($service);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), HttpResponse::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
