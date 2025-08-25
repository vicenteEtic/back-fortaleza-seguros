<?php
    
    namespace App\Http\Controllers\Alert\AlertUser;
    
    use App\Http\Controllers\AbstractController;
    use App\Services\Alert\AlertUser\AlertUserService;
    use App\Http\Requests\Alert\AlertUser\AlertUserRequest;
    use Exception;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Response;
    
    class AlertUserController extends AbstractController
    {
        public function __construct(AlertUserService $service)
        {
            $this->service = $service;
        }
    
        /**
         * Store a newly created resource in storage.
         */
        public function store(AlertUserRequest $request)
        {
            try {
                $this->logRequest();
                $alertUser = $this->service->store($request->validated());
                return response()->json($alertUser, Response::HTTP_CREATED);
            } catch (Exception $e) {
                $this->logRequest($e);
                return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    
        /**
         * Update the specified resource in storage.
         */
        public function update(AlertUserRequest $request, $id)
        {
            try {
                $this->logRequest();
                $alertUser = $this->service->update($request->validated(), $id);
                return response()->json($alertUser, Response::HTTP_OK);
            } catch (ModelNotFoundException $e) {
                $this->logRequest($e);
                return response()->json(['error' => 'Resource not found.'], Response::HTTP_NOT_FOUND);
            } catch (Exception $e) {
                $this->logRequest($e);
                return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
            }
        }
    }