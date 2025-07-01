<?php

namespace App\Services\Entities;

use App\Enum\TypeEntity;
use App\Jobs\ImportDataJob;
use App\Repositories\Entities\EntitiesRepository;
use App\Services\AbstractService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class EntitiesService extends AbstractService
{

    private const BATCH_SIZE = 8000;
    private const TIME_LIMIT_SECONDS = 10;


    public function __construct(
        EntitiesRepository $repository,
        private RiskAssessmentControlService $riskAssessmentControlService
    ) {
        parent::__construct($repository);
    }

    public function getTotalEntites()
    {
        return $this->repository->getTotalEntities();
    }

    public function getEntitiesByType(TypeEntity $type)
    {
        return $this->repository->getEntitiesByType($type);
    }


    public function initializeImportBatch(int $userId): int
    {
        $timeLimit = Carbon::now()->subSeconds(self::TIME_LIMIT_SECONDS);
        $existingRecord = $this->riskAssessmentControlService->findOneBy(
            [
                [
                    'updated_at',
                    '>=',
                    $timeLimit
                ]
            ]
        );

        if (!$existingRecord) {
            $dataArray = $this->riskAssessmentControlService->store([
                'total_sucess' => 0,
                'error' => 0,
                'user_id' => $userId,
                'total_error' => 0,
                'total' => 0
            ]);
            $recordId = $dataArray->id;
        } else {
            $recordId = $existingRecord->id;
        }

        Cache::put('Error_id', $recordId);
        return $recordId;
    }

    public function dispatchImportJobs(array $data, int $userId, int $batchId): void
    {
        $chunks = array_chunk($data, self::BATCH_SIZE);

        foreach ($chunks as $index => $chunk) {
            ImportDataJob::dispatch($chunk, $userId)
                ->onQueue('default')
                ->delay(now()->addSeconds($index * 10));
        }
    }
}
