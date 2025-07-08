<?php

namespace App\Http\Controllers\Entities;

use Exception;
use Illuminate\Http\Response;
use App\Services\Entities\EntitiesService;
use App\Http\Controllers\AbstractController;
use App\Http\Requests\Entities\EntitiesRequest;
use App\Http\Requests\Entities\ImportDataRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EntitiesController extends AbstractController
{
    protected ?string $logType = 'entity';
    protected ?string $nameEntity = "Entidade";
    protected ?string $fieldName = "social_denomination";

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
            $this->logToDatabase(
                type: 'entity',
                level: 'info',
                customMessage: "Entidade {$entities->social_denomination} criada com sucesso.",
                idEntity: $entities->id
            );
            return response()->json($entities, Response::HTTP_CREATED);
        } catch (Exception $e) {
            $this->logRequest($e);
            $this->logToDatabase(
                type: 'entity',
                level: 'error',
                customMessage: "Erro ao criar entidade.",
            );
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
            $this->logToDatabase(
                type: 'entity',
                level: 'info',
                customMessage: "Entidade {$entities->social_denomination} atualizada com sucesso.",
                idEntity: $entities->id
            );
            return response()->json($entities, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            $this->logToDatabase(
                type: 'entity',
                level: 'error',
                customMessage: "Erro ao atualizar entidade com ID {$id}.",
            );
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            $this->logToDatabase(
                type: 'entity',
                level: 'error',
                customMessage: "Erro ao atualizar entidade.",
            );
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function storeImportData(ImportDataRequest $request)
    {
        try {
            $this->logRequest();
            $batchId = $this->service->initializeImportBatch(Auth::id());
            $this->service->dispatchImportJobs($request->validated(), Auth::id(), $batchId);
            $this->logToDatabase(
                type: 'entity',
                level: 'info',
                customMessage: "Importação de entidades iniciada com sucesso."
            );
            return response()->json("Importação em progresso", Response::HTTP_OK);
        } catch (Exception $e) {
            $this->logRequest($e);
            $this->logToDatabase(
                type: 'entity',
                level: 'error',
                customMessage: "Erro ao iniciar importação de entidades."
            );
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
