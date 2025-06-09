<?php

namespace App\Http\Controllers\Api\Estatistica\Collective;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $results = DB::table('product_risks')
            ->join('type_assessments', 'product_risks.fk_type_assessment', '=', 'type_assessments.id')
            ->select(
                'product_risks.name AS name',
                DB::raw('SUM(CASE WHEN type_assessments.risklevel = "Baixo" THEN 1 ELSE 0 END) AS total_baixo'),
                DB::raw('SUM(CASE WHEN type_assessments.risklevel = "Médio" THEN 1 ELSE 0 END) AS total_medio'),
                DB::raw('SUM(CASE WHEN type_assessments.risklevel = "Alto" THEN 1 ELSE 0 END) AS total_alto'),
                DB::raw('COUNT(*) AS total_geral')
            )
            ->groupBy('product_risks.name')
            ->get();

        return $results;

    }
}
