<?php

namespace App\Jobs;

use App\Enum\TypeAssessment;
use Illuminate\Bus\Queueable;
use App\Enum\StatusAssessment;
use Illuminate\Support\Facades\Cache;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Entities\RiskAssessmentControl;
use App\Services\Entities\EntitiesService;
use App\Services\Entities\RiskAssessmentService;
use App\Services\Indicator\IndicatorTypeService;

class ImportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $userID;
    private $riskAssessmentService;

    public function __construct(array $data, $userID)
    {
        $this->userID = $userID;
        $this->data = $data;
    }

    public $tries = 5;
    public $timeout = 300;

    public function handle(RiskAssessmentService $riskAssessmentService)
    {
        $this->riskAssessmentService = $riskAssessmentService;

        foreach ($this->data as $record) {
            try {
                $this->processRecord($record);

                if (Cache::has('Error_id')) {
                    $this->incrementSuccessCount();
                }
            } catch (\Exception $e) {
                $this->handleError($record);

                if (Cache::has('Error_id')) {
                    $this->incrementErrorCount();
                }
            }
        }

        Cache::forget('Error_id');
    }

    private function processRecord(array $record)
    {
        if (empty($record['policy_number']) || empty($record['customer_number']) || empty($record['social_denomination'])) {
            return;
        }

        $data = $this->prepareAssessmentData($record);
        $data['user_id'] = $this->userID;
        $data['type_assessment'] = TypeAssessment::IMPORT->value; // Import type
        $data['status'] = StatusAssessment::SUCESS->value; // Success

        $riskAssessment = $this->riskAssessmentService->store($data);
    }

    private function prepareAssessmentData(array $record): array
    {
        $indicatorService = app(IndicatorTypeService::class);
        $entityService = app(EntitiesService::class);

        $entity = $entityService->storeOrUpdate(
            [
                'policy_number' => $record['policy_number'],
                'customer_number' => $record['customer_number'],
            ],
            [
                'policy_number' => $record['policy_number'],
                'customer_number' => $record['customer_number'],
                'social_denomination' => $record['social_denomination'],
                'entity_type' => $record['entity_type'],
            ]
        );
        return [
            'entity_id' => $entity->id,
            'profession' => $indicatorService->getByDescription($record['profession']),
            'form_establishment' => (bool)$record['form_establishment'],
            'status_residence' => (bool)$record['status_residence'],
            'pep' => $this->normalizePepValue($record['pep']),
            'category' => $indicatorService->getByDescription($record['category']),
            'channel' => $indicatorService->getByDescription($record['channel']),
            'product_risk' => [$record['product_risk']],
            'country_residence' => $indicatorService->getByDescription($record['country_residence']),
            'nationality' => $indicatorService->getByDescription($record['nationality']),
            'beneficial_owners' => $record['beneficial_owner'] ? [['name' => $record['beneficial_owner'], 'pep' => '']] : [],
        ];
    }

    private function normalizePepValue($pep): int
    {
        if ($pep === "") return 0;
        return $pep ? 1 : 0;
    }

    private function handleError(array $record)
    {
        $errorId = Cache::get('Error_id');

        if (!$errorId) {
            return;
        }

        // Aqui você pode implementar a lógica para registrar o erro
        // Similar ao que estava fazendo com ErrorEvaluation e BeneficialOwnerError
        // Mas idealmente isso também deveria ser movido para um serviço
    }

    private function incrementSuccessCount()
    {
        $errorId = Cache::get('Error_id');
        $errorRecord = RiskAssessmentControl::find($errorId);

        if ($errorRecord) {
            $errorRecord->update([
                'sucess' => $errorRecord->sucess + 1,
                'total' => $errorRecord->total + 1,
            ]);
        }
    }

    private function incrementErrorCount()
    {
        $errorId = Cache::get('Error_id');
        $errorRecord = RiskAssessmentControl::find($errorId);

        if ($errorRecord) {
            $errorRecord->update([
                'error' => $errorRecord->error + 1,
                'total' => $errorRecord->total + 1,
            ]);
        }
    }
}
