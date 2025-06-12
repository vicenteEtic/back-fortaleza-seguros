<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Models\Log\EntitieLog;
use Exception;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
class EntititeLogController extends Controller
{
   
    public function index()
    {
        try {
        $data =  EntitieLog::with('entitie','user')->orderBy('id', 'desc')->get();

        return response($data, 200)->header('Content-Type', 'application/json');
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        
        }
    }
    public function show($entitie_id)
    {
        try {
            $response =  EntitieLog::with('entitie','user')->where('fk_entities', $entitie_id)->orderBy('id', 'desc')->get();
            $response = json_encode($response, JSON_UNESCAPED_SLASHES);
            return response($response, 200)->header('Content-Type', 'application/json');
        } catch (Exception $e) {
            $this->logRequest($e);
            return response()->json($e->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        
        }
    }

}
