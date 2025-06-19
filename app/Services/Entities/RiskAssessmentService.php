<?php

namespace App\Services\Entities;

use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;
use App\Services\Diligence\DiligenceService;
use App\Repositories\Entities\RiskAssessmentRepository;
use App\Repositories\Indicator\IndicatorTypeRepository;

class RiskAssessmentService extends AbstractService
{
    public function __construct(
        RiskAssessmentRepository $repository,
        private readonly IndicatorTypeRepository $indicatorTypeRepository,
        private readonly DiligenceService $diligenceService,
        private readonly ProductRiskService $productRiskService,
        private readonly BeneficialOwnerService $beneficialOwnerService
    ) {
        parent::__construct($repository);
    }

    public function store(array $data)
    {
        $data['user_id'] = Auth::id();
        $riskAssessment = $this->repository->store($data);

        if (isset($data['beneficial_owners'])) {
            $this->beneficialOwnerService->createBeneficialOwner($data, $riskAssessment->id);
        }

        $this->loadRelations($riskAssessment);

        $riskProducts = $this->indicatorTypeRepository->getByIds($data['product_risk']);
        $this->productRiskService->storeProductRisks($riskProducts, $riskAssessment->id);

        $totalRiskProduct = $riskProducts->sum('score');
        $total = $this->calculateTotalScore($riskAssessment, $totalRiskProduct);

        $diligence = $this->diligenceService->getDilligenceAssessment($total);

        $this->updateEntityRisk($riskAssessment, $total, $diligence);
        $riskAssessment->score = $total;
        $riskAssessment->color = $diligence->color;
        $riskAssessment->risk_level = $diligence->risk;
        $riskAssessment->diligence = $diligence->name;
        $riskAssessment->save();

        return $riskAssessment;
    }



    private function loadRelations($riskAssessment): void
    {
        $riskAssessment->load([
            'entity',
            'user',
            'profession',
            'indetificationCapacity',
            'channel',
            'countryResidence',
            'category',
            'nationlity',
            'beneficialOwners'
        ]);
    }

    private function calculateTotalScore($riskAssessment, $totalRiskProduct): int
    {
        $fromEstablishment = $riskAssessment->form_establishment == 0 ? 1 : 3;
        $statusResidence = $riskAssessment->status_residence == 0 ? 1 : 3;
        $pep = $riskAssessment->pep == 1 ? 20 : 0;

        return
            $riskAssessment?->channel()?->first()?->score +
            $riskAssessment?->indetificationCapacity()?->first()?->score +
            $riskAssessment?->profession()?->first()?->score +
            $fromEstablishment +
            $statusResidence +
            $pep +
            $totalRiskProduct;
    }

    private function updateEntityRisk($riskAssessment, $total, $diligence): void
    {
        $entity = $riskAssessment?->entity();
        $entity->update([
            'risk_level' => $diligence?->risk,
            'diligence' => $diligence?->name,
            'color' => $diligence?->color,
            'last_evaluation' => now()
        ]);
    }


    public function getTotalRiskLevelByCategory(): array
    {
        return $this->repository->totalRiskLevelByCategory();
    }

    public function getTotalRiskLevelByProfession(): array
    {
        return $this->repository->totalRiskLevelByProfession();
    }

    public function getTotalRiskLevelByChannel(): array
    {
        return $this->repository->totalRiskLevelByChannel();
    }

    public function getTotalRiskLevelByPep(): array
    {
        return $this->repository->totalRiskLevelByPep();
    }

    public function getTotalRiskLevelByCountryResidence(): array
    {
        return $this->repository->totalRiskLevelByCountryResidence();
    }
    public function getTotalRiskLevelByNationality(): array
    {
        return $this->repository->totalRiskLevelByNationality();
    }
}
