<?php


namespace App\Helpers;

class Utils
{
    public static function verificarIntervalo($numero, $intervalos)
    {
        foreach ($intervalos as $intervalo) {
            if ($numero >= $intervalo['min'] && $numero <= $intervalo['max']) {
                return $intervalo;
            }
        }
        return   ['risk' => "Inaceitável", 'name' => 'Cliente Inaceitável', 'min' => "101", 'max' => "150", 'color' => "#ff0000"];
    }
}
