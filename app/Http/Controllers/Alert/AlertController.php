<?php

namespace App\Http\Controllers\Alert;

use App\Services\Alert\AlertService;
use App\Http\Controllers\AbstractController;
<<<<<<< HEAD
=======
use App\Http\Requests\Alert\AlertDocumentRequest;
>>>>>>> 41e56c054e2731c65758a767543979c0da2e04f5
use App\Http\Requests\Alert\AlertUpdateStatusRequest;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;

class AlertController extends AbstractController
{
    protected ?string $logType = 'alert';
    protected ?string $nameEntity = "Alerta";
    protected ?string $fieldName = "name";
    public function __construct(AlertService $service)
    {
        $this->service = $service;
    }
    public function getTotalAlerts()
    {
        try {


            return $this->service->getTotalAlerts();
        } catch (Exception $e) {
            if ($this->logRequest) {
                $this->logRequest($e);
            }
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }




    public function status(AlertUpdateStatusRequest $request, $id)
    {
        try {
            $this->logRequest();
            $commentAlert = $this->service->update($request->validated(), $id);
            return response()->json($commentAlert, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
<<<<<<< HEAD
=======

    public function document(AlertDocumentRequest $request)
    {
        try {
            $this->logRequest();
            $commentAlert = $this->service->document($request->validated());
            return response()->json($commentAlert, Response::HTTP_OK);
        } catch (ModelNotFoundException $e) {
            $this->logRequest($e);
            return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    
>>>>>>> 41e56c054e2731c65758a767543979c0da2e04f5
}
