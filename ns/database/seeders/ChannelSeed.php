<?php

namespace Database\Seeders;

use App\Models\IndicatorType;
use Illuminate\Database\Seeder;

class ChannelSeed extends Seeder
{
    public function run()
    {
        /**IndicatorType */
        $IndicatorType = [

            //start canal
            ['description' => 'A Eternidade - Mediação de Seguros, Lda', 'risk' => 'Baixo', 'score' => 2, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Benguela', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Benguela - CFB', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Huambo - Caála', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Huambo - Agência Huambo', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - 1º Bairro Fiscal', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - 4 de Fevereiro', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Alvalade', 'risk' => 'Baixo', 'score' => 2, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Assembleia Nacional', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Atlântico', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Bºsede', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Calemba 2', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Gpl/Arredores', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Hoji Ya Henda', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Kapolo II', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Katyavala', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Km 30', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Maculusso', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Samba', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - São Paulo', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Luanda - Vila Alice', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Lubango - Millenium', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Namibe', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Ndalatando - Bué', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Ondjiva', 'risk' => 'Baixo', 'score' => 2, 'fk_indicator' => 11],
            ['description' => 'Agência BCI - Sumbe', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],

            ['description' => 'Agência BK - Aeroporto', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Agência Sede Gika', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Belo Horizonte 540', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Benguela', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Cabinda', 'risk' => 'Baixo', 'score' => 2, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Cacuaco', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Camama Ispeka', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Camama Multicenter', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Cimangola', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Cuca', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Huambo', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Kilamba Kiaxi', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Lobito', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Lobito Restinga', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Luanda', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Luanda - Bueiro', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Luanda - Camama', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Luanda - São Paulo', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Luanda - Sede', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Luanda - Sede 502', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Luanda - Talatona', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Luanda - Zango', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Malange', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Namibe', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Ndalatando', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Ondjiva', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Agência BK - Sumbe', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],

            ['description' => 'Banco Yetu - Agência Sede (501)', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Banco Yetu - Agência Saurimo (801)', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],

            ['description' => 'Banco de Comércio e Indústria', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Banco de Fomento Angola', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Banco Nacional de Angola', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Banco Privado Atlântico', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Banco de Desenvolvimento de Angola', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],

            ['description' => 'Mediasc', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Seguradora Mundial', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Seguradora Nacional', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],
            ['description' => 'Société Générale', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 11],

            ['description' => 'Exu-Mediadores de Seguros, Lda', 'risk' => 'Baixo', 'score' => 2, 'fk_indicator' => 11],
        



        ];

        //inserindo os indicadores
        foreach ($IndicatorType as $value) {
            if (!IndicatorType::where('description', $value['description'])->exists()) {
                IndicatorType::create($value);
            }
        }
    }
}
