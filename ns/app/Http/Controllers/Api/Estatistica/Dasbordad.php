<?php

namespace App\Http\Controllers\Api\Estatistica;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Entity;
use App\Models\ProductRisk;
use App\Models\User;
use Illuminate\Http\Request;

class Dasbordad extends Controller
{
    public function index()
    {



        $date = date('Y');

        $jan =   Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', 01)->count();
        $response['jan'] = json_encode($jan);
        $fev = Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', 02)->count();
        $response['fev'] = json_encode($fev);
        $mar = Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', 03)->count();
        $response['mar'] = json_encode($mar);
        $abr = Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', 04)->count();
        $response['abr'] = json_encode($abr);
        $maio = Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', 05)->count();
        $response['may'] = json_encode($maio);
        $jun = Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', 06)->count();
        $response['jun'] = json_encode($jun);
        $jul = Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', 07)->count();
        $response['jul'] = json_encode($jul);
        $ago = Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', '08')->count();
        $response['ago'] = json_encode($ago);
        /**d */
        $set = Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', '09')->count();
        $response['set'] = json_encode($set);

        $out = Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', '10');
        $response['out'] = json_encode($out);
        $nov = Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', 11)->count();
        $response['nov'] = json_encode($nov);
        $dez = Assessment::whereYear('created_at', $date)->whereMonth('created_at', '=', 12)->count();
        $response['dez'] = json_encode($dez);

        $response = [];

        // Adicione suas consultas de contagem de cada mês aqui
        // Depois de adicionar todas as contagens, construa o array de resposta

        $totalRatings = Assessment::count();
        $totalEntities = Entity::count();

        $privateEntities = Entity::where('entity_type', 1)->count();
        $collectiveEntities = Entity::where('entity_type', 2)->count();
        $newEntities = Entity::orderBy('id', 'desc')->limit(3)->get();


        $response = Assessment::with('product_risks', 'entity', 'user')->orderBy('id', 'desc')->limit(3)->get();
        $data = [];

        foreach ($response as $item) {

            $dados =  ProductRisk::where('fk_type_assessment', $item->id)->get();
            $product_risk_id = [];
            $product_risk_score = 0;

            foreach ($dados as $row) {
                $product_risk_score =   $product_risk_score + $row->score;
                $product_risk_id[] = [
                    "name" => $row->name,
                    "score" => $row->score,

                ];
            }

            if ($item->pep == 0) {
                $pep = false;
            } else {
                $pep = true;
            }
            if ($item->status_residence == 0) {
                $status_residence = false;
            } else {
                $status_residence = true;
            }

            if ($item->form_establishment == 0) {
                $form_establishment = false;
            } else {
                $form_establishment = true;
            }
            $data[] = [
                'id' => $item->id,
                'social_denomination' => $item->entity->social_denomination,
                'entity_type' => $item->entity->entity_type,
                'policy_number' => $item->entity->policy_number,
                'customer_number' => $item->entity->customer_number,
                'identification_capacity' => $item->identification_capacity,
                'created_at' => $item->created_at,
                'form_establishment' => $form_establishment,
                'user' => [
                    "id" => $item->user->id,
                    "first_name" => $item->user->first_name,
                    "email" => $item->user->email,
                    "phone" => $item->user->phone,
                    "last_name" => $item->user->last_name,
                ],
                'category' => $item->category,
                'status_residence' => $status_residence,
                'profession' => $item->profession,
                'product_risk_score' =>  $product_risk_score,
                'pep' => $pep,
                'product_risk' =>  $product_risk_id,
                'country_residence' => $item->country_residence,
                'nationality' => $item->nationality,
                'punctuation' => $item->punctuation,
                'risklevel' => $item->risklevel,
                'diligence' => $item->diligence,
                'identification_score' => $item->identification_capacity_score,
                'nationality_score' => $item->nationality_score,
                'pep_score' => $item->pep_score,
                'category_score' => $item->category_score,
                'form_establishment_score' => $item->form_establishment_score,
                'status_residence_score' => $item->status_residence_score,
                'country_residence_score' => $item->country_residence_score,
                'profession_score' => $item->profession_score,
                'color' => $item->color,

            ];
        }

        $privateEntities_evaluation  = Assessment::whereHas('entity', function ($query) {
            $query->where('entity_type', 1);
        })->count();
        $collectiveEntities_evaluation = Assessment::whereHas('entity', function ($query) {
            $query->where('entity_type', 2);
        })->count();

        $response = [
            'totalRatings' =>  $totalRatings,
            'totalEntities' =>  $totalEntities,
            'privateEntities' =>  $privateEntities,
            'collectiveEntities' =>  $collectiveEntities,
            'newEntities' =>  $newEntities,
            'last_evaluation' => $data,
            'private_evaluation' => $privateEntities_evaluation,
            'collective_evaluation' => $collectiveEntities_evaluation,
        ];

        return $response;
    }
}
