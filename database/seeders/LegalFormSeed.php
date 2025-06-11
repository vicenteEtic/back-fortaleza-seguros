<?php

namespace Database\Seeders;

use App\Models\Indicator\IndicatorType as IndicatorIndicatorType;
use App\Models\IndicatorType;
use Illuminate\Database\Seeder;

class LegalFormSeed extends Seeder
{
    public function run()
    {
           /**IndicatorType */
           $IndicatorType = [
        /**Forma Juridica da entidade*/
           // ['description' => "Anónima",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Sociedade Anónima",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Sociedade Limitada (LTDA)",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Sociedade Limitada",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Cooperativa",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Associação",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],

           ['description' => "Embaixadas",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Fundações",  "risk" => "Muito Alto", "score" => "20", "indicator_id" => 3],
           ['description' => "Empresas Públicas",  "risk" => "Baixo", "score" => "1", "indicator_id" => 3],
           ['description' => "Estab. Públicos",  "risk" => "Baixo", "score" => "1", "indicator_id" => 3],
           ['description' => "Nome Colectivo",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Sociedade em nome colectivo",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Sociedade em nome em nome indivual",  "risk" => "Alto", "score" => "2", "indicator_id" => 3],

         //  ['description' => "Sociedade anónimas",  "risk" => "Baixo", "score" => "1", "indicator_id" => 3],
           ['description' => "Sociedade Sociedade em comandita por acções",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],

           ['description' => "Sociedade em comandita simples",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],

           ['description' => "Soc. Advogados",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Part. Políticos",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Org.S/FimLucrat",  "risk" => "Muito Alto", "score" => "20", "indicator_id" => 3],
           ['description' => "Quot.Unipessoal",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Sociedade por Quotas",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],
           ['description' => "Sociedade por quotas",  "risk" => "Alto", "score" => "3", "indicator_id" => 3],

           ['description' => "Universidades",  "risk" => "Baixo", "score" => "1", "indicator_id" => 3],
           ['description' => "Outras",  "risk" => "Médio", "score" => "2", "indicator_id" => 3],

           //Forma Juridica da entidade
        ];

        //inserindo os indicadores
        foreach ($IndicatorType as $value) {
            if (!IndicatorIndicatorType::where('description', $value['description'])->exists()) {
                IndicatorIndicatorType::create($value);
            }
        }
    }
}
