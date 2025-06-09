<?php

namespace App\Http\Controllers\Api\Entities;

use App\Models\Entity;
use App\Models\Assessment;
use App\Models\ProductRisk;
use Illuminate\Http\Request;
use App\Classes\CraftHistory;
use App\Classes\EntitieHistories;
use App\Http\Controllers\Controller;
use App\Models\BeneficialOwner;
use App\Services\EntityFilter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class EntitiesController extends Controller
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
            //validação do formulario
            $rules = [
                'type' => ['required', 'numeric'], ];

            //retornar erros de validação
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors' => $validator->errors()], 400);
            }
            $filters = $request->only(['social_denomination', 'customer_number', 'policy_number', 'type', 'search', 'last_evaluation', 'created_at']);
            // Aplica os filtros
            $query = Entity::query();
            $query = EntityFilter::apply($query, $filters);
            $response = $query->paginate(50);

            $data = $response->map(function ($item) {
                return [
                    "id"=>$item->id,
                    "social_denomination"=>$item->social_denomination,
                    "policy_number"=>$item->policy_number,
                    "customer_number"=>$item->customer_number,
                    "entity_type"=>$item->entity_type,
                    "color"=>$item->color,
                    "risk_level"=>$item->risk_level,
                    "diligence"=>$item->diligence,
                    "last_evaluation"=>$item->last_evaluation,
                    "created_at"=>$item->created_at,
                    "updated_at"=>$item->updated_at
                ];
            });


            return response()->json([
                'data' =>    $data ,
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
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Falha ao listar  entidades",
            ], 400);
        }
    }

    public function valitaion(){

    }

    public function store(Request $request)
    {
        try {

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                //validação do formulario
                $rules = [
                    'social_denomination' => ['required', 'string'],
                    'customer_number' => 'required|string|max:255|unique:entities',
                    'policy_number' => 'required|string|max:255|unique:entities',
                    'entity_type' => ['required', 'numeric'],
                ];

                // Mensagens de erro personalizadas
                $messages = [
                    'social_denomination.required' => 'A denominação social é obrigatória.',
                    'social_denomination.string' => 'A denominação social deve ser uma string.',
                    'customer_number.required' => 'O número do cliente é obrigatório.',
                    'customer_number.string' => 'O número do cliente deve ser uma string.',
                    'customer_number.max' => 'O número do cliente não pode ter mais de 255 caracteres.',
                    'customer_number.unique' => 'O número do cliente já existe.',
                    'policy_number.required' => 'O número da apólice é obrigatório.',
                    'policy_number.string' => 'O número da apólice deve ser uma string.',
                    'policy_number.max' => 'O número da apólice não pode ter mais de 255 caracteres.',
                    'policy_number.unique' => 'O número da apólice já existe.',
                    'entity_type.required' => 'O tipo de entidade é obrigatório.',
                    'entity_type.numeric' => 'O tipo de entidade deve ser um número.',
                ];

                // Retornar erros de validação
                $validator = Validator::make($request->all(), $rules, $messages);
                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()], 400);
                }

                $Entity =  Entity::create([
                    'customer_number' => $request->customer_number,
                    'policy_number' => $request->policy_number,
                    'social_denomination' => $request->social_denomination,
                    'entity_type' => $request->entity_type,

                ]);
                $this->CraftHistory->log('info', ' cadastrou esta uma entidade com o nome ' . $request->social_denomination, Auth::user()->name, Auth::user()->id);
                $this->EntitieHistorie->log('info', 'Foi cadastrado no sistema pelo Usuário ' . Auth::user()->first_name,   $Entity->id, Auth::user()->id);
                return response()->json(['message' => "cadastrado com sucesso"], 201);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao cadastrar  entidade",
            ], 400);
        }
    }



    public function show(Request $request, $id)
    {
        try {

            $entity = Entity::find($id);
            $assessment = Assessment::with('product_risks')->where('fk_entities', $id)->latest()->first();

            if ($entity && $assessment) {

                $dados = ProductRisk::where('fk_type_assessment', $assessment->id)->get();
                $product_risk_id = [];
                $beneficialOwnerData = [];
                $product_risk_score = 0;
                $beneficialOwner = BeneficialOwner::where('fk_type_assessment', $assessment->id)->orderBy('name', 'asc')->get();

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
                if ($assessment->pep == 0) {
                    $pep = false;
                } else {
                    $pep = true;
                }
                if ($assessment->status_residence == 0) {
                    $status_residence = false;
                } else {
                    $status_residence = true;
                }

                if ($assessment->form_establishment == 0) {
                    $form_establishment = false;
                } else {
                    $form_establishment = true;
                }


                $data = [
                    'id' => $entity->id,
                    'entity_type' => $entity->entity_type,
                    'created_at' => $entity->created_at,
                    'updated_at' => $entity->updated_at,
                    'social_denomination' => $entity->social_denomination,
                    'policy_number' => $entity->policy_number,
                    'customer_number' => $entity->customer_number,
                    'identification_capacity' => $assessment->identification_capacity,
                    'identification_score' => $assessment->identification_capacity_score,
                    'form_establishment' => $form_establishment,
                    'category' => $assessment->category,
                    'status_residence' => $status_residence,
                    'profession' => $assessment->profession,
                    'product_risk_score' =>  $product_risk_score,
                    'pep' => $pep,
                    'product_risk' =>  $product_risk_id,
                    'country_residence' => $assessment->country_residence,
                    'nationality' => $assessment->nationality,
                    'punctuation' => $assessment->punctuation,
                    'risklevel' => $assessment->risklevel,
                    'diligence' => $assessment->diligence,
                    'color' => $assessment->color,
                    'last_evaluation' => $entity->last_evaluation,
                    'channel' => $assessment->channel,
                    'beneficial_owner' => $beneficialOwnerData,

                ];
            } else {
                $data = [
                    'id' => $entity->id,
                    'entity_type' => $entity->entity_type,
                    'created_at' => $entity->created_at,
                    'updated_at' => $entity->updated_at,
                    'social_denomination' => $entity->social_denomination,
                    'policy_number' => $entity->policy_number,
                    'customer_number' => $entity->customer_number,
                    'identification_capacity' => "",
                    'identification_score' => "",
                    'form_establishment' => "",
                    'category' => "",
                    'status_residence' => "",
                    'profession' => "",
                    'product_risk_score' => "",
                    'pep' => "",
                    'product_risk' =>  "",
                    'country_residence' => "",
                    'nationality' => "",
                    'punctuation' => "",
                    'risklevel' => "",
                    'diligence' => "",
                    'color' => "",
                    'last_evaluation' => $entity->last_evaluation,
                    'channel' => "",
                    'beneficial_owner' => "",
                ];
            }

            $this->CraftHistory->log('info', 'Visualizou uma Entidade com o nome ' . $entity->social_denomination, Auth::user()->name, Auth::user()->id);
            return response()->json($data, 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao pesquisar Tipo de entidade",
            ], 400);
        }
    }


    public function update(Request $request, $id)
    {

        try {
            $entity = Entity::find($id);
            if (isset($request->lastname)) {

                Entity::find($id)->update([
                    'lastname' => $request->lastname,

                ]);

                $this->EntitieHistorie->log('info', 'Foi atulizado os dados no sistema pelo Usuário ' . Auth::user()->first_name . ' Trocou o último nome de' . $entity->lastname . ' para ' . $request->lastname,   $id, Auth::user()->id);
                $this->CraftHistory->log('info', ' Trocou o último nome da entidade  de' . $entity->lastname . ' para ' . $request->lastname . $id, Auth::user()->name, Auth::user()->id);
                return response()->json(['message' => "cadastrado com sucesso"], 201);
            }
            if (isset($request->customer_number)) {

                Entity::find($id)->update([
                    'customer_number' => $request->customer_number,

                ]);
                $this->CraftHistory->log('info', ' Trocou o   número de Cliente de ' . $entity->customer_number . ' para ' . $request->customer_number . $id, Auth::user()->name, Auth::user()->id);
                $this->EntitieHistorie->log('info', 'Foi atulizado os dados no sistema pelo Usuário ' . Auth::user()->first_name . ' Trocou o   número de Cliente de' . $entity->customer_number . ' para ' . $request->customer_number,   $id, Auth::user()->id);
            }

            if (isset($request->name)) {

                Entity::find($id)->update([
                    'name' => $request->name,

                ]);
                $this->CraftHistory->log('info', ' Trocou o  nome da entidade  de ' . $entity->name . ' para ' . $request->name . $id, Auth::user()->name, Auth::user()->id);
                $this->EntitieHistorie->log('info', 'Foi atulizado os dados no sistema pelo Usuário ' . Auth::user()->first_name . ' Trocou o  nome de' . $entity->name . ' para ' . $request->name,   $id, Auth::user()->id);
            }
            if (isset($request->data)) {

                Entity::find($id)->update([
                    'data' => $request->data,

                ]);
                $this->CraftHistory->log('info', ' Trocou o  data da entidade  de ' . $entity->data . ' para ' . $request->data . $id, Auth::user()->name, Auth::user()->id);
                $this->EntitieHistorie->log('info', 'Foi atulizado os dados no sistema pelo Usuário ' . Auth::user()->first_name . ' Trocou o  data de ' . $entity->data . ' para ' . $request->data,   $id, Auth::user()->id);
            }
            if (isset($request->policy_number)) {

                Entity::find($id)->update([
                    'policy_number' => $request->policy_number,

                ]);
                $this->EntitieHistorie->log('info', 'Foi atulizado os dados no sistema pelo Usuário ' . Auth::user()->first_name . ' Trocou o  número de registro de ' . $entity->policy_number . ' para ' . $request->policy_number,   $id, Auth::user()->id);
            }
            if (isset($request->social_denomination)) {

                Entity::find($id)->update([
                    'social_denomination' => $request->social_denomination,

                ]);
                $this->EntitieHistorie->log('info', 'Foi atulizado os dados no sistema pelo Usuário ' . Auth::user()->first_name . ' Trocou a  denominação social ' . $entity->social_denomination . ' para ' . $request->social_denomination,   $id, Auth::user()->id);
            }

            $this->CraftHistory->log('info', 'Editou uma entidade com o identificador ' . $id, Auth::user()->name, Auth::user()->id);
            return response()->json([
                "message" => "Tipo de entidade atulizado com sucesso",
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao Editar de Entidade Tipo de entidade",
            ], 400);
        }
    }

    public function destroy($id)
    {
        try {
            if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {

                $Entity = Entity::find($id)->count();

                if ($Entity >= 0) {

                    $entity = Entity::find($id);
                    $this->CraftHistory->log('info', 'Apagou uma entidade com o nome ' .  $entity->social_denomination, Auth::user()->name, Auth::user()->id);
                    Entity::find($id)->delete();
                    return response()->json([
                        "message" => "Tipo de entidade apagado com sucesso",
                    ], 200);
                } else {
                    return response()->json([
                        "message" => "Tipo de Entidade não encontrado",
                    ], 400);
                }
            } else {
                return response()->json([
                    "message" => "Método de requisição inválido.",
                ], 400);
            }
        } catch (\Throwable $th) {
            return response()->json([
                "message" => "Erro ao apagar Tipo de entidade",
            ], 400);
        }
    }
}
