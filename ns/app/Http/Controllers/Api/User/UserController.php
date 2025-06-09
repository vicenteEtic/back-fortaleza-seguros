<?php

namespace App\Http\Controllers\Api\User;

use App\Classes\CraftHistory;
use App\Http\Controllers\Controller;

use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Providers\RouteServiceProvider;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use PhpParser\Node\Stmt\Return_;

class UserController extends Controller
{


    private $CraftHistory;
    public function __construct()
    {
        $this->CraftHistory = new CraftHistory;
    }

    public function profileLoger(Request $request)
    {
        try {
        $user = Auth::user();
        $userInformation = $request->session()->get('userInformation');
        $ShowUser = [
            'role' => $userInformation['role'],
            'permissions' => $userInformation['role']['permissions'],
        ];

        $data = [
            "id" => $user['id'],
            "first_name" => $user['first_name'],
            "email" => $user['email'],
            "phone" => $user['phone'],
            "last_name" => $user['last_name'],
            'role' => [
                'name' =>   $ShowUser['role']['name'],
                'id' => $ShowUser['role']['id'],
                "permissions" => $ShowUser['permissions'],
            ],

            "created_at" => $user['created_at'],
            "updated_at" => $user['updated_at']
        ];

        return response()->json($data, 200);


        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Falha ao verificar perfil do  user faça o login "
            ], 400);
        }
    }

    public function index(Request $request)
    {

        try {

            $data =  User::with('role')->get();
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Falha ao listar usuários"
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
                $value=$request->password;
                Validator::extend('password_requirements', function ($attribute, $value, $parameters, $validator) {
                    // Verifica se a senha tem pelo menos 8 caracteres, um número e um caractere especial
                    return preg_match('/^(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/', $value);

                });

                // Registre a mensagem de erro para a regra personalizada
                Validator::replacer('password_requirements', function ($message, $attribute, $rule, $parameters) {
                    return 'A senha deve ter pelo menos 8 caracteres, incluir um número e um caractere especial.';
                });


                $rules = [

                    'first_name' => ['required', 'string', 'max:255'],
                    'email' => 'required|string|email|max:255|unique:users',
                    'password' => 'required|password_requirements',
                    'role_id' => 'required|numeric',
                  ];

                //retornar erros de validação
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }

                User::create([
                    'first_name' => $request->first_name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'role_id' => $request->role_id,
                    'enabled' => true,
                    'last_name' => $request->last_name,
                    'password' => Hash::make($request->password),
                ]);

                $this->CraftHistory->log('info', 'Cadastrou um usuário com o nome ' . $request->first_name . ' ' . $request->last_name, Auth::user()->name, Auth::user()->id);
                return response()->json(['message' => "cadastrado com sucesso"], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao cadastrar usuário"
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

            return  User::find($id);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao pesquisar usuário"
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

            if (isset($request->first_name)) {

                User::find($id)->update([
                    'first_name' => $request->first_name, ]);
            }
            if (isset($request->last_name)) {

                User::find($id)->update([
                    'last_name' => $request->last_name,]);
            }
            if (isset($request->enabled)) {
                User::find($id)->update([
                    'enabled' => $request->enabled,]);
            }

            if (isset($request->role_id)) {

                User::find($id)->update([
                    'role_id' => $request->role_id, ]);
            }

            if (isset($request->phone)) {

                User::find($id)->update([
                    'phone' => $request->phone,

                ]);
            }
            if (isset($request->email)) {

                User::find($id)->update([
                    'email' => $request->email,

                ]);
            }

            if (isset($request->password)) {

                User::find($id)->update([
                    'password' => Hash::make($request->password),
                ]);
            }

            $this->CraftHistory->log('info', 'Atualizou os dados  do usuário com o Identificador ' . $id, Auth::user()->name, Auth::user()->id);

            return response()->json([
                "message" => "usuário atulizado com sucesso"
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao atualizar usuário"
            ], 400);
        }
    }


    public function destroy($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

                $User = User::find($id)->count();

                if ($User >= 0) {
                    User::find($id)->delete();


                    $this->CraftHistory->log('info', 'Apagou os dados  do usuário com o Identificador ' . $id, Auth::user()->name, Auth::user()->id);
                    return response()->json([
                        "message" => "Usuário apagado com sucesso"
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Usuário não encontrado"
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido."
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao apagar Usuário"
            ], 400);
        }
    }
}
