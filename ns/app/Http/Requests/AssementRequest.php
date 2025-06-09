<?php

namespace App\Http\Controllers\Api\Assessment;

use App\Classes\CraftHistory;
use App\Classes\EntitieHistories;
use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\BeneficialOwner;
use App\Models\Diligence;
use App\Models\Entity;
use App\Models\ErrorEvaluation;
use App\Models\IndicatorType;
use App\Models\ProductRisk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AssessmentController extends Controller
{
    private $CraftHistory;
    private $EntitieHistorie;
    public function __construct()
    {
        $this->CraftHistory = new CraftHistory;
        $this->EntitieHistorie = new EntitieHistories;
    }
    public function index(Request $request)
    {
        try {
        $response = Assessment::with('product_risks', 'entity', 'user')->orderBy('id', 'desc')->get();
        $data = [];

        foreach ($response as $item) {

            $dados = ProductRisk::where('fk_type_assessment', $item->id)->get();
            $product_risk_id = [];
            $beneficialOwnerData = [];

            $product_risk_score = 0;
            $beneficialOwner = BeneficialOwner::where('fk_type_assessment', $item->id)->orderBy('name', 'asc')->get();

            foreach ($dados as $row) {
                $product_risk_score = $product_risk_score + $row->score;
                $product_risk_id[] = [
                    "name" => $row->name,
                    "score" => $row->score,

                ];
            }

            foreach ($beneficialOwner as $row) {

                if ($row->pep == 0) {
                    $beneficial = false;
                } else {
                    $beneficial = true;
                }
                $beneficialOwnerData[] = [
                    "name" => $row->name,
                    "pep" => $beneficial,

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
        }

        return response()->json($data, 200);

        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Falha ao listar  avalição",
            ], 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //validação do formulario
        $rules = [
            'identification_capacity' => 'required|numeric',
            'form_establishment' => 'required|',
            'category' => 'required',
            'status_residence' => 'required',
            'profession' => 'required|numeric',
            'pep' => 'required',
            'product_risk' => 'required',
            'country_residence' => 'required',
            'nationality' => 'required|numeric',
            'entity_id' => 'required|numeric',
            'beneficial_owner' => 'required|',
            'channel'=> 'required|numeric',


        ]; //retornar erros de validação
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $response = Entity::where('id', $request->entity_id)->count();
        if ($response <= 0) {
            return response()->json([
                "message" => "Erro ao localizar cliente",
            ], 400);
        }


        $identification_capacity = IndicatorType::find($request->identification_capacity);
        $channel = IndicatorType::find($request->channel);


        $profession = IndicatorType::find($request->profession);
        if ($request->form_establishment == true) {
            $form_establishment = 1;
            $form_establishment_description = true;
            $form_establishment_score = 1;
        } else {
            $form_establishment = 0;
            $form_establishment_description = false;
            $form_establishment_score = 3;
        }

        $category = IndicatorType::find($request->category);
        if ($request->status_residence ==true) {
            $status_residence = 1;
            $status_residence_description = true;
            $status_residence_score = 1;
        } else {
            $status_residence = 3;
            $status_residence_description = false;
            $status_residence_score = 3;
        }

        if ($request->pep ==true) {
            $pep = 20;
            $pep_description =true;
            $pep_score = 20;
        } else {
            $pep = 1;
            $pep_description =false;
            $pep_score = 1;
        }
        $product_risk = 0;
        $documentData = [];

        for ($a = 0; $a < count($request->product_risk); $a++) {
            $product_risk = IndicatorType::find($request->product_risk[$a])->score + $product_risk;

            $documentData[] = [
                'name' => IndicatorType::find($request->product_risk[$a])->description,
                'id' => IndicatorType::find($request->product_risk[$a])->id,
            ];
        }

        $country_residence = IndicatorType::find($request->country_residence);
        $nationality = IndicatorType::find($request->nationality);

        $total = $channel->score + $identification_capacity->score + $category->score + $profession->score + $nationality->score + $status_residence + $country_residence->score + $pep + $form_establishment + $product_risk;

        $intervalos = Diligence::orderBy('risk', 'asc')->get();

        function verificarIntervalo($numero, $intervalos)
        {
            foreach ($intervalos as $intervalo) {
                if ($numero >= $intervalo['min'] && $numero <= $intervalo['max']) {
                    return $intervalo;
                }
            }
            return null;
        }

        // Teste da função

        $result = verificarIntervalo($total, $intervalos);

        $assessment = Assessment::create([
            'fk_entities' => $request->entity_id,
            'identification_capacity' => $identification_capacity->description,
            'nationality' => $nationality->description,
            'product_risk' => json_encode($documentData),
            'pep' => $pep_description,
            'category' => $category->description,
            'form_establishment' => $form_establishment_description,
            'status_residence' => $status_residence_description,
            'punctuation' => $total,
            'risklevel' => $result['risk'],
            'country_residence' => $country_residence->description,
            'diligence' => $result['name'],
            'color' => $result['color'],
            'profession' => $profession->description,
            'identification_capacity_score' => $identification_capacity->score,
            'nationality_score' => $nationality->score,
            'pep_score' => $pep_score,
            'fk_user' => Auth::user()->id,
            'category_score' => $category->score,
            'form_establishment_score' => $form_establishment_score,
            'status_residence_score' => $status_residence_score,
            'country_residence_score' => $country_residence->score,
            'profession_score' => $profession->score,
            'channel' => $channel->description,
            'channel_score' => $channel->score,


        ]);

        Entity::find($request->entity_id)->update([
            'risk_level' => $result['risk'],
            'diligence' => $result['name'],
            'last_evaluation' => $assessment->created_at,
            'color' => $result['color'],

        ]);

        $Entity = Entity::find($request->entity_id);
        if ($request->beneficial_owner) {
            for ($a = 0; $a < count($request->beneficial_owner); $a++) {
                $beneficialOwner = $request->beneficial_owner[$a];

                BeneficialOwner::create([
                    'name' => $beneficialOwner['name'],
                    'pep' => $beneficialOwner['pep'],
                    'fk_type_assessment' =>  $assessment->id,
                ]);
            }
        }


        for ($a = 0; $a < count($request->product_risk); $a++) {
            ProductRisk::create([
                'product_risk_id' => IndicatorType::find($request->product_risk[$a])->id,
                'name' => IndicatorType::find($request->product_risk[$a])->description,
                'score' => IndicatorType::find($request->product_risk[$a])->score,
                'fk_type_assessment' => $assessment->id,

            ]);
        }


        $entity = Entity::find($request->entity_id);
        $beneficialOwner = BeneficialOwner::where('fk_type_assessment', $assessment->id)->get();
        $product_risk_id = [];
        $beneficialOwnerData = [];
        $product_risk_score = 0;

        $dados = ProductRisk::where('fk_type_assessment', $assessment->id)->get();
        /**historico */

        $this->EntitieHistorie->log('info', 'Realizou uma avaliação que resultou em uma pontuação de  ' . $total . ' com um nível de risco ' . $result['risk'] . ' e o tipo de diligência ' . $result['name'], $request->entity_id, Auth::user()->id);
        $this->CraftHistory->log('info', 'Realizou uma avaliação  na entidade ' .
            $Entity->social_denomination . ' que resultou em uma pontuação de ' . $total . ' com um nível de risco ' . $result['risk'] . ' e o tipo de diligência ' . $result['name'], Auth::user()->name, Auth::user()->id);

        foreach ($dados as $row) {
            $product_risk_score = $product_risk_score + $row->score;
            $product_risk_id[] = [
                "product_risk_id" => $row->fk_type_assessment,
                "name" => $row->name,
                "score" => $row->score,
                'product_risk_score' => $product_risk_score,
            ];
        }

        foreach ($beneficialOwner as $row) {

            if ($row->pep == 0) {
                $beneficial = false;
            } else {
                $beneficial = true;
            }
            $beneficialOwnerData[] = [
                "name" => $row->name,
                "pep" => $beneficial,

            ];
        }

        $data = [
            'id' => $assessment->id,
            'social_denomination' => $entity->social_denomination,
            'entity_type' => $entity->entity_type,
            'policy_number' => $entity->policy_number,
            'customer_number' => $entity->customer_number,
            'identification_capacity' => $assessment->identification_capacity,
            'form_establishment' => $assessment->form_establishment,
            'category' => $assessment->category,
            'status_residence' => $assessment->status_residence,
            'profession' => $assessment->profession,
            'created_at' => $assessment->created_at,
            'pep' => $assessment->pep,
            'product_risk' => $product_risk_id,
            'country_residence' => $assessment->country_residence,
            'nationality' => $assessment->nationality,
            'punctuation' => $assessment->punctuation,
            'risklevel' => $assessment->risklevel,
            'diligence' => $assessment->diligence,
            'identification_score' => $assessment->identification_capacity_score,
            'nationality_score' => $assessment->nationality_score,
            'pep_score' => $assessment->pep_score,
            'category_score' => $assessment->category_score,
            'form_establishment_score' => $assessment->form_establishment_score,
            'status_residence_score' => $assessment->status_residence_score,
            'country_residence_score' => $assessment->country_residence_score,
            'profession_score' => $assessment->profession_score,
            'color' => $result['color'],
            'last_evaluation' => $entity->last_evaluation,
            'channel' => $assessment->channel,
            'beneficial_owner' => $beneficialOwnerData,


        ];

        return $data;
        //code...
        try {
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao cadastrar avaliação",
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {

            $this->CraftHistory->log('info', 'Visualizou uma avaliação da entidade  com o identificador ' . $id, Auth::user()->name, Auth::user()->id);




        $response = Assessment::where('fk_entities', $id)->with('product_risks', 'entity', 'user')->orderBy('id', 'desc')->get();
        $data = [];

        foreach ($response as $item) {

            $dados = ProductRisk::where('fk_type_assessment', $item->id)->get();
            $product_risk_id = [];
            $beneficialOwnerData = [];

            $product_risk_score = 0;
            $beneficialOwner = BeneficialOwner::where('fk_type_assessment', $item->id)->orderBy('name', 'asc')->get();

            foreach ($dados as $row) {
                $product_risk_score = $product_risk_score + $row->score;
                $product_risk_id[] = [
                    "name" => $row->name,
                    "score" => $row->score,

                ];
            }

            foreach ($beneficialOwner as $row) {

                if ($row->pep == 0) {
                    $beneficial = false;
                } else {
                    $beneficial = true;
                }
                $beneficialOwnerData[] = [
                    "name" => $row->name,
                    "pep" => $beneficial,

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
        }


            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Falha ao listar tipos de indicadores",
            ], 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

                $IndicatorEvaluationMatrix = Assessment::find($id)->count();

                if ($IndicatorEvaluationMatrix >= 0) {
                    Assessment::find($id)->delete();
                    $this->CraftHistory->log('info', 'Apagou uma avalição com o Identificador ' . $id, Auth::user()->name, Auth::user()->id);
                    return response()->json([
                        "message" => "Indicador apagado com sucesso",
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Indicador não encontrado",
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido.",
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao apagar Indicador",
            ], 400);
        }
    }

    public function EvaluationError(Request $request)
    {

        $response = ErrorEvaluation::with('entity')->orderBy('id', 'desc')->get();
        $data = [];

        foreach ($response as $item) {

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
                'category' => $item->category,
                'status_residence' => $status_residence,
                'profession' => $item->profession,
                'pep' => $pep,
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

            ];
        }
        return response()->json($data, 200);
    }

    public function pep()
    {
        try {
            // Obter avaliações onde pep é 1
            $response = Assessment::where('pep', '1')
                ->with('entity')
                ->orderBy('id', 'desc')
                ->get();

            $data = [];
            $names = []; // Array para rastrear nomes únicos

            foreach ($response as $item) {
                // Obter Beneficial Owners associados
                $beneficialOwners = BeneficialOwner::where('pep', '1')
                    ->where('fk_type_assessment', $item->id)
                    ->orderBy('name', 'asc')
                    ->get();

                // Adicionar Beneficial Owners aos dados, garantindo nomes únicos
                foreach ($beneficialOwners as $owner) {
                    if (!in_array($owner->name, $names)) {
                        $data[] = [
                            "id" => $owner->id,
                            "name" => $owner->name,
                            'created_at' => $owner->created_at,
                        ];
                        $names[] = $owner->name; // Adiciona o nome ao array de nomes
                    }
                }

                // Adicionar dados da Assessment se o nome não estiver repetido
                if (!in_array($item->entity->social_denomination, $names)) {
                    $data[] = [
                        "id" => $item->id,
                        "name" => $item->entity->social_denomination,
                        'created_at' => $item->created_at,
                    ];
                    $names[] = $item->entity->social_denomination; // Adiciona o nome ao array de nomes
                }
            }
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Falha ao listar avaliação",
            ], 400);
        }
    }

}
