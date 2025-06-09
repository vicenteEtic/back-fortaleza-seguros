<?php

namespace App\Http\Controllers\Api\Estatistica;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChannelController extends Controller
{

    public function index()
    {

        $results['coletive'] = DB::table('type_assessments as a')
            ->join('entities as b', 'a.fk_entities', '=', 'b.id')
            ->select(
                DB::raw('a.channel AS name'),
                DB::raw('SUM(CASE WHEN a.risklevel = "Baixo" THEN 1 ELSE 0 END) AS total_baixo'),
                DB::raw('SUM(CASE WHEN a.risklevel = "Médio" THEN 1 ELSE 0 END) AS total_medio'),
                DB::raw('SUM(CASE WHEN a.risklevel = "Alto" THEN 1 ELSE 0 END) AS total_alto'),
                DB::raw('COUNT(*) AS total_geral')
            )
            ->where('b.entity_type', 2)
            ->groupBy('a.channel')
            ->get();

        $results['individual'] = DB::table('type_assessments as a')
            ->join('entities as b', 'a.fk_entities', '=', 'b.id')
            ->select(
                DB::raw('a.channel AS name'),
                DB::raw('SUM(CASE WHEN a.risklevel = "Baixo" THEN 1 ELSE 0 END) AS total_baixo'),
                DB::raw('SUM(CASE WHEN a.risklevel = "Médio" THEN 1 ELSE 0 END) AS total_medio'),
                DB::raw('SUM(CASE WHEN a.risklevel = "Alto" THEN 1 ELSE 0 END) AS total_alto'),
                DB::raw('COUNT(*) AS total_geral')
            )
            ->where('b.entity_type', 1)
            ->groupBy('a.channel')
            ->get();
        return $results;
    }
}
