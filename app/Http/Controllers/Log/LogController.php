<?php

namespace App\Http\Controllers\Log;

use App\Http\Controllers\Controller;
use App\Models\Log\Log;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;

use App\Models\Log as ModelsLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;

class LogController extends Controller
{
 
    private $Log;
    public function __construct()
    {
        $this->Log = new Log;
    }


    public function index()
    {



            $response =  Log::orderBy('id', 'desc')->get();
            $data = [];
            foreach ($response as $item) {
                $data[] = [
                    "id" => $item->id,
                    "level" => $item->level,
                    "REMOTE_ADDR" => $item->REMOTE_ADDR,
                    "PATH_INFO" => $item->PATH_INFO,
                    "HTTP_USER_AGENT" => $item->HTTP_USER_AGENT,
                    "message" => $item->message,
                    "created_at" => $item->created_at,
                    'user' => [
                        "first_name" => $item->user->first_name,
                        "email" => $item->user->email,
                        "phone" => $item->user->phone,
                        "last_name" => $item->user->last_name,
                    ],


                ];
            }

            return response($data, 200)->header('Content-Type', 'application/json');

            try {
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao listar historico"
            ], 400);
        }
    }
    public function history($id)
    {

        try {
            //pegar o processo

            $response =  Log::where('userId', $id)->orderBy('id', 'desc')->get();
            $response = json_encode($response, JSON_UNESCAPED_SLASHES);
            return response($response, 200)->header('Content-Type', 'application/json');

        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao listar historico"
            ], 400);
        }
    }



    public function myHistory(Request $request)
    {


            $response =  Log::where('userId', FacadesAuth::user()->id)->orderBy('id', 'desc')->get();
            $response = json_encode($response, JSON_UNESCAPED_SLASHES);
            return response($response, 200)->header('Content-Type', 'application/json');
            try {
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao listar historico"
            ], 400);
        }
    }


    public function store(Request $request)
    {

    
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

               
           return     Log::create([
                    'REMOTE_ADDR' => $_SERVER['REMOTE_ADDR'],
            'PATH_INFO' =>  URL::current(),
            'REQUEST_TIME' =>  $_SERVER['REQUEST_TIME'],
            'USER_ID' => 1,
            'USER_NAME' =>  1,
            'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT'],
            'message' => 5544,
            'level' => 516,
            'id_document'=>151

                ]);

                $this->Log->log('info', 'Cadastrou um registro com número ', $request->id, Auth::user()->name,Auth::user()->id);
                return response()->json(['message' => "cadastrado com sucesso"], 201);
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
            try {
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao cadastrar departamento"
            ], 400);
        }
    }
}
