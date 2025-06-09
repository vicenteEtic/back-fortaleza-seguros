<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [

            ['first_name' => "admin"   ,'first_name' => "admin", 'email' => "etic@admin.com", 'email_verified_at' => now(), 'password' => bcrypt("12345678"), 'remember_token' => Str::random(10), 'role_id' => 1],
            ['first_name' => "etic", 'email' => "etic2@admin.com", 'email_verified_at' => now(), 'password' => bcrypt("12345678"), 'remember_token' => Str::random(10), 'role_id' => 1],

        ];

        //inserindo os departamentos
        foreach ($user as $value) {
            User::create($value);
        }
    }
}
