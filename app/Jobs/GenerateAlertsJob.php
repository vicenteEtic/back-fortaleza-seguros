<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\External\PepExternalApi;
use Illuminate\Support\Facades\Log;
use App\External\SanctionExternalApi;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Repositories\Alert\AlertRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Repositories\Entities\BeneficialOwnerRepository;
use App\Repositories\Entities\EntitiesRepository;

class GenerateAlertsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $entityId;
    protected $beneficialOwner;
    protected $riskAssessment;
    protected $alertRepository;
    protected $entitiesRepository;
    protected $beneficialOwnerRepository;

    /**
     * Create a new job instance.
     *
     * @param int $entityId
     * @param bool $beneficialOwner
     * @param int $riskAssessment
     */
    public function __construct(int $entityId, bool $beneficialOwner = false, int $riskAssessment)
    {
        $this->entityId = $entityId;
        $this->beneficialOwner = $beneficialOwner;
        $this->riskAssessment = $riskAssessment;
    }

    /**
     * Execute the job.
     *
     * @param AlertRepository $alertRepository
     * @param EntitiesRepository $entitiesRepository
     * @param BeneficialOwnerRepository $beneficialOwnerRepository
     * @return void
     */
    public function handle(AlertRepository $alertRepository, EntitiesRepository $entitiesRepository, BeneficialOwnerRepository $beneficialOwnerRepository): void
    {
        $this->alertRepository = $alertRepository;
        $this->entitiesRepository = $entitiesRepository;
        $this->beneficialOwnerRepository = $beneficialOwnerRepository;

        $this->generateAlertGeneral($this->entityId, $this->beneficialOwner, $this->riskAssessment);
    }

    /**
     * Generate alerts for the given entity and optionally beneficial owners.
     *
     * @param int $entityId
     * @param bool $beneficialOwner
     * @param int $riskAssessment
     * @return void
     */
    public function generateAlertGeneral(int $entityId, bool $beneficialOwner, int $riskAssessment): void
    {
        $entity = $this->entitiesRepository->findBy(['id' => $entityId]);

        if (!$entity) {
            Log::warning("Entity with ID {$entityId} not found or does not match type.");
            return;
        }

        $this->processEntities($entity, 'social_denomination');
        $this->processEntitiesSanctions($entity, 'social_denomination');

        if ($beneficialOwner) {
            $beneficialOwners = $this->beneficialOwnerRepository->findBy(['risk_assessment_id' => $riskAssessment]);
            $this->processEntities($beneficialOwners, 'name');
            $this->processEntitiesSanctions($beneficialOwners, 'name');
        }
    }

    /**
     * Process entities for PEP checks.
     *
     * @param mixed $entities
     * @param string $nameField
     * @return void
     */
    public function processEntities($entities, string $nameField): void
    {
        foreach ($entities as $entity) {
            $entityName = $entity->$nameField;
            try {
                $externalData = PepExternalApi::getDataPepExternal($entityName);

                if (empty($externalData)) {
                    continue;
                }

                $this->createAlerts($externalData, $entity->id, "PEP");
            } catch (\Exception $e) {
                Log::error("Error processing entity {$entityName}: {$e->getMessage()}");
            }
        }
    }

    /**
     * Process entities for sanctions checks.
     *
     * @param mixed $entities
     * @param string $nameField
     * @return void
     */
    public function processEntitiesSanctions($entities, string $nameField): void
    {
        foreach ($entities as $entity) {
            $entityName = $entity->$nameField;
            try {
                $externalData = SanctionExternalApi::getDataSanctionExternal($entityName);
                if (empty($externalData)) {
                    continue;
                }

                $this->createAlerts($externalData, $entity->id, "SANCTION");
            } catch (\Exception $e) {
                Log::error("Error processing entity {$entityName}: {$e->getMessage()}");
            }
        }
    }

    /**
     * Create or update alerts based on external data.
     *
     * @param array $data
     * @param int $entityId
     * @param string $type
     * @return void
     */
    private function createAlerts(array $data, int $entityId, string $type = "PEP"): void
    {
        foreach ($data as $item) {
            $this->alertRepository->storeOrUpdate(
                ['origin_id' => $item['id']],
                [
                    'name' => $item['name'],
                    'level' => 'Alto',
                    'from_id' => $entityId,
                    'origin_id' => $item['id'],
                    'entity_id' => $entityId,
                    'score' => $item['score'] ?? 0,
                    'type' => $type,
                    'list' => $item['type'] ?? ($type === "PEP" ? "PEP List world" : "Sanctions List"),
                    'is_active' => true,
                ]
            );
        }
    }
}
