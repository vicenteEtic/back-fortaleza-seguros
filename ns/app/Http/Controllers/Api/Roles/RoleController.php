<?php

namespace App\Http\Controllers\Api\Roles;

use App\Classes\CraftHistory;
use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\RolePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Return_;

class RoleController extends Controller
{

    private $CraftHistory;
    public function __construct()
    {
        $this->CraftHistory = new CraftHistory;
    }
    public function index()
    {

        try {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                //Logger

                $response = Role::get();
                $data = [];

                foreach ($response as $item) {
                    $dados = RolePermission::where('fk_role', $item->id)->get();
                    $documentData = [];

                    foreach ($dados as $row) {
                        $documentData[] = $row->name;
                    }
                    $data[] = [
                        'name' => $item->name,
                        'id' => $item->id,
                        'description' => $item->description,
                        'permissions' => $documentData,
                         ];
                }

                return $data;
            } else {

                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Falha ao  listar Roles "
            ], 400);
        }
    }


    public function store(Request $request)
    {


        try {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //validação do formulario
                $rules = [
                    'name' => 'required|unique:roles,name,' . $request->name, // Verificar se existe  o nome
                    'permissions' => 'required'


                ]; //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }

                $role =  Role::create([
                    'name' => $request->name,
                    'description' => $request->description
                ]);
                $this->CraftHistory->log('info', 'Cadastrou uma permissão com o nome ' . $request->name, Auth::user()->name, Auth::user()->id);
                for ($a = 0; $a < count($request->permissions); $a++) {

                    RolePermission::create([
                        'name' => $request->permissions[$a],
                        'fk_role' => $role->id
                    ]);
                }

                return response()->json(['message' => "cadastrado com sucesso"], 201);
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }

        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao cadastrar role"
            ], 400);
        }
    }


    public function show($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {

                $Document = Role::find($id)->count();

                if ($Document >= 0) {
                    $response  = Role::find($id);

                    $this->CraftHistory->log('info', 'Visualizou uma permissão com o Identificador ' . $id, Auth::user()->name, Auth::user()->id);
                    return response()->json($response, 200);
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
                "message" => "Erro ao pesquisar Document"
            ], 400);
        }
    }


    public function update(Request $request, $id)
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
                //validação do formulario
                $rules = [
                    'name' => 'required|', // Verifica se exite name do directory
                    'permissions' => 'required|', // Verifica se exite name do directory
             ]; //retornar erros de validação

                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }
                $Role = Role::find($id)->count();

                if ($Role >= 0) {
                    $response['Role'] =   Role::find($id)->update([
                        'name' => $request->name,
                        'description' => $request->description
                    ]);
                    RolePermission::where('fk_role','=',$id)->delete();

                    for ($a = 0; $a < count($request->permissions); $a++) {

                        RolePermission::create([
                            'name' => $request->permissions[$a],
                            'fk_role' => $id
                        ]);
                    }
                    $this->CraftHistory->log('info', 'Editou uma permissão com o Identificador ' . $id, Auth::user()->name, Auth::user()->id);
                    return response()->json([
                        "message" => "Role atualizado"
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Role não encontrado"
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao atualizar Role"
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

                $Role = Role::find($id)->count();

                if ($Role >= 0) {
                    Role::find($id)->delete();
                    $this->CraftHistory->log('info', 'Apagou uma permissão com o Identificador ' . $id, Auth::user()->name, Auth::user()->id);
                    return response()->json([
                        "message" => "Role apagado com sucesso"
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Role não encontrado"
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao apagar Role"
            ], 400);
        }
    }
}
