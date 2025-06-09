<?php

namespace App\Http\Controllers;

use App\Classes\CraftHistory;
use App\Events\testWebsockts;
use App\Models\Account;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{

    private $CraftHistory;
    public function __construct()
    {
        $this->CraftHistory = new CraftHistory;
    }
    public function validateUser()
    {

        return  Auth::user();
    }
    public function register(Request $request)
    {

        //validação do formulario
        $rules = [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8',
        ];

        //retornar erros de validação
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Cria um novo usuário
        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);
        // Cria conta do user


        return response()->json(['message' => 'Parabéns sua conta foi criada faça o login para ter acesso ao seu saldo'], 201);
    }

    /**
     * Realiza o login e retorna um token de acesso.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        // Validação do formulário
        $validator = Validator::make($request->all(), [
            'email' => 'required|email', // Verificar se o e-mail foi fornecido e está no formato correto
            'password' => 'required' // Verificar se a senha foi fornecida
        ]);

        // Verificar se houve erros de validação
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        // Tentar autenticar o usuário
        if (!Auth::attempt($validator->validated())) {
            return response()->json(['message' => 'Credenciais inválidas'], 400);
        }

        // Obter o usuário autenticado
        $user = $request->user();

        // Gerar o token de acesso
        $token = $user->createToken('nf')->plainTextToken;

        User::find(Auth::user()->id)->update([
            'api_token' => $token,
            'last_activity' => now(),

        ]);
        $this->CraftHistory->log('info', 'Iniciou sessão ', Auth::user()->name, Auth::user()->id);
        // Retornar o token de acesso
        return response()->json(['token' => $token], 200);
    }


    /**
     * Realiza o logout do usuário autenticado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $authorizationHeader = $request->header('Authorization');

        if (!$authorizationHeader) {
            return response()->json(['message' => 'Authorization header missing'], 401);
        }


        // Extrair o token do cabeçalho Authorization
        $token = str_replace('Bearer ', '', $authorizationHeader);

        // Verificar se o token é válido
        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['message' => 'Invalid token'], 401);
        } else {


            try {
                User::where('api_token', $token)->update([
                    'api_token' => '',

                ]);

                Auth::guard('api')->logout();

                $request->session()->invalidate();

                $request->session()->regenerateToken();
                return response()->json(['message' => 'Logged out successfully']);
            } catch (\Throwable $th) {
                return response()->json(['message' => 'No access token present'], 400);
            }
        }
    }


    public function issueToken(Request $request)
    {
        $token = parent::issueToken($request);

        // Personalize o token aqui
        $user = $request->user();
        $token->user_id = $user->id;
        $token->custom_data = 'Alguma informação personalizada';

        return $token;
    }
}
