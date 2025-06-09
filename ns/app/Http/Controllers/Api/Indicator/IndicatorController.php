<?php

namespace App\Http\Controllers\Api\Indicator;

use App\Classes\CraftHistory;
use App\Http\Controllers\Controller;
use App\Models\IndicatorEvaluationMatrix;
use App\Models\IndicatorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class IndicatorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $CraftHistory;
    public function __construct()
    {
        $this->CraftHistory = new CraftHistory;
    }
    public function index()
    {
        try {



            $CapacidadeData = [];
            $EstabelecimentoData = [];
            $form_legalData = [];

            $type_activityData = [];

            $SeguroData = [];
            $RiscoData = [];
            $countries = [];
            $countriesData = [];
            $channelData = [];
            $caeData = [];

            $Capacidade =  IndicatorType::where('fk_indicator', 1)->orderBy('description', 'asc')->get();

            foreach ($Capacidade as $row) {
                $CapacidadeData[] = $row;
            }


            $cae =  IndicatorType::where('fk_indicator', 12)->orderBy('description', 'asc')->get();

            foreach ($cae as $row) {
                $caeData[] = $row;
            }

            $type_activity =  IndicatorType::where('fk_indicator', 5)->orderBy('description', 'asc')->get();

            foreach ($type_activity as $row) {
                $type_activityData[] = $row;
            }
            $Estabelecimento =  IndicatorType::where('fk_indicator', 2)->orderBy('description', 'asc')->get();

            foreach ($Estabelecimento as $row) {
                $EstabelecimentoData[] = $row;
            }

            $form_legal =  IndicatorType::where('fk_indicator', 3)->orderBy('description', 'asc')->get();

            foreach ($form_legal as $row) {
                $form_legalData[] = $row;
            }


            $channel = IndicatorType::where('fk_indicator', 11)->orderBy('description', 'asc')->get();

            foreach ($channel as $row) {
                $channelData[] = $row;
            }

            $Seguro =  IndicatorType::where('fk_indicator', 7)->orderBy('description', 'asc')->get();

            foreach ($Seguro as $row) {
                $SeguroData[] = $row;
            }

            $Risco =  IndicatorType::where('fk_indicator', 8)->orderBy('description', 'asc')->get();

            foreach ($Risco as $row) {
                $RiscoData[] = $row;
            }

            $countries =  IndicatorType::where('fk_indicator', 9)->orderBy('description', 'asc')->get();

            foreach ($countries as $row) {
                $countriesData[] = $row;
            }


            $Colectiva =  IndicatorType::where('fk_indicator', 10)->orderBy('description', 'asc')->get();

            foreach ($Colectiva as $row) {
                $ColectivaData[] = $row;
            }
            return      $data = [
                "capacity_identification" => $CapacidadeData,
                "form_legal" => $form_legalData,
                "type_activity" => $type_activityData,
                "risk_products" => $SeguroData,
                "countries" =>    $countriesData,
                "type_activity_collective" => $ColectivaData,
                "type_activity_collective" => $ColectivaData,
                "Channels" =>   $channelData,
                "Cae" =>   $caeData,
            ];
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
                    'name' => 'required|unique:indicator_evaluation_matrices,name,' . $request->name, // Verificar se existe  o nome

                ]; //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }

                IndicatorEvaluationMatrix::create([
                    'name' => $request->name,

                ]);

                $this->CraftHistory->log('info', 'Cadastrou um Indicador com o nome ' . $request->name, Auth::user()->name, Auth::user()->id);
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

            $this->CraftHistory->log('info', 'Visualizou um Endicador com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
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
                //validação do formulario
                $rules = [
                    'name' => 'required|', // Verifica se exite name do directory

                ]; //retornar erros de validação

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }
                $IndicatorEvaluationMatrix = IndicatorEvaluationMatrix::find($id)->count();

                if ($IndicatorEvaluationMatrix >= 0) {
                    IndicatorEvaluationMatrix::find($id)->update([
                        'name' => $request->name,

                    ]);
                    $this->CraftHistory->log('info', 'Editou um Endicador com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
                    return response()->json([
                        "message" => "Indicador atualizado"
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
                    $this->CraftHistory->log('info', 'Apagou um Endicador com o Identificador ' . $id, Auth::user()->name, Auth::user()->id);
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
