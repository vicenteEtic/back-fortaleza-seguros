<?php

namespace Database\Seeders;

use App\Models\RolePermission;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /* documentType */
        $RolePermission = [
            ['name' => "GERENCIAR_USUARIO", 'fk_role' => '1'],
            ['name' => "GERENCIAR_ESTATISTICA", 'fk_role' => '1'],
            ['name' => "GERENCIAR_REGRA", 'fk_role' => '1'],
            ['name' => "CRIAR_AVALIACOES", 'fk_role' => '1'],
            ['name' => "LISTAR_AVALIACOES", 'fk_role' => '1'],
        ];


        //inserindo os documentType
        foreach ($RolePermission as $value) {
            RolePermission::create($value);
        }
    }
}
