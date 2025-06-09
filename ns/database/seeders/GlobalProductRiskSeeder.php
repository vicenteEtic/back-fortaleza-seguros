<?php

namespace Database\Seeders;

use App\Models\IndicatorType;
use Illuminate\Database\Seeder;

class GlobalProductRiskSeeder extends Seeder
{
    public function run()
    {
        /**IndicatorType */
        $IndicatorType = [

            /**Risco Produtos/ Serviços / Transações 3 */
            [
                'description' => '66290 OUTRAS ACTIVIDADES AUXILIARES DE SEGUROS E FUNDOS DE PENSÕES',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Acidentes Pessoais Desporto',
                'risk' => 'Alto',
                'score' => 3,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Acidentes Pessoais - Escolar',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Acidentes Pessoais - Grupo',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Acidentes Pessoais - Individual',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Acidentes Pessoais - Prestígio',
                'risk' => 'Alto',
                'score' => 3,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Acidentes de Trabalho - Prémio Variável',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Acidentes de Trabalho - Prémio Fixo',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Assistência Em Viagem',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Automóvel Frota',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Automóvel Individual',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Caução',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Aviação',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Mineiro',
                'risk' => 'Médio',
                'score' => 2,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Petroquímica',
                'risk' => 'Médio',
                'score' => 2,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Construção e Montagens',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Equipamento Electrónico',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Avaria de Máquinas',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Máquinas Cascos',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Casco Embarcação',
                'risk' => 'Médio',
                'score' => 2,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Embarcações de Recreio',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Multi Risco Condomínio',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Multi Risco Empresa',
                'risk' => 'Médio',
                'score' => 2,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Multi Risco Habitação',
                'risk' => 'Médio',
                'score' => 2,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Multi Risco Habitação Parceiro',
                'risk' => 'Médio',
                'score' => 2,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Multi Riscos Indústria',
                'risk' => 'Médio',
                'score' => 2,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Protecção à Família',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Responsabilidade Civil - Exploração',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Responsabilidade Civil - Geral',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Responsabilidade Civil - Profissional',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Responsabilidade Civil - Produto',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro de Saúde',
                'risk' => 'Médio',
                'score' => 2,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Transporte de Mercadorias - Aéreo',
                'risk' => 'Alto',
                'score' => 3,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Transporte de Mercadorias - Ferroviário',
                'risk' => 'Alto',
                'score' => 2,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Transporte de Mercadorias - Marítimo',
                'risk' => 'Alto',
                'score' => 3,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Transporte de Mercadorias - Rodoviário',
                'risk' => 'Alto',
                'score' => 2,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Vida Crédito Individual',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],
            [
                'description' => 'Seguro Vida Grupo',
                'risk' => 'Baixo',
                'score' => 1,
                'fk_indicator' => 7,
            ],

        ];

        //inserindo os indicadores
        foreach ($IndicatorType as $value) {
            if (!IndicatorType::where('description', $value['description'])->exists()) {
                IndicatorType::create($value);
            }
        }
    }
}
