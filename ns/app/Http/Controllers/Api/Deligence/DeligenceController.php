<?php

namespace App\Http\Controllers\Api\Deligence;

use App\Classes\CraftHistory;
use App\Http\Controllers\Controller;
use App\Models\Diligence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DeligenceController extends Controller
{
    private $CraftHistory;
    public function __construct()
    {
        $this->CraftHistory = new CraftHistory;
    }
    public function index()
    {
        $data = Diligence::get();
        return response()->json($data, 200);
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
                    'name' => ['required', 'string',],
                    'max' => ['required', 'numeric',],
                    'min' => ['required', 'numeric',],
                    'risk' => ['required', 'string',],
                    'color' => ['required', 'string',],

                ];

                //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }
                Diligence::create([
                    'name' => $request->name,
                    'description' => $request->description,
                    'max' => $request->max,
                    'min' => $request->min,
                    'risk' => $request->risk,
                    'color' => $request->color,


                ]);
                $this->CraftHistory->log('info', 'Cadastrou uma Deligência com o nome ' . $request->name, Auth::user()->name, Auth::user()->id);
                return response()->json(['message' => "cadastrado com sucesso"], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao cadastrar Tipo de Diligence"
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

            return  Diligence::find($id);
            $this->CraftHistory->log('info', 'Visualizou uma Diligence com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao pesquisar Tipo de Diligence"
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

                Diligence::find($id)->update([
                    'name' => $request->name,

                ]);
            }
            if (isset($request->description)) {

                Diligence::find($id)->update([
                    'description' => $request->description,

                ]);
            }

            if (isset($request->color)) {

                Diligence::find($id)->update([
                    'color' => $request->color,

                ]);
            }
            if (isset($request->max)) {

                Diligence::find($id)->update([
                    'max' => $request->max,

                ]);
            }

            if (isset($request->min)) {

                Diligence::find($id)->update([
                    'min' => $request->min,

                ]);
            }

            if (isset($request->risk)) {

                Diligence::find($id)->update([
                    'risk' => $request->risk,

                ]);
            }
            if (isset($request->type)) {

                Diligence::find($id)->update([
                    'type' => $request->type,

                ]);
            }

            $this->CraftHistory->log('info', 'Editou uma Deligência com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
            return response()->json([
                "message" => "Tipo de Diligence atulizado com sucesso"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao Tipo de Diligence Tipo de Diligence"
            ], 400);
        }
    }


    public function destroy($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

                $Diligence = Diligence::find($id)->count();

                if ($Diligence >= 0) {
                    Diligence::find($id)->delete();

                    $this->CraftHistory->log('info', 'Apagou uma Diligence com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
                    return response()->json([
                        "message" => "Tipo de Diligence apagado com sucesso"
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Tipo de Diligence não encontrado"
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao apagar Tipo de Diligence"
            ], 400);
        }
    }
}
