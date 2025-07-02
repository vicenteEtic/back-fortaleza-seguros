<?php

namespace App\Services\Alert;

use App\External\PepExternalApi;
use App\External\SanctionExternalApi;
use App\Models\Entities\Entities;
use App\Repositories\Alert\AlertRepository;
use App\Repositories\Entities\BeneficialOwnerRepository;
use App\Repositories\Entities\EntitiesRepository;
use App\Services\AbstractService;
use Illuminate\Support\Facades\Log;

class AlertService extends AbstractService
{
    public function __construct(
        AlertRepository $repository,
        private EntitiesRepository $entitiesRepository,
        private BeneficialOwnerRepository $beneficialOwnerRepository
    ) {
        parent::__construct($repository);
    }


    public function generateAlertGeneral(int $entity_id, bool $beneficialOwner = false, int $riskAssessment): void
    {
        $entity = $this->entitiesRepository->findBy(['id' => $entity_id]);

        if (!$entity) {
            Log::warning("Entity with ID {$entity_id} not found or does not match type.");
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

    private function createAlerts(array $data, int $entityId, string $type = "PEP"): void
    {
        foreach ($data as $item) {
            $this->repository->storeOrUpdate(
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
