<?php

namespace App\Jobs;

use App\Classes\CraftHistory;
use App\Classes\EntitieHistories;
use App\Helpers\Utils;
use App\Models\Assessment;
use App\Models\BeneficialOwner;
use App\Models\BeneficialOwnerError;
use App\Models\Diligence;
use App\Models\Entity;
use App\Models\ErrorDate;
use App\Models\ErrorEvaluation;
use App\Models\IndicatorType;
use App\Models\productEror;
use App\Models\ProductRisk;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class ImportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */

    private $CraftHistory;
    private $EntitieHistorie;
    private $userID;

    public function __construct(array $data,$userID)
    {
        $this->userID = $userID;
        $this->data = $data;
        $this->CraftHistory = new CraftHistory;
        $this->EntitieHistorie = new EntitieHistories;
    }

    public $tries = 5;

    // Tempo máximo de execução do job (em segundos)
    public $timeout = 300; // Ajuste conforme necessário
    public function handle()
    {


        foreach ($this->data as $record) {

            if (empty($record['policy_number']) || empty($record['customer_number']) || empty($record['social_denomination'])) {
                continue;
            }
            $entity = Entity::firstOrCreate(
                ['policy_number' => $record['policy_number']],
                [
                    'customer_number' => $record['customer_number'],
                    'social_denomination' => $record['social_denomination'],
                    'entity_type' => $record['entity_type'],
                ]
            );

            if ($entity && is_object($entity)) {
                // Agora $entity é garantidamente um objeto, então podemos acessar a propriedade id
                $entityId = $entity->id;

                $profession = IndicatorType::where('description', '=', $record['profession'])->first();

                if ($record['form_establishment'] == true) {
                    $form_establishment = 1;
                    $form_establishment_description = true;
                    $form_establishment_score = 20;
                }

                if ($record['form_establishment'] == false) {
                    $form_establishment = 3;
                    $form_establishment_description = false;
                    $form_establishment_score = 3;
                }

                if ($record['status_residence'] == true) {
                    $status_residence = 1;
                    $status_residence_description = true;
                    $status_residence_score = 1;
                }

                if ($record['status_residence'] == false) {
                    $status_residence = 3;
                    $status_residence_description = false;
                    $status_residence_score = 3;
                }

                if ($record['pep'] == "") {
                    $pep = 0;
                    $pep_description = "";
                    $pep_score = 0;
                }
                if ($record['pep'] == true) {
                    $pep = 20;
                    $pep_description = true;
                    $pep_score = 20;
                }

                if ($record['pep'] == false) {
                    $pep = 1;
                    $pep_description = false;
                    $pep_score = 1;
                }

                $category = IndicatorType::where('description', '=', $record['category'])->first();
                $channel = IndicatorType::where('description', '=', $record['channel'])->first();

                $product_risk = IndicatorType::where('description', '=', $record['product_risk'])->first();
                $country_residence = IndicatorType::where('description', '=', $record['country_residence'])->first();

                if ($record['nationality'] == "" || !isset($record['nationality'])) {
                    $nationality = $country_residence;
                } else {
                    $nationality = IndicatorType::where('description', '=', $record['nationality'])->first();
                }

                if ($record['pep'] == "" | !$channel | !$profession || !$category || !$nationality || !$product_risk || !$country_residence || !$pep || !$status_residence) {
                    $errorId = Cache::get('Error_id');
                 
                    if (Cache::has('Error_id')) {
                        $ErrorEvaluation = ErrorEvaluation::create([
                            'fk_entities' => $entityId,
                            'fk_user' => $this->userID,
                            'identification_capacity' => 'Incapacidade em obter os dados',
                            'nationality' => $nationality ? $nationality->description : 'Incapacidade em obter os dados',
                            'pep' => $pep_description ? $pep_description : 'Incapacidade em obter os dados',
                            'category' => $category ? $category->description : 'Incapacidade em obter os dados',
                            'form_establishment' => $form_establishment_description ? $form_establishment_description : 'Incapacidade em obter os dados',
                            'status_residence' => $status_residence_description ? $status_residence_description : 'Incapacidade em obter os dados',
                            'country_residence' => $country_residence ? $country_residence->description : 'Incapacidade em obter os dados',
                            'profession' => $profession ? $profession->description : 'Incapacidade em obter os dados',
                            'identification_capacity_score' => 'Incapacidade em obter os dados',
                            'nationality_score' => $nationality ? $nationality->score : 'Incapacidade em obter os dados',
                            'pep_score' => $pep_score ? $pep_score : 'Incapacidade em obter os dados',
                            'category_score' => $category ? $category->score : 'Incapacidade em obter os dados',
                            'form_establishment_score' => $form_establishment_score ? $form_establishment_score : 'Incapacidade em obter os dados',
                            'status_residence_score' => $status_residence_score ? $status_residence_score : 'Incapacidade em obter os dados',
                            'country_residence_score' => $country_residence ? $country_residence->score : 'Incapacidade em obter os dados',
                            'profession_score' => $profession ? $profession->score : 'Incapacidade em obter os dados',
                            'channel' => $channel ? $channel->description : 'Incapacidade em obter os dados',
                            'channel_score' => $channel ? $channel->score : 'Incapacidade em obter os dados',

                            'fk_error' => $errorId,
                            'status' => false,

                            'diligence' => "",
                            'color' => "",
                            'punctuation' => "",
                            'risklevel' => "",

                        ]);
                        $errorId = Cache::get('Error_id');
                        // Use $errorId para acessar o registro em ErrorDate
                        $errorRecord = ErrorDate::find($errorId);

                        // Verificar se o registro existe
                        if ($errorRecord) {
                            // Atualizar o campo 'error'
                            $errorRecord->update([
                                'error' => $errorRecord->error + 1,
                                'total' => $errorRecord->total + 1,
                            ]);
                        }
                    }

                    if ($ErrorEvaluation && $record['beneficial_owner']) {

                        if ($record['beneficial_owner']) {
                            BeneficialOwnerError::create([
                                'name' => $record['beneficial_owner'],
                                'pep' => "",
                                'fk_type_assessment' => $ErrorEvaluation->id,
                            ]);
                        }
                    }
                }
                else {

                    $identification_capacity = IndicatorType::find(1);

                    $total = ($identification_capacity ? $identification_capacity->score : 0)
                    + ($category ? $category->score : 0)
                    + ($profession ? $profession->score : 0)
                    + ($nationality ? $nationality->score : 0)
                    + ($status_residence_score ?? 0)
                    + ($country_residence ? $country_residence->score : 0)
                    + ($pep_score ?? 0)
                    + ($form_establishment_score ?? 0)
                    + ($product_risk ? $product_risk->score : 0);

                    $intervalos = Diligence::orderBy('risk', 'asc')->get();
                    // Chama a função verificarIntervalo da classe Utils
                    $result = Utils::verificarIntervalo($total, $intervalos);
                    $errorId = Cache::get('Error_id');
                    $assessment = Assessment::create([
                    'fk_entities' => $entityId,
                    'identification_capacity' => $identification_capacity->description,
                    'nationality' => $nationality->description,
                    'product_risk' => 21,
                    'fk_user' => $this->userID,
                    'pep' => $pep_description,
                    'category' => $category->description,
                    'form_establishment' => $form_establishment_description,
                    'status_residence' => $status_residence_description,
                    'risklevel' => $result['risk'],
                    'country_residence' => $country_residence->description,
                    'diligence' => $result['name'],
                    'color' => $result['color'],
                    'profession' => $profession->description,
                    'identification_capacity_score' => $identification_capacity->score,
                    'nationality_score' => $nationality->score,
                    'pep_score' => $pep_score,
                    'category_score' => $category->score,
                    'form_establishment_score' => $form_establishment_score,
                    'status_residence_score' => $status_residence_score,
                    'country_residence_score' => $country_residence->score,
                    'profession_score' => $profession->score,
                    'channel' => $channel->description,
                    'punctuation' => $total,
                    ]);

                    $ErrorEvaluation = ErrorEvaluation::create([

                    'fk_entities' => $entityId,
                    'identification_capacity' => $identification_capacity->description,
                    'nationality' => $nationality ? $nationality->description : 'Incapacidade em obter os dados',
                    'pep' => $pep_description ? $pep_description : 'Incapacidade em obter os dados',
                    'category' => $category ? $category->description : 'Incapacidade em obter os dados',
                    'form_establishment' => $form_establishment_description ? $form_establishment_description : 'Incapacidade em obter os dados',
                    'status_residence' => $status_residence_description ? $status_residence_description : 'Incapacidade em obter os dados',
                    'country_residence' => $country_residence ? $country_residence->description : 'Incapacidade em obter os dados',
                    'profession' => $profession ? $profession->description : 'Incapacidade em obter os dados',
                    'identification_capacity_score' => $identification_capacity->score,
                    'nationality_score' => $nationality ? $nationality->score : 'Incapacidade em obter os dados',
                    'pep_score' => $pep_score ? $pep_score : 'Incapacidade em obter os dados',
                    'category_score' => $category ? $category->score : 'Incapacidade em obter os dados',
                    'form_establishment_score' => $form_establishment_score ? $form_establishment_score : 'Incapacidade em obter os dados',
                    'status_residence_score' => $status_residence_score ? $status_residence_score : 'Incapacidade em obter os dados',
                    'country_residence_score' => $country_residence ? $country_residence->score : 'Incapacidade em obter os dados',
                    'profession_score' => $profession ? $profession->score : 'Incapacidade em obter os dados',
                    'channel' => $record['channel'] ? $record['channel'] : 'Incapacidade em obter os dados',
                    'fk_error' => $errorId,
                    'status' => true,
                    'diligence' => $result['name'],
                    'color' => $result['color'],
                    'punctuation' => $total,
                    'risklevel' => $result['risk'],
                    'fk_user' => $this->userID,

                    ]);


                    if ($assessment && $ErrorEvaluation) {
                    if ($record['beneficial_owner']) {
                    BeneficialOwner::create([
                    'name' => $record['beneficial_owner'],
                    'pep' => "",
                    'fk_type_assessment' => $assessment->id,
                    ]);
                    BeneficialOwnerError::create([
                    'name' => $record['beneficial_owner'],
                    'pep' => "",
                    'fk_type_assessment' => $ErrorEvaluation->id,
                    ]);
                    }
                    }

                    ProductRisk::create([
                    'product_risk_id' => $product_risk->id,
                    'name' => $product_risk->description,
                    'score' => $product_risk->score,
                    'fk_type_assessment' => $assessment->id, ]);
                    productEror::create([
                    'product_risk_id' => $product_risk->id,
                    'name' => $product_risk->description,
                    'score' => $product_risk->score,
                    'fk_type_assessment' => $ErrorEvaluation->id, ]);

                    Entity::find($entity)->update([
                    'risk_level' => $result['risk'],
                    'diligence' => $result['name'],
                    'last_evaluation' => $assessment->created_at,
                    'color' => $result['color'], ]);

               //     $this->EntitieHistorie->log('info', 'Realizou uma avaliação que resultou em uma pontuação de ' . $total . ' com um nível de risco ' . $result['risk'] . ' e o tipo de diligência ' . $result['name'], $entity, $this->userID);
               //   $this->CraftHistory->log('info', 'Realizou uma avaliação na entidade ' . $record['social_denomination'] . ' que resultou em uma pontuação de ' . $total . ' com um nível de risco ' . $result['risk'] . ' e o tipo de diligência ' . $result['name'], Auth::user()->name, $this->userID);

                    // Acessar o ID do registro armazenado no cache
                    if (Cache::has('Error_id')) {
                    $errorId = Cache::get('Error_id');
                    // Use $errorId para acessar o registro em ErrorDate
                    $errorRecord = ErrorDate::find($errorId);

                    // Verificar se o registro existe
                    if ($errorRecord) {
                    // Atualizar o campo 'error'
                    $errorRecord->update([
                    'sucess' => $errorRecord->sucess + 1,
                    'total' => $errorRecord->total + 1,
                    ]);
                    }
                    }
                    }

            }
        }
        // Limpar o cache após a atualização
        Cache::forget('Error_id');
    }
}
