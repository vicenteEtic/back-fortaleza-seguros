<?php

namespace App\Services\Entities;

use App\Services\AbstractService;
use Illuminate\Support\Facades\Auth;
use App\Services\Diligence\DiligenceService;
use App\Repositories\Entities\ProductRiskRepository;
use App\Repositories\Entities\RiskAssessmentRepository;
use App\Repositories\Indicator\IndicatorTypeRepository;
use App\Repositories\Entities\BeneficialOwnerRepository;

class RiskAssessmentService extends AbstractService
{
    public function __construct(
        RiskAssessmentRepository $repository,
        private readonly IndicatorTypeRepository $indicatorTypeRepository,
        private readonly DiligenceService $diligenceService,
        private readonly ProductRiskRepository $productRiskRepository,
        private readonly BeneficialOwnerRepository $beneficialOwnerRepository
    ) {
        parent::__construct($repository);
    }

    public function store(array $data)
    {
        $data['user_id'] = Auth::id();
        $riskAssessment = $this->repository->store($data);

        if (isset($data['beneficial_owners'])) {
            $this->createBeneficialOwner($data, $riskAssessment->id);
        }

        $this->loadRelations($riskAssessment);

        $riskProducts = $this->indicatorTypeRepository->getByIds($data['product_risk']);
        $this->storeProductRisks($riskProducts, $riskAssessment->id);

        $totalRiskProduct = $riskProducts->sum('score');
        $total = $this->calculateTotalScore($riskAssessment, $totalRiskProduct);

        $diligence = $this->diligenceService->getDilligenceAssessment($total);

        $this->updateEntityRisk($riskAssessment, $total, $diligence);
        $riskAssessment->score = $total;
        $riskAssessment->save();

        return $riskAssessment;
    }

    public function createBeneficialOwner(array $data, int $riskAssessmentId): void
    {
        foreach ($data['beneficial_owners'] as $owner) {
            $owner['risk_assessment_id'] = $riskAssessmentId;
            $this->beneficialOwnerRepository->store($owner);
        }
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

    private function storeProductRisks($riskProducts, $riskAssessmentId): void
    {
        foreach ($riskProducts->get() as $product) {
            $productRisk = [
                'product_id' => $product->id,
                'score' => $product->score,
                'risk_assessment_id' => $riskAssessmentId
            ];
            $this->productRiskRepository->storeOrUpdate(
                ['product_id' => $product->id],
                $productRisk
            );
        }
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
            'risk_level' => $total,
            'diligence' => $diligence?->name,
            'color' => $diligence?->color,
            'last_evaluation' => now()
        ]);
    }
}
