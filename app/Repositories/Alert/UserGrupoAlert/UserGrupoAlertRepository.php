<?php
namespace App\Repositories\Alert\UserGrupoAlert;

use App\Models\Alert\UserGrupoAlert\UserGrupoAlert;
use App\Repositories\AbstractRepository;

class UserGrupoAlertRepository extends AbstractRepository
{
    public function __construct(UserGrupoAlert $model)
    {
        parent::__construct($model);
    }

    public function storeMany($data)
    {
        $now = now();
    return $this->model->upsert(
        collect($data)->map(function ($item) use ($now) {
            return array_merge($item, [
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        })->toArray(),
        ['alert_id', 'user_id']      
    );
    }
}