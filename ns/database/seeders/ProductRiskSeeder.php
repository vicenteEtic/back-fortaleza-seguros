<?php

namespace Database\Seeders;

use App\Models\IndicatorType;
use Illuminate\Database\Seeder;

class ProductRiskSeeder extends Seeder
{
    public function run()
    {
        /**IndicatorType */
        $IndicatorType = [

 /**Risco Produtos/ Serviços / Transações 3 */

 ['description' => 'seguro de Propriedade Comercial A.P. - Desporto', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'seguro de Propriedade Comercial A.P. - Escolar', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'Seguro de Saúde e Lesões A.P. - Grupo', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 7],
 ['description' => 'Seguro de Saúde e Lesões A.P. - Individual', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 7],
 ['description' => 'Seguro de Saúde e Lesões A.P. - Prestígio', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 7],
 ['description' => 'AT - Conta de Outrem', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'AT - Prémio Fixo', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'Seguro Automóvel Automóvel Frota', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 7],
 ['description' => 'Seguro Automóvel Automóvel Individual', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 7],
 ['description' => 'Seguro de Aviação Aviação', 'risk' => 'Alto', 'score' => 3, 'fk_indicator' => 7],
 ['description' => 'Seguro de Maritimo de Casco e Máquina Casco', 'risk' => 'Alto', 'score' => 3, 'fk_indicator' => 7],
 ['description' => 'Seguros Maritimos Embarcações de Recreio', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'seguro de Propriedade Comercial Máquinas Cascos', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'seguro de Propriedade Condomínio Multi Riscos Condominio', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'seguro de Propriedade Comercial Multi Riscos Empresa', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'seguro de propriedade Residencial Multi Riscos Habitação', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'seguro de Propriedade Comercial Multi Riscos Indústria', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'seguro de propriedade Residencial Multirriscos Habitação', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'Seguro de Saúde e Lesões Protecção à Família', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 7],
 ['description' => 'seguro de Propriedade Comercial R.C. - Exploração', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'seguro de Propriedade Comercial R.C. - Geral', 'risk' => 'Médio', 'score' => 2, 'fk_indicator' => 7],
 ['description' => 'Seguro de Saúde e Lesões R.C. - Profissional', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 7],
 ['description' => 'Seguro de Saúde e Lesões Saúde AdvanceCare', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 7],
 ['description' => 'Seguro de Automóveis T. M. - Rodoviário', 'risk' => 'Baixo', 'score' => 1, 'fk_indicator' => 7],
 ['description' => 'Seguro de Vida Vida Crédito Individual', 'risk' => 'Muito Alto', 'score' => 20, 'fk_indicator' => 7],
 [
    'description' => '66220 ACTIVIDADES DE MEDIADORES DE SEGUROS',
    'risk' => 'Baixo',
    'score' => 1,
    'fk_indicator' => 7,],
[
    'description' => '66290 OUTRAS ACTIVIDADES AUXILIARES DE SEGUROS E FUNDOS DE PENSÕES',
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
