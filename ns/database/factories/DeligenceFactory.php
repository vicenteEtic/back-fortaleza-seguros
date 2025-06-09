<?php

namespace Database\Factories;

use App\Models\DiligenceLevel;
use Illuminate\Database\Eloquent\Factories\Factory;

class DeligenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

     protected $model = DiligenceLevel::class;
    public function definition()
    {
          /* departaments */
          $Deligences = [

            /**gabinentes */
            ['name' => "Diligência Simplificada"],
            ['name' => "Diligência Standard",],
            ['name' => "Diligência Reforçada",],
            ['name' => "Cliente Inaceitável",],
        ];


        //inserindo os departamentos
        foreach ($Deligences as $value) {
            DiligenceLevel::create($value);
        }

        

    }
}
