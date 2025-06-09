<?php

namespace App\Classes;


class confStatus
{
    public function confStatus()
    {

        $response['statusMapping']  = [
            '1' => 'Pendente',
            '2' => 'Em andamento',
            '3' => 'Despachado',
            '4' => 'Arquivado',
            '5' => 'Revisão',
        ];
        $response['phasesMapping']  = [
            '1' => 'Entrada No Guichê',
            '2' => 'Entrada No Gab. da Vice Governadora',
            '3' => 'Entrada No IGCA',
            '4' => 'Retornado Pelo IGCA',
            '5' => 'Entrada No Gab. do Governador',
            '6' => 'Aprovado pelo  Governador',

        ];

        $response['purposeMapping']  = [
            '0' => 'Agrícolas',
            '1' => 'Habitacional',
            '2' => 'Turístico hoteleiro',
            '3' => 'Estaleiro',
            '4' => 'Salineira',
        ];
        return $response;
    }
}
