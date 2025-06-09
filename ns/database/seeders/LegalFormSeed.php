<?php

namespace Database\Seeders;

use App\Models\IndicatorType;
use Illuminate\Database\Seeder;

class LegalFormSeed extends Seeder
{
    public function run()
    {
           /**IndicatorType */
           $IndicatorType = [
        /**Forma Juridica da entidade*/
           // ['description' => "Anónima", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Sociedade Anónima", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Sociedade Limitada (LTDA)", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Sociedade Limitada", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Cooperativa", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Associação", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],

           ['description' => "Embaixadas", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Fundações", "comment" => "", "risk" => "Muito Alto", "score" => "20", "fk_indicator" => 3],
           ['description' => "Empresas Públicas", "comment" => "", "risk" => "Baixo", "score" => "1", "fk_indicator" => 3],
           ['description' => "Estab. Públicos", "comment" => "", "risk" => "Baixo", "score" => "1", "fk_indicator" => 3],
           ['description' => "Nome Colectivo", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Sociedade em nome colectivo", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Sociedade em nome em nome indivual", "comment" => "", "risk" => "Alto", "score" => "2", "fk_indicator" => 3],

         //  ['description' => "Sociedade anónimas", "comment" => "", "risk" => "Baixo", "score" => "1", "fk_indicator" => 3],
           ['description' => "Sociedade Sociedade em comandita por acções", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],

           ['description' => "Sociedade em comandita simples", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],

           ['description' => "Soc. Advogados", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Part. Políticos", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Org.S/FimLucrat", "comment" => "", "risk" => "Muito Alto", "score" => "20", "fk_indicator" => 3],
           ['description' => "Quot.Unipessoal", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Sociedade por Quotas", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],
           ['description' => "Sociedade por quotas", "comment" => "", "risk" => "Alto", "score" => "3", "fk_indicator" => 3],

           ['description' => "Universidades", "comment" => "", "risk" => "Baixo", "score" => "1", "fk_indicator" => 3],
           ['description' => "Outras", "comment" => "", "risk" => "Médio", "score" => "2", "fk_indicator" => 3],

           //Forma Juridica da entidade
        ];

        //inserindo os indicadores
        foreach ($IndicatorType as $value) {
            if (!IndicatorType::where('description', $value['description'])->exists()) {
                IndicatorType::create($value);
            }
        }
    }
}
