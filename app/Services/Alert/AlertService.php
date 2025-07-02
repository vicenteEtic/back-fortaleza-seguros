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
}
