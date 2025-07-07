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
use Illuminate\Support\Facades\DB;

class ImportDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;
    protected $userID;
    protected $batchId;
    private $riskAssessmentService;

    public function __construct(array $data, $userID, $batchId)
    {
        $this->userID = $userID;
        $this->data = $data;
        $this->batchId = $batchId;
    }

    public $tries = 5;
    public $timeout = 300;

    public function handle(RiskAssessmentService $riskAssessmentService)
    {
        $this->riskAssessmentService = $riskAssessmentService;

        foreach ($this->data as $record) {
            DB::beginTransaction();
            try {
                $this->processRecord($record);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                $this->incrementErrorCount();
                continue;
            }
        }
    }

    private function processRecord(array $record)
    {
        if (empty($record['policy_number']) || empty($record['customer_number']) || empty($record['social_denomination'])) {
            return;
        }

        $data = $this->prepareAssessmentData($record);
        $data['user_id'] = $this->userID;
        $data['type_assessment'] = TypeAssessment::IMPORT->value; // Import type
        if ($data["status"] == 1) {
            $this->incrementSuccessCount();
        } else {
            $this->incrementErrorCount();
        }
        $riskAssessment = $this->riskAssessmentService->store($data);
        if ($riskAssessment) {
            $riskAssessment->risk_assessment_control_id = $this->batchId;
            $riskAssessment->save();
        }
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
                'pep' => $this->normalizePepValue($record['pep'])
            ]
        );
        $data =  [
            'entity_id' => $entity->id,
            'identification_capacity' => $indicatorService->getByDescription($record["identification_capacity"] ?? null),
            'profession' => $indicatorService->getByDescription($record['profession'] ?? null),
            'form_establishment' => (bool)$record['form_establishment'],
            'status_residence' => (bool)$record['status_residence'],
            'category' => $indicatorService->getByDescription($record['category'] ?? null),
            'channel' => $indicatorService->getByDescription($record['channel'] ?? null),
            'product_risk' => [$indicatorService->getByDescription($record['product_risk']) ?? null],
            'country_residence' => $indicatorService->getByDescription($record['country_residence'] ?? null),
            'nationality' => $indicatorService->getByDescription($record['nationality'] ?? null),
            'beneficial_ownerss' => $record['beneficial_owners'] ? [['name' => $record['beneficial_owners'], 'pep' => false]] : [],
        ];

        $requiredFields = [
            'identification_capacity',
            'profession',
            'category',
            'channel',
            'product_risk',
            'country_residence',
            'nationality',
        ];

        $data['status'] = StatusAssessment::SUCESS->value;

        foreach ($requiredFields as $field) {
            $value = $data[$field];
            if (is_null($value)) {
                $data['status'] = StatusAssessment::ERROR->value;
            }
        }
        return $data;
    }

    private function normalizePepValue($pep): int
    {
        if ($pep === "") return 0;
        return $pep ? 1 : 0;
    }

    private function incrementSuccessCount()
    {
        $errorRecord = RiskAssessmentControl::find($this->batchId);

        if ($errorRecord) {
            $errorRecord->update([
                'total_sucess' => $errorRecord->total_sucess + 1,
                'total' => $errorRecord->total + 1,
            ]);
        }
    }

    private function incrementErrorCount()
    {
        $errorRecord = RiskAssessmentControl::find($this->batchId);

        if ($errorRecord) {
            $errorRecord->update([
                'total_error' => $errorRecord->total_error + 1,
                'total' => $errorRecord->total + 1,
            ]);
        }
    }
}
