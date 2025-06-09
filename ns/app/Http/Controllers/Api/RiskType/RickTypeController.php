<?php

namespace App\Http\Controllers\Api\RiskType;

use App\Classes\CraftHistory;
use App\Http\Controllers\Controller;
use App\Models\RiscoLevel;
use App\Models\RiskType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RickTypeController extends Controller
{
    private $CraftHistory;
    public function __construct()
    {
        $this->CraftHistory = new CraftHistory;
    }
    public function index()
    {
        $data = RiskType::get();
        return response()->json($data, 200);
    }


    public function store(Request $request)
    {

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //validação do formulario
                $rules = [
                    'name' => ['required', 'string',],
                ];

                //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }
                RiskType::create([
                    'name' => $request->name,
                    'description' => $request->description,


                ]);
                $this->CraftHistory->log('info', 'Cadastrou uma Tipo de Risco com o nome ' . $request->name, Auth::user()->name, Auth::user()->id);
                return response()->json(['message' => "cadastrado com sucesso"], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao cadastrar Tipo de Risco"
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

            return  RiskType::find($id);
            $this->CraftHistory->log('info', 'Visualizou uma Risco com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao pesquisar Tipo de Risco"
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


            if (isset($request->name)) {

                RiskType::find($id)->update([
                    'name' => $request->name,

                ]);
            }
            if (isset($request->description)) {

                RiskType::find($id)->update([
                    'description' => $request->description,

                ]);
            }


            $this->CraftHistory->log('info', 'Editou uma Tipo de Risco com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
            return response()->json([
                "message" => "Tipo de Risco atulizado com sucesso"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao Atualizar Tipo de Risco"
            ], 400);
        }
    }


    public function destroy($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

                $RiskType = RiskType::find($id)->count();

                if ($RiskType >= 0) {
                    RiskType::find($id)->delete();

                    $this->CraftHistory->log('info', 'Apagou uma RiskType com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
                    return response()->json([
                        "message" => "Tipo de Risco apagado com sucesso"
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Tipo de Risco não encontrado"
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao apagar Tipo de Risco"
            ], 400);
        }
    }
}
