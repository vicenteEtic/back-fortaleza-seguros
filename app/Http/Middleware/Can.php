<?php

namespace App\Http\Middleware;

use App\Services\Cliente\Usuario\UsuarioPermissaoService;
use App\Services\Permission\PermissionTypeUserService;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class Can
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next, ...$permissoes)
    {
        if (self::checkPermissions($permissoes)) {
            return $next($request);
        }

        return redirect('/painel')->with("error_alert", "Não tem permissão para aceder a este Modulo ou não esta disponivel no seu contrato");
    }

    private function checkPermissions(array $permissions): bool
    {

        foreach ($permissions as $permissionSet) {
            if (str_contains($permissionSet, '|')) {
                $orPermissions = explode('|', $permissionSet);
                $hasAtLeastOne = false;

                foreach ($orPermissions as $permission) {
                    if (self::check($permission)) {
                        $hasAtLeastOne = true;
                        break;
                    }
                }

                if (!$hasAtLeastOne) {
                    return false; // Falhou na verificação "ou"
                }
            } else {
                // Verifica se o usuário tem a permissão individual
                if (!self::check($permissionSet)) {
                    return false;
                }
            }
        }

        return true; // O usuário possui todas as permissões necessárias
    }

    /**
     * Verifica se o usuário da requisição atual tem a permissão informada.
     */
    public static function check(?string $rule): bool
    {
        if ($rule == null) {
            return false;
        }

        if (Auth::user()) {
            return Auth::user()->can($rule);
        }

        return false;
    }
}
