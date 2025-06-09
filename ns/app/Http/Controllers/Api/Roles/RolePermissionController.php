<?php

namespace App\Http\Controllers\Api\Roles;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RolePermissionController extends Controller
{

    public function index()
    {


        try {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {

                $response = [

                    ['name' => "GERENCIAR_USUARIO"],
                    ['name' => "GERENCIAR_ESTATISTICA"],
                    ['name' => "GERENCIAR_REGRA"],
                    ['name' => "GERENCIAR_ENTIDADES"],


                    ['name' => "CRIAR_AVALIACOES"],
                    ['name' => "LISTAR_AVALIACOES"],

                    ['name' => "LISTAR_CANAIS"],
                    ['name' => "EDITAR_CANAIS"],
                    ['name' => "CRIAR_CANAIS"],

                    ['name' => "LISTAR_CATEGORIAS"],
                    ['name' => "EDITAR_CATEGORIAS"],
                    ['name' => "CRIAR_CATEGORIAS"],

                    ['name' => "LISTAR_PAISES"],
                    ['name' => "EDITAR_PAISES"],
                    ['name' => "CRIAR_PAISES"],

                    ['name' => "LISTAR_RISCOS_DE_PRODUTOS"],
                    ['name' => "EDITAR_RISCOS_DE_PRODUTOS"],
                    ['name' => "CRIAR_RISCOS_DE_PRODUTOS"],

                    ['name' => "LISTAR_DILIGENCIAS"],
                    ['name' => "EDITAR_DILIGENCIAS"],
                    ['name' => "CRIAR_DILIGENCIAS"],
                    ['name' => "LISTAR_PROFISSOES"],
                    ['name' => "EDITAR_PROFISSOES"],
                    ['name' => "CRIAR_PROFISSOES"],
                    ['name' => "CRIAR_CAE"],
                    ['name' => "EDITAR_CAE"],
                    ['name' => "LISTAR_CAE"],


                ];
                return $response;
            } else {

                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Falha ao  Listar Permissions "
            ], 400);
        }
    }


    public function store(Request $request)
    {

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //validação do formulario
                $rules = [
                    'name' => 'required',
                    'fk_role' => 'required' // Verifica o nome

                ]; //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }

                $response['RolePermission'] =   RolePermission::create([
                    'name' => $request->name,
                    'fk_role' => $request->fk_role
                ]);

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


    public function show($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {

                $RolePermission = RolePermission::find($id)->count();

                if ($RolePermission >= 0) {
                    $response  = RolePermission::find($id);
                    return response()->json($response, 200);
                } else {
                    return response()->json([
                        "message" => "RolePermission não encontrado"
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao pesquisar RolePermission"
            ], 400);
        }
    }


    public function update(Request $request, $id)
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] === 'Post') {
                //validação do formulario
                $rules = [

                    'name' => 'required',
                    'fk_role' => 'required' // Verifica o nome

                ]; //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }
                $RolePermission = RolePermission::find($id)->count();

                if ($RolePermission >= 0) {
                    $response['RolePermission'] =   RolePermission::find($id)->update([
                        'name' => $request->name,
                        'fk_role' => $request->fk_role
                    ]);


                    return response()->json([
                        "message" => "RolePermission atualizado"
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "RolePermission não encontrado"
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao atualizar RolePermission"
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

                $RolePermission = RolePermission::find($id)->count();

                if ($RolePermission >= 0) {
                    RolePermission::find($id)->delete();

                    return response()->json([
                        "message" => "Document apagado com sucesso"
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Document não encontrado"
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao apagar Document"
            ], 400);
        }
    }
}
