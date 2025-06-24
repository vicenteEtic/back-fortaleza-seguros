<?php
    
    namespace App\Http\Controllers\Alerta;
    
    use App\Http\Controllers\AbstractController;
    use App\Services\Alerta\AlertaService;
    use App\Http\Requests\Alerta\AlertaRequest;
    use Exception;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Response;
    
    class AlertaController extends AbstractController
    {
        public function __construct(AlertaService $service)
        {
            $this->service = $service;
        }
    
        /**
         * Store a newly created resource in storage.
         */
        public function store(AlertaRequest $request)
        {
            try {
                $this->logRequest();
                $alerta = $this->service->store($request->validated());
                return response()->json($alerta, Response::HTTP_CREATED);
            } catch (Exception $e) {
                $this->logRequest($e);
                return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    
        /**
         * Update the specified resource in storage.
         */
        public function update(AlertaRequest $request, $id)
        {
            try {
                $this->logRequest();
                $alerta = $this->service->update($request->validated(), $id);
                return response()->json($alerta, Response::HTTP_OK);
            } catch (ModelNotFoundException $e) {
                $this->logRequest($e);
                return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
            } catch (Exception $e) {
                $this->logRequest($e);
                return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }