<?php

namespace App\Jobs;

use App\Enum\StatusAssessment;
use App\Enum\TypeAssessment;
use App\Models\Entities\RiskAssessmentControl;
use App\Services\Entities\RiskAssessmentService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

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
        $data['type_assessment'] = TypeAssessment::IMPORT; // Import type
        $data['status'] = StatusAssessment::SUCESS; // Success

        $riskAssessment = $this->riskAssessmentService->store($data);
    }

    private function prepareAssessmentData(array $record): array
    {
        return [
            'policy_number' => $record['policy_number'],
            'customer_number' => $record['customer_number'],
            'social_denomination' => $record['social_denomination'],
            'entity_type' => $record['entity_type'],
            'profession' => $record['profession'],
            'form_establishment' => (bool)$record['form_establishment'],
            'status_residence' => (bool)$record['status_residence'],
            'pep' => $this->normalizePepValue($record['pep']),
            'category' => $record['category'],
            'channel' => $record['channel'],
            'product_risk' => [$record['product_risk']],
            'country_residence' => $record['country_residence'],
            'nationality' => $record['nationality'] ?? $record['country_residence'],
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
