<?php

namespace Database\Seeders;

use App\Models\IndicatorType;
use Illuminate\Database\Seeder;

class IdentificationCapacitySeeder extends Seeder
{
    public function run()
    {
        $IndicatorType = [
            ['description' => "Capacidade para realizar a totalidade dos procedimentos de ID&V", "comment" => "", "risk" => "Baixo", "score" => "1", "fk_indicator" => 1],
        ];

        //inserindo os indicadores
        foreach ($IndicatorType as $value) {
            if (!IndicatorType::where('description', $value['description'])->exists()) {
                IndicatorType::create($value);
            }
        }
    }
}
