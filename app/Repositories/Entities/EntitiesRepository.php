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
            'social_denomination' => $entite->social_denomination,
            'entity_type' => $entite->entity_type,
            'customer_number' => $entite->customer_number,
            'policy_number' => $entite->policy_number,
            'nif' => $entite->nif,

            // ✅ Usa optional() para evitar erros se o relacionamento for null
            'identification_capacity' => optional($valaiation->indetificationCapacity)->description
                ?? $valaiation->identification_capacity
                ?? null,

            // ✅ Formato de estabelecimento (enum ou texto simples)
            'form_establishment' => $valaiation
                ? ($valaiation->form_establishment instanceof \App\Enum\FormEstablishment
                    ? $valaiation->form_establishment->value
                    : ($valaiation->form_establishment == 0 ? 'Presencial' : 'Não Presencial'))
                : null,

            // ✅ Categoria (pega o nome se vier via relação ou o ID como fallback)
            'category' => optional($valaiation->category)->description
                ?? optional($this->indicatorType->model::find($valaiation->category))->description
                ?? null,

            // ✅ Status de residência
            'status_residence' => $valaiation
                ? ($valaiation->status_residence instanceof \App\Enum\StatusResidence
                    ? $valaiation->status_residence->value
                    : ($valaiation->status_residence == 0 ? 'Residente' : 'Não Residente'))
                : null,

            // ✅ Profissão
            'profession' => optional($valaiation->profession)->description
                ?? optional($this->indicatorType->model::find($valaiation->profession))->description
                ?? null,

            // ✅ PEP e risco de produto
            'pep' => (bool) ($valaiation->pep ?? false),
            'product_risk' => $valaiation->product_risk ?? null,

            // ✅ País de residência
            'country_residence' => optional($valaiation->country_residence)->description
                ?? optional($this->indicatorType->model::find($valaiation->country_residence))->description
                ?? null,



            // ✅ Nacionalidade
            'nationality' => optional($valaiation->nationality)->description
                ?? optional($this->indicatorType->model::find($valaiation->nationality))->description
                ?? null,

            // ✅ Outros campos
            'punctuation' => $valaiation->score ?? null,
            'risk_level' => $entite->risk_level,
            'diligence' => $entite->diligence,
            'last_evaluation' => $entite->last_evaluation,
            'created_at' => $entite->created_at,
            'color' => $entite->color,
            'alerts_count' => $alerts_entitie,
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
