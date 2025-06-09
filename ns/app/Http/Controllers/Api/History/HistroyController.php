<?php

namespace App\Http\Controllers\Api\History;

use App\Apis\Alfresco\generateAPI;
use App\Http\Controllers\Controller;
use App\Models\CraftHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Classes\CraftHistory as CraftHistorym;
use Illuminate\Support\Facades\Auth;

class HistroyController extends Controller
{


    private $CraftHistory;
    public function __construct()
    {
        $this->CraftHistory = new CraftHistorym;
    }


    public function index()
    {



            $response =  CraftHistory::orderBy('id', 'desc')->get();
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

            $response =  CraftHistory::where('userId', $id)->orderBy('id', 'desc')->get();
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


            $response =  CraftHistory::where('userId', Auth::user()->id)->orderBy('id', 'desc')->get();
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

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //validação do formulario
                $rules = [
                    'message' => 'required', // Verifica o nome
                   ]; //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }

                CraftHistory::create([
                    'USER_NAME' =>  Auth::user()->name,
                    'userId'  =>  Auth::user()->id,
                    'message' => $request->message,

                ]);

                $this->CraftHistory->log('info', 'Cadastrou um registro com número ', $request->id, Auth::user()->name,Auth::user()->id);
                return response()->json(['message' => "cadastrado com sucesso"], 201);
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao cadastrar departamento"
            ], 400);
        }
    }
}
