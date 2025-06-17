<?php
    
    namespace App\Http\Controllers\Entities;
    
    use App\Http\Controllers\AbstractController;
    use App\Services\Entities\BeneficialOwnerService;
    use App\Http\Requests\Entities\BeneficialOwnerRequest;
    use Exception;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Response;
    
    class BeneficialOwnerController extends AbstractController
    {
        public function __construct(BeneficialOwnerService $service)
        {
            $this->service = $service;
        }
    
        /**
         * Store a newly created resource in storage.
         */
        public function store(BeneficialOwnerRequest $request)
        {
            try {
                $this->logRequest();
                $beneficialOwner = $this->service->store($request->validated());
                return response()->json($beneficialOwner, Response::HTTP_CREATED);
            } catch (Exception $e) {
                $this->logRequest($e);
                return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    
        /**
         * Update the specified resource in storage.
         */
        public function update(BeneficialOwnerRequest $request, $id)
        {
            try {
                $this->logRequest();
                $beneficialOwner = $this->service->update($request->validated(), $id);
                return response()->json($beneficialOwner, Response::HTTP_OK);
            } catch (ModelNotFoundException $e) {
                $this->logRequest($e);
                return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
            } catch (Exception $e) {
                $this->logRequest($e);
                return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }