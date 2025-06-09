<?php

namespace Database\Factories;

use App\Models\Risk;
use App\Models\RiskType;
use Illuminate\Database\Eloquent\Factories\Factory;

class RiskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    protected $model = RiskType::class;
    public function definition()
    {
        

         /* departaments */
         $RiskTYpes = [

            /**gabinentes */
            ['name' => "Gabinete do Governador"],
            ['name' => "Gabinete Provincial dos Registos e Modernização Administrativa",],
            ['name' => "Gabinete de Comunicação Social",],
            ['name' => "Gabinete Jurídico e de Intercâmbio",],
            ['name' => "Gabinete da Vice-Governadora Patrimônio Serviços Infraestrutura",],
            ['name' => "Secretaria Geral",],
        



        ];

    }
}
