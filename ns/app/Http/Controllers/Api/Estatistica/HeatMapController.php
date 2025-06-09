<?php

namespace App\Http\Controllers\Api\Estatistica;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Diligence;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeatMapController extends Controller
{

    public function index(Request $request)
    {
        $year = $this->getYear($request);
        $anos = $this->getDistinctYears();
        $monthlyData = $this->getMonthlyData($year);

        // Formata os resultados corretamente
        $results = $this->formatResults($year, $monthlyData, $anos);

        return response()->json($results, 200);
    }

    private function getYear(Request $request): int
    {
        return is_numeric($request->year) ? (int)$request->year : (int)date('Y');
    }

    private function getDistinctYears(): array
    {
        return Assessment::select(DB::raw('YEAR(created_at) as ano'))
            ->distinct()
            ->orderBy('ano', 'desc')
            ->pluck('ano')
            ->toArray();
    }

    private function getMonthlyData(int $year): array
    {
        $monthlyData = DB::table('type_assessments as a')
            ->select(
                DB::raw('MONTH(a.created_at) AS month'),
                DB::raw('MONTHNAME(a.created_at) AS monthName'),
                DB::raw('a.diligence AS name'),
                DB::raw('COUNT(*) AS total'),
                'd.color'  // Supondo que a cor esteja na tabela 'diligences'
            )
            ->join('diligences as d', 'd.name', '=', 'a.diligence') // Adiciona o JOIN com a tabela de diligências
            ->whereYear('a.created_at', $year)
            ->groupBy('month', 'monthName', 'name', 'd.color')  // Agora estamos agrupando pela cor também
            ->orderBy('month')
            ->get()
            ->toArray();

        return $monthlyData;
    }



    private function formatResults(int $year, array $monthlyData, array $anos): array
    {
        $formattedData = [];

        foreach ($monthlyData as $data) {
            $month = $this->translateMonth((int)$data->month); // Nome do mês em português
            $diligence = $data->name; // Nome da diligência

            // Verifica se a diligência já existe no array
            if (!isset($formattedData[$diligence])) {
                $formattedData[$diligence] = [
                    'diligence' => $diligence,
                    'color' => $data->color,  // Agora a cor está disponível no objeto
                    'data' => [] // Inicia um array vazio para os meses
                ];
            }

            // Adiciona os dados do mês apenas se total for maior que zero
            if ($data->total > 0) {
                $formattedData[$diligence]['data'][] = [
                    'month' => $month,
                    'total' => $data->total,
                ];
            }
        }


    
        $result = [
            'year' => $year,
            'diligences' => array_values($formattedData), // Converte para um array numérico
            'years' => $anos,

        ];

        return $result;
    }





    private function translateMonth(int $month): string
    {
        $months = [
            1 => 'Janeiro',
            2 => 'Fevereiro',
            3 => 'Março',
            4 => 'Abril',
            5 => 'Maio',
            6 => 'Junho',
            7 => 'Julho',
            8 => 'Agosto',
            9 => 'Setembro',
            10 => 'Outubro',
            11 => 'Novembro',
            12 => 'Dezembro',
        ];

        return $months[$month] ?? 'Mês inválido';
    }
}
