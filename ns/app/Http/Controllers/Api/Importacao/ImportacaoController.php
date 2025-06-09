<?php

namespace App\Http\Controllers\Api\Importacao;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Jobs\ImportDataJob;
use App\Models\BeneficialOwner;
use App\Models\BeneficialOwnerError;
use App\Models\ErrorDate;
use App\Models\ErrorEvaluation;
use App\Models\productEror;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ImportacaoController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->all(); // Obtém todos os dados da solicitação

        // Verifica se os dados estão estruturados corretamente para importação em lotes
        if (!is_array($data) || empty($data)) {
            return response()->json(['error' => 'Dados inválidos'], 400);
        }
        $timeLimit = Carbon::now()->subSeconds(10);
        $batchSize = 8000;
        $userID = Auth::user()->id;
        $chunks = array_chunk($data, $batchSize);
        // Criar um novo registro em ErrorDate
        $existingRecord = ErrorDate::where('updated_at', '>=', $timeLimit)->first();

        if (!$existingRecord) {
            $dataArray = ErrorDate::create([
                'sucess' => 0,
                'error' => 0,
                'fk_user' => Auth::user()->id,
                'total' => 0,
            ]);
            // Pega o ID do novo registro inserido
            $recordId = $dataArray->id;
        } else {
            // Caso exista, pega o ID do registro existente
            $recordId = $existingRecord->id;
        }

        // Armazenar o ID do novo registro no cache
        Cache::put('Error_id',     $recordId);
        foreach ($chunks as $index => $chunk) {
            ImportDataJob::dispatch($chunk, $userID)->onQueue('default') // Você pode ajustar a fila conforme necessário
                ->delay(now()->addSeconds($index * 10)); // Adiciona delay para controlar a carga;
        }

        return response()->json(['success' => 'Dados importados em background']);
    }

    public function  errorEvaluation()
    {

        $response = ErrorDate::orderBy('id', 'desc')->paginate(50);

        $data = $response->map(function ($item) {

            return [
                "id" => $item->id,
                "sucess" => $item->sucess,
                "fk_user" => $item->fk_user,
                "error" => $item->error,
                "total" => $item->total,
                "created_at" => $item->created_at,
                "updated_at" => $item->updated_at,
                'user' => [
                    "id" => $item->user->id,
                    "first_name" => $item->user->first_name,
                    "email" => $item->user->email,
                    "phone" => $item->user->phone,
                    "last_name" => $item->user->last_name,
                ],

            ];
        });

        // Retornar a resposta com paginação
        return response()->json([
            'data' => $data,
            'pagination' => [
                'total' => $response->total(),
                'current_page' => $response->currentPage(),
                'per_page' => $response->perPage(),
                'last_page' => $response->lastPage(),
                'from' => $response->firstItem(),
                'to' => $response->lastItem(),
            ]
        ], 200);


        return response()->json($response, 200);
    }


    public function  show($id)
    {

        $response = ErrorEvaluation::with(['product_risks', 'entity', 'user', 'beneficialOwners'])->orderBy('id', 'desc')->paginate(50);

        $data = $response->map(function ($item) {

            // Inicializando variáveis
            $product_risk_score = 0;
            $product_risk_id = [];
            $beneficialOwnerData = [];

            // Processamento dos dados de ProductRisk
            foreach ($item->product_risks as $row) {
                $product_risk_score += $row->score;
                $product_risk_id[] = [
                    "name" => $row->name,
                    "score" => $row->score,
                ];
            }

            // Processamento dos dados de BeneficialOwner
            foreach ($item->beneficialOwners as $row) {
                $beneficial = $row->pep != 0;
                $beneficialOwnerData[] = [
                    "name" => $row->name,
                    "pep" => $beneficial,
                ];
            }

            // Definindo valores booleanos para as propriedades
            $pep = $item->pep != 0;
            $status_residence = $item->status_residence != 0;
            $form_establishment = $item->form_establishment != 0;

            return [
                'id' => $item->id,
                'social_denomination' => $item->entity->social_denomination,
                'entity_type' => $item->entity->entity_type,
                'policy_number' => $item->entity->policy_number,
                'customer_number' => $item->entity->customer_number,
                'entity_id' => $item->entity->id,
                'status' => $item->status,
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
                'status' =>  $item->status,
                'profession' => $item->profession,
                'product_risk_score' => $product_risk_score,
                'pep' => $pep,
                'product_risk' => $product_risk_id,
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
                'channel' => $item->channel,
                'beneficial_owner' => $beneficialOwnerData,
            ];
        });

        // Retornar a resposta com paginação
        return response()->json([
            'data' => $data,
            'pagination' => [
                'total' => $response->total(),
                'current_page' => $response->currentPage(),
                'per_page' => $response->perPage(),
                'last_page' => $response->lastPage(),
                'from' => $response->firstItem(),
                'to' => $response->lastItem(),
            ]
        ], 200);
    }
}
