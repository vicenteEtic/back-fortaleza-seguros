<?php

namespace App\Http\Controllers\Api\IndicatorType;

use App\Classes\CraftHistory;
use App\Http\Controllers\Controller;
use App\Models\IndicatorEvaluationMatrix;
use App\Models\IndicatorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IndicatorTypeController extends Controller
{
    private $CraftHistory;
    public function __construct()
    {
        $this->CraftHistory = new CraftHistory;
    }
    public function index()
    {
        try {
            $response = IndicatorEvaluationMatrix::get();


            $data = [];

            foreach ($response as $item) {
                $dados = IndicatorType::where('fk_indicator', $item->id)->get();
                $documentData = [];

                foreach ($dados as $row) {
                    $documentData[] = $row;
                }

                $data[] = [
                    'name' => $item->name,
                    'id' => $item->id,
                    'IndicatorType' => $documentData,
                ];
            }

            return $data;
        } catch (\Throwable $th) {
            //throw $th;
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
                    'description' => 'required', // Verificar se existe  o nome
                    'comment' => 'required', // Verificar se existe  o nome
                    'risk' => 'required', // Verificar se existe  o nome
                    'indicator' => 'required', // Verificar se existe  o nome
                ]; //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }

                IndicatorType::create([
                    'description' => $request->description,
                    'comment' => $request->comment,
                    'risk' => $request->risk,
                    'score' => $request->score,
                    'fk_indicator' => $request->indicator,
                ]);

                $this->CraftHistory->log('info', 'Cadastrou um tipo de Indentificador ', Auth::user()->name, Auth::user()->id);
                return response()->json(['message' => "cadastrado com sucesso"], 201);
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao cadastrar Indicador"
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $dataArray = IndicatorType::where('fk_indicator', $id)->get();

            return response()->json($dataArray, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Falha ao listar tipos de indicadores"
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

            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {

                if (isset($request->description)) {

                    IndicatorType::find($id)->update([
                        'description' => $request->description,
                    ]);
                }
                if (isset($request->comment)) {

                    IndicatorType::find($id)->update([
                        'comment' => $request->comment,
                    ]);
                }
                if (isset($request->risk)) {

                    IndicatorType::find($id)->update([
                        'risk' => $request->risk,
                    ]);
                }
                if (isset($request->indicator)) {

                    IndicatorType::find($id)->update([
                        'fk_indicator' => $request->indicator,
                    ]);
                }
                $this->CraftHistory->log('info', 'Editou um Tipo de  Endicador ' . $id, Auth::user()->name, Auth::user()->id);
                return response()->json([
                    "message" => "Tipo de Indicador atualizado"
                ], 200);
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao atualizar Indicador"
            ], 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

                $IndicatorEvaluationMatrix = IndicatorEvaluationMatrix::find($id)->count();

                if ($IndicatorEvaluationMatrix >= 0) {
                    IndicatorEvaluationMatrix::find($id)->delete();

                    return response()->json([
                        "message" => "Indicador apagado com sucesso"
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Indicador não encontrado"
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao apagar Indicador"
            ], 400);
        }
    }
}
