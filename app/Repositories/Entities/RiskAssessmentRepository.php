<?php

namespace App\Repositories\Entities;

use App\Enum\TypeEntity;
use Illuminate\Support\Facades\DB;
use App\Models\entities\RiskAssessment;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Collection;

class RiskAssessmentRepository extends AbstractRepository
{
    private const RISK_LEVELS = [
        'Baixo' => 'total_baixo',
        'Médio' => 'total_medio',
        'Alto' => 'total_alto'
    ];

    private const DEFAULT_RESULT = [
        'name' => 'N/A',
        'total_baixo' => 0,
        'total_medio' => 0,
        'total_alto' => 0,
        'total_geral' => 0
    ];

    public function __construct(RiskAssessment $model)
    {
        parent::__construct($model);
    }

    /**
     * Generate risk level summary by entity type and grouping field
     *
     * @param string $groupByField Field to group by
     * @param string|null $joinTable Table to join for description (null for PEP)
     * @param string $nameField SQL expression for name column
     * @return array
     */
    private function getRiskLevelSummary(string $groupByField, ?string $joinTable, string $nameField): array
    {
        $results = [
            'coletive' => [],
            'individual' => []
        ];

        foreach (['coletive' => TypeEntity::COLECTIVA, 'individual' => TypeEntity::SINGULAR] as $key => $type) {
            $query = $this->model
                ->join('entities', 'risk_assessment.entity_id', '=', 'entities.id')
                ->where('entities.entity_type', $type);

            if ($joinTable) {
                $query->join('indicator_type', 'indicator_type.id', '=', $groupByField);
            }

            $select = array_merge(
                [DB::raw("$nameField AS name")],
                array_map(
                    fn($level, $field) => DB::raw("SUM(CASE WHEN risk_assessment.risk_level = '$level' THEN 1 ELSE 0 END) AS $field"),
                    array_keys(self::RISK_LEVELS),
                    self::RISK_LEVELS
                ),
                [DB::raw('COUNT(*) AS total_geral')]
            );

            $data = $query
                ->select($select)
                ->groupBy("risk_assessment.$groupByField")
                ->get();

            $results[$key] = $this->formatResults($data);
        }

        return $results;
    }

    /**
     * Format query results into standardized array structure
     *
     * @param Collection $data Query results
     * @return array
     */
    private function formatResults(Collection $data): array
    {
        if ($data->isEmpty()) {
            return [self::DEFAULT_RESULT];
        }

        return $data->map(fn($item) => [
            'name' => $item->name ?? self::DEFAULT_RESULT['name'],
            'total_baixo' => $item->total_baixo ?? 0,
            'total_medio' => $item->total_medio ?? 0,
            'total_alto' => $item->total_alto ?? 0,
            'total_geral' => $item->total_geral ?? 0
        ])->toArray();
    }

    public function totalRiskLevelByCategory(): array
    {
        return $this->getRiskLevelSummary(
            'category',
            'indicator_type',
            'indicator_type.description'
        );
    }

    public function totalRiskLevelByProfession(): array
    {
        return $this->getRiskLevelSummary(
            'profession',
            'indicator_type',
            'indicator_type.description'
        );
    }

    public function totalRiskLevelByChannel(): array
    {
        return $this->getRiskLevelSummary(
            'channel',
            'indicator_type',
            'indicator_type.description'
        );
    }

    public function totalRiskLevelByNationality(): array
    {
        return $this->getRiskLevelSummary(
            'nationality',
            'indicator_type',
            'indicator_type.description'
        );
    }

    public function totalRiskLevelByPep(): array
    {
        return $this->getRiskLevelSummary(
            'pep',
            null,
            '(CASE WHEN pep = 1 THEN "SIM" ELSE "NÃO" END)'
        );
    }

    public function totalRiskLevelByCountryResidence(): array
    {
        return $this->getRiskLevelSummary(
            'country_residence',
            'indicator_type',
            'indicator_type.description'
        );
    }
}
