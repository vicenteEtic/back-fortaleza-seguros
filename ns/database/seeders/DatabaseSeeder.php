<?php

namespace Database\Seeders;




use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserSeeder::class);
        $this->call(RiskTypeSeeder::class);
        $this->call(RolePermissionSeeder::class);

        $this->call(IndicatorSeeder::class);
        $this->call(IdentificationCapacitySeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(RolePermissionSeeder::class);
        $this->call(ResidenceSeed::class);
        $this->call(EstablishmentSeed::class);
        $this->call(LegalFormSeed::class);
        $this->call(CAESeed::class);

        $this->call(PEPSeed::class);

        $this->call(InsuranceTypeSeed::class);
        $this->call(CountriesSeed::class);
        $this->call(CountriesSeed::class);
        $this->call(TypeActivitySeed::class);

        $this->call(ProfissionPSeed::class);
        $this->call(GlobalCAESeed::class);
        $this->call(GlobalProductRiskSeeder::class);
        $this->call(GlobalChannelSeed::class);

        //$this->call(ChannelSeed::class);
        //$this->call(ProductRiskSeeder::class);
       // $this->call(CAESeed::class);
        //\App\Models\User::factory(1)->create();


    }
}
