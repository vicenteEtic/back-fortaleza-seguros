<?php

namespace Database\Seeders;

use App\Models\IndicatorType;
use Illuminate\Database\Seeder;

class EstablishmentSeed extends Seeder
{
    public function run()
    {
           /**IndicatorType */
           $IndicatorType = [

           /**Forma de Estabelecimento de relação de negócio */
           ['description' => "Presencial", "comment" => "", "risk" => "Baixo", "score" => "1", "fk_indicator" => 2],
           ['description' => "Não Presencial (Internet/ Mobile / App)", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 2],
        ];

        //inserindo os indicadores
        foreach ($IndicatorType as $value) {
            if (!IndicatorType::where('description', $value['description'])->exists()) {
                IndicatorType::create($value);
            }
        }
    }

}
