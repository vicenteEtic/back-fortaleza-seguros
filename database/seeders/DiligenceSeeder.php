<?php

namespace Database\Seeders;

use App\Models\Diligence;
use App\Models\Diligence\Diligence as DiligenceDiligence;
use Illuminate\Database\Seeder;

class  DiligenceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $RiskType = [

            ['risk' => "Baixo", 'name' => 'Simplificada', 'min' => "0", 'max' => "10", 'color' => "#92D050"],
            ['risk' => "Médio", 'name' => 'Standard', 'min' => "12", 'max' => "19", 'color' => "#ffc107"],
            ['risk' => "Alto", 'name' => 'Reforçada', 'min' => "20", 'max' => "100", 'color' => "#FFC000"],
            ['risk' => "Inaceitável", 'name' => 'Cliente Inaceitável', 'min' => "101", 'max' => "150", 'color' => "#ff0000"],
        ];

        //inserindo os departamentos
        foreach ($RiskType as $value) {
            DiligenceDiligence::create($value);
        }
    }
}
