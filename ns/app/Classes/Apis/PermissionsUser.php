<?php

namespace App\Apis\Alfresco;

use Illuminate\Http\Request;

class PermissionsUser
{
    public function index( $permissionsType,$permissions)
    {
        /***validar permissão de user */

        $editar_registro_key = array_search($permissionsType, $permissions);
        return $editar_registro_key;
    }
}
