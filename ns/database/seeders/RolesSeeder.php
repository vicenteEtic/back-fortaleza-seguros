<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
   /* Roles */
   $Roles = [
    ['name' => "Administrator", 'description' => 'Descrição da Regra'],
];

//inserindo os document
foreach ($Roles as $value) {
    Role::create($value);
}
    }
}
