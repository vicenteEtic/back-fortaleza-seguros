<?php

namespace App\Repositories\Entities;

use App\Enum\TypeEntity;
use App\Models\Alert\Alert;
use App\Models\Entities\Entities;
use App\Repositories\AbstractRepository;
use App\Repositories\Indicator\IndicatorTypeRepository;
use Illuminate\Database\Eloquent\Collection;

class EntitiesRepository extends AbstractRepository
{
    public $riskAssessment;
    public $indicatorType;


    public function __construct(Entities $model, RiskAssessmentRepository  $riskAssessment, IndicatorTypeRepository $indicatorType)
    {
        $this->riskAssessment = $riskAssessment;
        $this->indicatorType = $indicatorType;
        parent::__construct($model);
    }

    public function getTotalEntities(): int
    {
        return $this->model->count();
    }

    public function getEntitiesByType(TypeEntity $type): int
    {
        return $this->model->where('entity_type', $type)->count();
    }

    public function getLastEntities(int $limit = 3): ?Collection
    {
        return $this->model
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
    public function show(int|string $id, array $relationships = [])
{
    $entite = $this->model::find($id);
    if (!$entite) {
        return null; // ou lançar exceção se preferir
    }

    $alerts_entitie = Alert::where('entity_id', $id)->count();
    $valaiation = $this->riskAssessment->model::where('entity_id', $id)->latest('id')->first();

    if ($valaiation) {
        $valaiation->load([
            'entity',
            'user',
            'indetificationCapacity',
            'channel',
            'countryResidence',
            'category',
            'nationlity',
            'profession',
        ]);
    }

    $entity = [
        'id' => $entite->id,
        'social_denomination' => $entite->social_denomination ?? null,
        'entity_type' => $entite->entity_type ?? null,
        'customer_number' => $entite->customer_number ?? null,
        'policy_number' => $entite->policy_number ?? null,
        'nif' => $entite->nif ?? null,

        'identification_capacity' => optional($valaiation->indetificationCapacity)->description
            ?? $valaiation->identification_capacity
            ?? null,

        'form_establishment' => $valaiation
            ? ($valaiation->form_establishment instanceof \App\Enum\FormEstablishment
                ? $valaiation->form_establishment->value
                : ($valaiation->form_establishment == 0 ? 'Presencial' : 'Não Presencial'))
            : null,

        'category' => optional($valaiation->category)->description
            ?? optional($this->indicatorType->model::find($valaiation->category))->description
            ?? null,

        'status_residence' => $valaiation
            ? ($valaiation->status_residence instanceof \App\Enum\StatusResidence
                ? $valaiation->status_residence->value
                : ($valaiation->status_residence == 0 ? 'Residente' : 'Não Residente'))
            : null,

        'profession' => optional($valaiation->profession)->description
            ?? optional($this->indicatorType->model::find($valaiation->profession))->description
            ?? null,

        'pep' => (bool) ($valaiation->pep ?? false),
        'product_risk' => $valaiation->product_risk ?? null,

        'country_residence' => optional($valaiation->country_residence)->description
            ?? optional($this->indicatorType->model::find($valaiation->country_residence))->description
            ?? null,

        'nationality' => optional($valaiation->nationlity)->description
            ?? optional($this->indicatorType->model::find($valaiation->nationlity))->description
            ?? null,

        'punctuation' => $valaiation->score ?? null,
        'risk_level' => $entite->risk_level ?? null,
        'diligence' => $entite->diligence ?? null,
        'last_evaluation' => $entite->last_evaluation ?? null,
        'created_at' => $entite->created_at ?? null,
        'color' => $entite->color ?? null,
        'alerts_count' => $alerts_entitie ?? 0,
    ];

    return $entity;
}



    public function index(?int $paginate, ?array $filterParams, ?array $orderByParams, $relationships = [])
    {
        $query = $this->buildQuery(
            $paginate,
            $filterParams,
            $orderByParams,
            $relationships,
            ['alerts']
        );

        // Se $paginate for null, $query já é uma Collection.
        // Se $paginate tiver valor, $query é um Paginator.
        return $query;
    }
}
