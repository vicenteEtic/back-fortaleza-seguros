<?php

namespace App\Http\Controllers\Api\TypeEntities;

use App\Http\Controllers\Controller;
use App\Models\Departament;
use App\Models\DepartamentUser;
use App\Models\Role;
use App\Models\RolePermission;
use App\Models\TypeEntity;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use PhpParser\Node\Stmt\Return_;

class TypeEntities extends Controller
{

    public function index(Request $request)
    {

        try {

            $data =  TypeEntity::get();
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

                    'description' => ['required', 'string', 'max:255'],
                    'name' => 'required|string|max:255|unique:type_entities',
                ];

                //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }

                TypeEntity::create([
                    'description' => $request->description,
                    'name' => $request->name,
                ]);
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

            return  TypeEntity::find($id);
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

            if (isset($request->description)) {

                TypeEntity::find($id)->update([
                    'description' => $request->description,

                ]);
            }
            if (isset($request->name)) {

                TypeEntity::find($id)->update([
                    'name' => $request->name,

                ]);
            }


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

                $TypeEntity = TypeEntity::find($id)->count();

                if ($TypeEntity >= 0) {
                    TypeEntity::find($id)->delete();

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
