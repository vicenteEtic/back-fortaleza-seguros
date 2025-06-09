<?php

namespace App\Http\Controllers\Api\Category;

use App\Classes\CraftHistory;
use App\Http\Controllers\Controller;
use App\Models\IndicatorType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private $CraftHistory;
    public function __construct()
    {
        $this->CraftHistory = new CraftHistory;
    }
    public function index(Request $request)
    {

        try {
            $data = IndicatorType::where('fk_indicator', 3)->orderBy('description', 'asc')->get();
            return response()->json($data, 200);

        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Falha ao listar  countries",
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
                    'description' => ['required', 'string'],
                    'risk' => ['required', 'string'],
                    'score' => ['required', 'numeric'],
                ];

                //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }
                IndicatorType::create([
                    'description' => $request->description,
                    'risk' => $request->risk,
                    'score' => $request->score,
                    'fk_indicator' => 3,
                ]);
                $this->CraftHistory->log('info', 'Cadastrou uma entidade com o nome ' . $request->customer_number, Auth::user()->name, Auth::user()->id);
                return response()->json(['message' => "cadastrado com sucesso"], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao cadastrar Tipo de entidade",
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

        $data = IndicatorType::find($id);

        $this->CraftHistory->log('info', 'Visualizou um pais  ' . $id, Auth::user()->name, Auth::user()->id);
        return response()->json($data, 200);
        try {
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao pesquisar Tipo de entidade",
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

            if (isset($request->description)) {

                IndicatorType::find($id)->update([
                    'description' => $request->description,

                ]);
            }
            if (isset($request->risk)) {

                IndicatorType::find($id)->update([
                    'risk' => $request->risk,

                ]);
            }

            if (isset($request->score)) {

                IndicatorType::find($id)->update([
                    'score' => $request->score,

                ]);
            }

            $this->CraftHistory->log('info', 'Editou uma entidade com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
            return response()->json([
                "message" => "Tipo de entidade atulizado com sucesso",
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao Editar de Entidade Tipo de entidade",
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

                $IndicatorType = IndicatorType::find($id)->count();

                if ($IndicatorType >= 0) {
                    IndicatorType::find($id)->delete();

                    $this->CraftHistory->log('info', 'Apagou uma entidade com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
                    return response()->json([
                        "message" => "Tipo de entidade apagado com sucesso",
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Tipo de Entidade não encontrado",
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido.",
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao apagar Tipo de entidade",
            ], 400);
        }
    }
}
