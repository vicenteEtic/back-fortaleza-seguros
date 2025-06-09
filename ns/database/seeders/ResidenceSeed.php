<?php

namespace Database\Seeders;

use App\Models\IndicatorType;
use Illuminate\Database\Seeder;

class ResidenceSeed extends Seeder
{
    public function run()
    {
           /**IndicatorType */
           $IndicatorType = [

            /*Residência* */
            ['description' => "Residente", "comment" => "", "risk" => "Baixo", "score" => "1", "fk_indicator" => 4],
            ['description' => "Estrangeiro", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 4],

        ];

        //inserindo os indicadores
        foreach ($IndicatorType as $value) {
            if (!IndicatorType::where('description', $value['description'])->exists()) {
                IndicatorType::create($value);
            }
        }
    }

}
