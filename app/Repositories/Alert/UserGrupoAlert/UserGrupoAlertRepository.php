<?php
namespace App\Repositories\Alert\UserGrupoAlert;

use App\Models\Alert\UserGrupoAlert\UserGrupoAlert;
use App\Repositories\AbstractRepository;
use Illuminate\Support\Facades\DB;

class UserGrupoAlertRepository extends AbstractRepository
{
    public function __construct(UserGrupoAlert $model)
    {
        parent::__construct($model);
    }

    public function storeMany($data)
    {
        $now = now();
    // Extrai todas as combinações que devem existir
    $current = collect($data)->map(fn($item) => [
        'grup_alert_id' => $item['grup_alert_id'],
        'user_id'       => $item['user_id'],
    ]);

    // Atualiza ou cria os que vieram no array
    foreach ($current as $item) {
        $this->model->updateOrCreate(
            [
                'grup_alert_id' => $item['grup_alert_id'],
                'user_id' => $item['user_id'],
            ],
            [
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
    }

    // Apaga os que não vieram (não estão no array)
    $this->model->whereNotIn(DB::raw('(grup_alert_id, user_id)'), $current->map(fn($i) => "({$i['grup_alert_id']}, {$i['user_id']})")->toArray())->delete();

     }
}