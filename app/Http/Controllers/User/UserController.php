<?php

namespace App\Http\Controllers\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\User\UserService;
use App\Http\Requests\User\AuthRequest;
use App\Http\Requests\User\UserRequest;
use App\Http\Controllers\AbstractController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Auth;

class UserController extends AbstractController
{
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    public function login(AuthRequest $request)
    {
        try {
            $this->logRequest();
            $token = $this->service->login($request);
            return response()->json(['api_token' => $token], Response::HTTP_OK);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_UNAUTHORIZED);
        }
    }
    public function logout(Request $request)
    {
        try {
            $this->logRequest();
            $response = $this->service->logout($request);
            return response()->json(["message" => "Sessão terminada!"], Response::HTTP_OK);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function store(UserRequest $request)
    {
        try {
            $this->logRequest();
            $user = $this->service->store($request->validated());
            return response()->json($user, Response::HTTP_CREATED);
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
            $user = $this->service->update($request->validated(), $id);
            return response()->json($user, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
