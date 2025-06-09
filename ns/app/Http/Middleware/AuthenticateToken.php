<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\RolePermission;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;



class AuthenticateToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {


        $authorizationHeader = $request->header('Authorization');
        // Verifica se o token de autenticação está presente no cabeçalho da solicitação
        if (!$authorizationHeader) {
            return response()->json(['error' => 'Token de autenticação ausente'], 401);
        }

        if (!str_contains($authorizationHeader, ' ')) {
            return response()->json(['error' => 'Formato de cabeçalho de autorização inválido'], 401);
        }

        if (!$authorizationHeader) {
            return response()->json(['message' => 'Authorization header missing'], 401);
        }
        // Extrair o token do cabeçalho Authorization
        $token = str_replace('Bearer ', '', $authorizationHeader);
        // Verificar se o token é válido
        $user = User::where('api_token', $token)->first();

        if (!$user) {
            return response()->json(['error' => 'Token de autenticação inválido'], 401);
        } else {
            auth()->login($user);
        }


        $roles = RolePermission::where('fk_role', Auth::user()->role_id)->get();

        foreach ($roles as $item) {
            $dataArray[] = $item->name;
        }
        $role = Role::find(Auth::user()->role_id);

        $data = [
            'role' => [
                'name' =>   $role->name,
                'id' => Auth::user()->role_id,
                "permissions" => $dataArray,
            ],
        ];

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->last_activity && now()->diffInMinutes($user->last_activity) >= 120) {
                Auth::logout();
                $user->update(['api_token' => '']);
                return response()->json(['message' => 'Sessão expirada devido à inatividade'], 401);
            }
            // Atualiza a última atividade
            $user->update(['last_activity' => now()]);
        }

        $request->session()->put('userInformation', $data);
        // O token é válido, continue com a solicitação
        return $next($request);
    }
}
