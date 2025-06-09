<?php

namespace App\Http\Controllers\Api\Risk;

use App\Classes\CraftHistory;
use App\Http\Controllers\Controller;
use App\Models\Diligence;
use App\Models\Risk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RickController extends Controller
{

    private $CraftHistory;
    public function __construct()
    {
        $this->CraftHistory = new CraftHistory;
    }
    public function index(Request $request)
    {
        try {

            $data =  Diligence::orderBy('risk', 'asc')->get();

            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Falha ao listar Tipo de entidades"
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //validação do formulario
                $rules = [
                    'social_denomination' => ['required', 'string',],

                    'customer_number' => ['required', 'string',],
                    'entity_type' => ['required', 'string', '', 'numeric'],
                ];

                //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }
                Risk::create([
                    'customer_number' => $request->customer_number,
                    'policy_number' => $request->policy_number,
                    'social_denomination' => $request->social_denomination,
                    'fk_entities_type' => $request->entity_type,

                ]);
                $this->CraftHistory->log('info', 'Cadastrou uma entidade com o nome ' . $request->customer_number, Auth::user()->name, Auth::user()->id);
                return response()->json(['message' => "cadastrado com sucesso"], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao cadastrar Tipo de entidade"
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {

            return  Risk::find($id);
            $this->CraftHistory->log('info', 'Visualizou uma entidade com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao pesquisar Tipo de entidade"
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function update(Request $request, $id)
    {

        try {


            if (isset($request->lastname)) {

                Risk::find($id)->update([
                    'lastname' => $request->lastname,

                ]);
            }
            if (isset($request->customer_number)) {

                Risk::find($id)->update([
                    'customer_number' => $request->customer_number,

                ]);
            }


            if (isset($request->name)) {

                Risk::find($id)->update([
                    'name' => $request->name,

                ]);
            }
            if (isset($request->data)) {

                Risk::find($id)->update([
                    'data' => $request->data,

                ]);
            }
            if (isset($request->policy_number)) {

                Risk::find($id)->update([
                    'policy_number' => $request->policy_number,

                ]);
            }
            if (isset($request->social_denomination)) {

                Risk::find($id)->update([
                    'social_denomination' => $request->social_denomination,

                ]);
            }
            if (isset($request->entities_type)) {

                Risk::find($id)->update([
                    'fk_entities_type' => $request->entities_type,

                ]);
            }
            $this->CraftHistory->log('info', 'Editou uma entidade com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
            return response()->json([
                "message" => "Tipo de entidade atulizado com sucesso"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao Tipo de entidade Tipo de entidade"
            ], 400);
        }
    }


    public function destroy($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

                $Risk = Risk::find($id)->count();

                if ($Risk >= 0) {
                    Risk::find($id)->delete();

                    $this->CraftHistory->log('info', 'Apagou uma entidade com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
                    return response()->json([
                        "message" => "Tipo de entidade apagado com sucesso"
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Tipo de entidade não encontrado"
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao apagar Tipo de entidade"
            ], 400);
        }
    }
}
