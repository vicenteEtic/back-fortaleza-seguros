<?php

namespace App\Repositories\Entities;

use App\Enum\TypeEntity;
use App\Models\Entities\Entities;
use App\Repositories\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;

class EntitiesRepository extends AbstractRepository
{
    public function __construct(Entities $model)
    {
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
        $query = $this->model->query();
    
        if (!empty($relationships)) {
            $query = $query->with($relationships);
        }
    
        // adiciona total_alerts
        $query = $query->withCount('alerts');
    
        return $query->findOrFail($id);
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
