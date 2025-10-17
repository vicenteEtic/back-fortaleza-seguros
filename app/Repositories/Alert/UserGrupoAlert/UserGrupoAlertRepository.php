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
    foreach ($data as $item) {
        $this->model->updateOrCreate(
            [
                'grup_alert_id' => $item['grup_alert_id'],
                'user_id' => $item['user_id'],
            ],
            [
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );
    }
     }
}