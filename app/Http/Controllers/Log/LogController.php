<?php

namespace App\Http\Controllers\Log;
<<<<<<< HEAD

use App\Http\Controllers\AbstractController;
use App\Services\Log\LogService;
use App\Http\Requests\Log\LogRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class LogController extends AbstractController
{
    public function __construct(LogService $service)
=======
use App\Http\Controllers\Controller;
use App\Models\Log\Log;
use App\Services\Log\LogService as LogLogService;
class LogController extends Controller
{

    private $Log;
    public function __construct()
>>>>>>> 88120df (feat: log de atividades)
    {
        $this->service = $service;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(LogRequest $request)
    {
<<<<<<< HEAD
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
    public function update(LogRequest $request, $id)
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
=======

        $data =  Log::with('user')->orderBy('id', 'desc')->get();
        LogLogService::create("mensagem", 'info');
        return response($data, 200)->header('Content-Type', 'application/json');
        try {
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao listar historico"
            ], 400);
        }
    }
    public function show($user_id)
    {
        try {
            $response =  Log::with('user')->where('userId', $user_id)->orderBy('id', 'desc')->get();
            $response = json_encode($response, JSON_UNESCAPED_SLASHES);
            return response($response, 200)->header('Content-Type', 'application/json');
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao listar historico"
            ], 400);
        }
    }
}
>>>>>>> 88120df (feat: log de atividades)
