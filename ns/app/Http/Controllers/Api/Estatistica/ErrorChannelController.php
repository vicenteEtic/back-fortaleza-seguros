<?php

namespace App\Http\Controllers\Api\Estatistica;

use App\Http\Controllers\Controller;
use App\Models\ErrorEvaluation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ErrorChannelController extends Controller
{
    public function index(Request $request)

    {
        // Obtém o ano da requisição ou usa o ano atual, caso não seja fornecido


        $year = $this->getYear($request);
        $anos = $this->getDistinctYears();
        // Contagem de erros agrupados por canal e mês, excluindo o canal específico
        $results = DB::table('error_evaluations')
            ->select(
                'channel', // Nome do canal
                DB::raw('MONTH(created_at) AS month'), // Mês do erro
                DB::raw('MONTHNAME(created_at) AS monthName'), // Nome do mês
                DB::raw('COUNT(*) AS total_geral') // Contagem de erros por canal e mês
            )
            ->where('channel', '!=', 'Incapacidade em obter os dados') // Exclui o canal específico
            ->whereYear('created_at', $year) // Filtra pelo ano fornecido (ou o ano atual)
            ->groupBy('channel', 'month', 'monthName') // Agrupa por canal e mês
            ->orderBy('month') // Ordena pelos meses
            ->get(); // Obtém os resultados

        // Organiza os resultados para exibir por canal, com os meses como subarray
        $formattedResults = $this->formatResults($results);

        // Retorna os resultados formatados como JSON

                    $result = [
                        'year' => $year,
                        'years' => $anos,
                        'errors'=> $formattedResults,

                    ];

                    return $result;
        return response()->json($formattedResults);
    }
    private function getYear(Request $request): int
    {
        return is_numeric($request->year) ? (int)$request->year : (int)date('Y');
    }
    private function getDistinctYears(): array
    {
        return ErrorEvaluation::select(DB::raw('YEAR(created_at) as ano'))
            ->distinct()
            ->orderBy('ano', 'desc')
            ->pluck('ano')
            ->toArray();
    }
    private function formatResults($results)
    {
        $formattedData = [];

        // Organiza os dados por canal
        foreach ($results as $data) {
            $channel = $data->channel;
            $month = $data->month;

            $monthName = $this->translateMonth((int)$month);

            $total = $data->total_geral;

            // Verifica se o canal já foi adicionado
            if (!isset($formattedData[$channel])) {
                $formattedData[$channel] = [
                    'channel' => $channel,
                    'data' => [],

                ];
            }

            // Adiciona os dados do mês para o canal
            $formattedData[$channel]['data'][] = [
                'month' => $monthName,
                'total' => $total
            ];
        }

        // Retorna os dados formatados
        return array_values($formattedData); // Converte o array associativo para numérico
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
